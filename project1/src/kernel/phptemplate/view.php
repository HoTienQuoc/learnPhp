<?php
namespace project1\kernel\phptemplate;

final class view
{
    private const MESSAGES = [
        "NOT_FOUND_FILENAME" => "View '%s' not found",
    ];
    private const NOT_FOUND_FILENAME_ERROR_MESSAGES = "View '%s' not found";
    private const PATH = __DIR__ . "/../../../templates/";
    private const FILE_EXTENSION = ".html.php";

    public static function render(string $view, string $title, array $context)
    {
        extract($context);
        require self::PATH . "_partials/header.inc.html.php";
        if (self::isViewExists($view)) {
            include_once self::PATH . $view . self::FILE_EXTENSION;
        } else {
            throw new ViewNotFound(
                sprintf(
                    self::MESSAGES["NOT_FOUND_FILENAME"],
                    $view . self::FILE_EXTENSION
                )
            );
        }
        require self::PATH . "_partials/footer.inc.html.php";
    }

    private static function isViewExists(string $fileName): bool
    {
        return is_file(self::PATH . $fileName . self::FILE_EXTENSION);
    }
}
