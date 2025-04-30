<?php
namespace Php8\Project2;
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
        $user = new User("Pierre", "pierre@example.com", "123456");
        $userId = !empty($_GET["user_id"]) ? (int) $_GET["user_id"] : 0;
        $response = match ($this) {
            self::CREATE => $user->create(),
            self::RETRIEVE => $user->retrieve($userId),
            self::RETRIEVE_ALL => $user->retrieveAll(),
            self::UPDATE => $user->update($userId),
            self::DELETE => $user->delete($userId),
        };
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
