<?php

namespace App\Http\Controllers\Api;

use Exception;
use Repositories\UserRepository;
use User;

class AuthController
{

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws Exception
     */
    public function register(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        ?string $phone = null,
    ): string
    {
        $user = new User(
            firstname: $firstName,
            lastname: $lastName,
            email: $email,
            password: $password,
            phone: $phone
        );

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception('Email is invalid!');

        $this->userRepository->create($user);
        return json_encode(['message' => 'Successfully created!', 'code' => 200]);
    }

    /**
     * @throws Exception
     */
    public function auth(
        string $email,
        string $password
    ): string
    {
        $user = $this->userRepository->getByEmail($email);

        // :TODO -> HASH PASSWORD
        if ($user->getPassword() != $password)
            throw new Exception('Password does not match');

        // :TODO -> JWT TOKEN OR SESSION
        return json_encode(['message' => 'Successfully authorized!', 'code' => 200]);
    }
}