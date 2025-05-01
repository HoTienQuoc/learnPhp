<?php
namespace Php8\Project2;
use Exception;
use PH7\JustHttp\StatusCode;
use PH7\PhpHttpResponseHeader\Http;
use Php8\Project2\Validation\Exception\InvalidValidationException;
require_once dirname(__DIR__) . "/endpoints/User.php";

enum UserAction: string
{
    case CREATE = "create";
    case RETRIEVE = "retrieve";
    case RETRIEVE_ALL = "retrieveAll";
    case UPDATE = "update";
    case DELETE = "delete";
    public function getRespone(): string
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);
        $userId = $_GET["user_id"] ?? null; // using the null coalescing operator
        $user = new User("Pierre", "pierre@example.com", "123456");
        try {
            $response = match ($this) {
                self::CREATE => $user->create($postBody),
                self::RETRIEVE_ALL => $user->retrieveAll(),
                self::RETRIEVE => $user->retrieve($userId),
                self::DELETE => $user->delete($userId),
                self::UPDATE => $user->update($postBody),
            };
        } catch (InvalidValidationException | Exception $e) {
            // TODO Send 400 status code with header()
            Http::setHeadersByCode(StatusCode::BAD_REQUEST);
            $response = [
                "errors" => [
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                ],
            ];
        }
        return json_encode($response);
    }
}

$action = $_GET["action"] ?? null;
$userAction = match ($action) {
    "create" => UserAction::CREATE,
    "retrieve" => UserAction::RETRIEVE,
    "retrieveAll" => UserAction::RETRIEVE_ALL,
    "update" => UserAction::UPDATE,
    "delete" => UserAction::DELETE,
};
echo $userAction->getRespone();
