<?php
namespace project1\kernel;

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
    public function run(): void
    {
        $this->initialize();
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
