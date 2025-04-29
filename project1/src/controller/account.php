<?php
declare(strict_types=1);
namespace project1\controller;

use project1\kernel\phptemplate\view;

class account
{
    public function signup(): void
    {
        view::render("account/signup", "Signup");
    }
    public function signin(): void
    {
        view::render("account/signin", "Signin");
    }
    public function edit(): void
    {
        view::render("account/edit", "Edit");
    }
}
