<?php

namespace Repositories;

use Exception;
use mysqli_result;
use ReflectionClass;
use Service\Database;
use User;

class UserRepository
{

    /**
     * @throws Exception
     */
    public function create(User $user): void
    {
        $conn = Database::openConnection();
        $conn->query($user->getInsertSql());
        Database::closeConnection($conn);
    }

    /**
     * @throws Exception
     */
    public function getByEmail(string $email): User
    {
        $tableName = User::TABLE_NAME;
        $conn = Database::openConnection();
        $result = $conn->query("SELECT * FROM $tableName WHERE email = '$email' LIMIT 1")->fetch_assoc();

        if (!$result)
            throw new Exception('User with given email does not found!');

        $reflection = new ReflectionClass(User::class);
        return $reflection->newInstanceArgs($result);
    }
}