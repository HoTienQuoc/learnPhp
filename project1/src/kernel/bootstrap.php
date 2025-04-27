<?php
namespace project1\Kernel;

use Symfony\Component\Dotenv\Dotenv;
final class bootstrap
{
    private $routes;
    public function __construct()
    {
        $dotenv = new Dotenv();
        $this->loadEnvironmentVariables($dotenv);
        echo $_ENV["SITE_NAME"];
    }
    private function initialize()
    {
        // Initialize the routes
    }
    private function loadEnvironmentVariables(Dotenv $dotenv): void
    {
        $dotenv->load(__DIR__ . "/.env");
    }
}
