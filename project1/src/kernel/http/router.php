<?php
declare(strict_types=1);
namespace project1\kernel\http;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class router
{
    private const CONTROLLER_NAMESPACE = "project1\controller\\";
    private const SEPERATOR = "@";

    public const METHOD_GET = "GET";
    public const METHOD_POST = "POST";

    private static ?string $httpMethod = null;

    public static function get(string $uri, string $classMethod = ""): void
    {
        self::$httpMethod = self::METHOD_GET;
        self::execute($uri, $classMethod);
    }

    public static function post(string $uri, string $classMethod = ""): void
    {
        self::$httpMethod = self::METHOD_POST;
        self::execute($uri, $classMethod);
    }
    /**
     * @return mixed
     */
    public static function execute(string $uri, string $method)
    {
        // Execute logic
        $uri = "/" . trim($uri, "/");
        $url = !empty($_GET["uri"]) ? "/" . $_GET["uri"] : "/";

        if (preg_match("#^$uri$#", $url, $params)) {
            if (self::isController($method)) {
                // Execute controller logic
                header(sprintf("Location: %s/%s", $_ENV["SITE_URL"], $method));
            } elseif (self::isHttpMethodValid()) {
                $split = explode(self::SEPERATOR, $method);
                $className = self::CONTROLLER_NAMESPACE . $split[0];
                $method = $split[1];
                try {
                    $reflection = new ReflectionClass($className);
                    if (
                        class_exists($className) &&
                        $reflection->hasMethod($method)
                    ) {
                        $action = new ReflectionMethod($className, $method);
                        if ($action->isPublic()) {
                            return $action->invokeArgs(
                                new $className(),
                                self::getActionParameters($params)
                            );
                        }
                    }
                } catch (ReflectionException $err) {
                    echo $err->getMessage();
                }
            }
        } else {
            throw new InvalidArgumentException(
                sprintf('Invalid "%s" HTTP Request', $_SERVER["REQUEST_METHOD"])
            );
        }
    }

    private static function isHttpMethodValid(): bool
    {
        return self::$httpMethod !== null &&
            $_SERVER["REQUEST_METHOD"] === self::$httpMethod;
    }

    /**
     * @return array<string,string[]>
     * @param array<int,mixed> $params
     */
    private static function getActionParameters(array $params): array
    {
        foreach ($params as $key => $value) {
            $params[$key] = str_replace("/", "", $params);
        }
        return $params;
    }

    private static function isController(string $method): bool
    {
        return !str_contains($method, self::SEPERATOR);
    }
}
