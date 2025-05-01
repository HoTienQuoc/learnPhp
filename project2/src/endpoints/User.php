<?php
namespace Php8\Project2;

use Php8\Project2\Validation\Exception\InvalidValidationException;
use Php8\Project2\Validation\UserValidation;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;

class User
{
    public readonly ?string $userId;
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone
    ) {
        // Constructor logic
    }

    public function create(mixed $data): object
    {
        // validation schema
        $userValidation = new UserValidation($data);
        if ($userValidation->isCreationSchemaValid()) {
            $data->userId = Uuid::uuid4(); // assigning a UUID to the user
            return $data; // return statement exists the function and doesn't go beyond this scope
        }
        throw new InvalidValidationException("Invalid user payload");
    }

    public function retrieveAll(): array
    {
        return [];
    }

    public function retrieve(string $userId): self
    {
        if (v::uuid()->validate($userId)) {
            $this->userId = $userId;
            return $this;
        }
        throw new InvalidValidationException("Invalid user UUID");
    }

    public function update(mixed $postBody): object
    {
        // TODO Update `$postBody` to the DAL later on (for updating the database)
        // validation schema
        $userValidation = new UserValidation($postBody);
        if ($userValidation->isUpdateSchemaValid()) {
            return $postBody;
        }
        throw new InvalidValidationException("Invalid user payload");
    }

    public function delete(string $userId): bool
    {
        if (v::uuid()->validate($userId)) {
            $this->userId = $userId;
        } else {
            throw new InvalidValidationException("Invalid user UUID");
        }
        // TODO Lookup the the DB user row with this userId
        return true; // default value
    }
}
