<?php

namespace App\Http\Controllers\Api;

class AuthController
{

    public function register(
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        ?string $password = null
    ): void
    {
        var_dump($firstName);
        var_dump($lastName);
        var_dump($email);
        var_dump($phone);
        var_dump($password);
    }

    public function auth()
    {

    }
}