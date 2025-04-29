<?php
declare(strict_types=1);

function site_url(string $value = "")
{
    if (!empty($value)) {
        return $_ENV["SITE_URL"] . $value;
    }
    return $_ENV["SITE_URL"];
}
