<?php
namespace project1;

use project1\kernel\http\router;
use project1\kernel\phptemplate\ViewNotFound;

try {
    router::get("/", "homeController@index");
    router::get("/edit", "homeController@edit");
    router::get("/signup", "account@signup");
    router::get("/signin", "account@signin");
} catch (ViewNotFound $e) {
    echo $e->getMessage();
}
