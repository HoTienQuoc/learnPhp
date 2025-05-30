<?php
namespace Php8\Project2\Service;

use Php8\Project2\DAL\UserDal;
use Php8\Project2\Validation\Exception\InvalidValidationException;
use Php8\Project2\Validation\UserValidation;
use Php8\Project2\Entity\User as UserEntity;

use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;

class User
{
    public const DATE_TIME_FORMAT = "Y-m-d H:i:s";

    // public function create(object $data): self // <- can still be valid
    public function create(mixed $data): array|object
    {
        // validate data
        $userValidation = new UserValidation($data);
        if ($userValidation->isCreationSchemaValid()) {
            $userUuid = Uuid::uuid4()->toString(); // assigning a UUID to the user
            $userEntity = new UserEntity();
            $userEntity
                ->setUserUuid($userUuid)
                ->setFirstName($data->first)
                ->setLastName($data->last)
                ->setEmail($data->email)
                ->setPhone($data->phone)
                ->setCreationDate(date(self::DATE_TIME_FORMAT));
            if (UserDal::create($userEntity) === false) {
                // Set an internal error 500 when we cannot add an entry to the database
                Http::setHeadersByCode(StatusCode::INTERNAL_SERVER_ERROR);
                // Set to empty result, because an issue happened. The client has to handle this properly
                $data = [];
            }
            Http::setHeadersByCode(StatusCode::CREATED);
            return $data; // return statement exists the function and doesn't go beyond this scope
        }
        throw new InvalidValidationException("Invalid user payload");
    }

    public function update(mixed $postBody): array|object
    {
        $userValidation = new UserValidation($postBody);
        if ($userValidation->isUpdateSchemaValid()) {
            $userUuid = $postBody->userUuid;
            $userEntity = new UserEntity();
            if (!empty($postBody->first)) {
                $userEntity->setFirstName($postBody->first);
            }
            if (!empty($postBody->last)) {
                $userEntity->setLastName($postBody->last);
            }
            if (!empty($postBody->phone)) {
                $userEntity->setPhone($postBody->phone);
            }
            if (UserDal::update($userUuid, $userEntity) === false) {
                // Set an internal error 500 when we cannot add an entry to the database
                Http::setHeadersByCode(StatusCode::INTERNAL_SERVER_ERROR);
                // If invalid or got an error, give back an empty response
                return [];
            }
            // if invalid, give back an empty response
            return $postBody;
        }
        throw new InvalidValidationException("Invalid user payload");
    }

    public function retrieveAll(): array
    {
        $users = UserDal::getAll();

        return array_map(function (object $user): object {
            // Remove unnecessary "id" field
            unset($user["id"]);
            return $user;
        }, $users);
    }

    public function retrieve(string $userUuid): array
    {
        if (v::uuid()->validate($userUuid)) {
            if ($user = UserDal::get($userUuid)) {
                // Removing fields we don't want to expose
                unset($user["id"]);

                return $user;
            }
            return [];
        }
        throw new InvalidValidationException("Invalid user UUID");
    }
    /**
     * @internal Set `mixed` type, because if we get an incorrect payload with syntax errors, `json_decode` gives NULL,
     * and `object` wouldn't be a valid datatype here.
     */
    public function remove(mixed $data): bool
    {
        $userValidation = new UserValidation($data);
        if ($userValidation->isRemoveSchemaValid()) {
            // Send a 204 if the user got removed
            //Http::setHeadersByCode(StatusCode::NO_CONTENT);
            return UserDal::remove($data->userUuid);
        }
        throw new InvalidValidationException("Invalid user UUID");
    }
}
