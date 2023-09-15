<?php

namespace Service;

use Exception;
use mysqli;

class Database
{
    /**
     * @param string|null $hostname
     * @param string|null $dbname
     * @param string|null $username
     * @param string|null $password
     * @param int|null $port
     * @return mysqli
     * @throws Exception
     */
    public static function openConnection(
        string $hostname = null,
        string $dbname = null,
        string $username = null,
        string $password = null,
        int $port = null
    ): mysqli
    {
        $hostname = $hostname ?? getenv('DB_HOST');
        $dbname = $dbname ?? getenv('DB_NAME');
        $username = $username ?? getenv('DB_USERNAME');
        $password = $password ??getenv('DB_PASSWORD');
        $port = $port ?? getenv('db_port');

        $resource = mysqli_connect($hostname, $username, $password, $dbname, $port);
        if ($resource === false)
            throw new Exception('Unable to open connection');

        return $resource;
    }

    /**
     * @param mysqli $conn
     * @return bool
     */
    public static function closeConnection(
        mysqli $conn
    ): bool
    {
        return mysqli_close($conn);
    }

}