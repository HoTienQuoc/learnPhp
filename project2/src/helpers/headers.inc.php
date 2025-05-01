<?php
namespace Php8\Project2;
use PH7\PhpHttpResponseHeader\Http;

(new AllowCors())->init();
Http::setContentType("application/json");
