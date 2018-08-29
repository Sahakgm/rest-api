<?php

/**
 * Class PDOConnection
 */
class PDOConnection {
    private function __construct() {}

    public static function getConnection() {
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $name = DB_NAME;
        $dsn = "mysql:host=$host;dbname=$name;charset=utf8";

        try {
            $connection = new PDO($dsn, $user, $pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Return the connection
            //echo "connected";
            return $connection;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}



