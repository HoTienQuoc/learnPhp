<?php
require __DIR__ . "/vendor/autoload.php";
use project1\kernel\bootstrap;

ob_start();
$app = new bootstrap();
$app->run();
ob_end_flush();
