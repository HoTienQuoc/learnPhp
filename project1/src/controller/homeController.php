<?php
declare(strict_types=1);
namespace project1\controller;

use project1\kernel\phptemplate\view;

class homeController
{
    public function index(): void
    {
        view::render("home/index", "homepage", ["name" => "John"]);
    }
    public function edit(): void
    {
        echo "Edit page";
    }
}
