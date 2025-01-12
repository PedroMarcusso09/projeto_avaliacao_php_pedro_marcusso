<?php

define('HOST', 'localhost');
define('DATABASENAME', 'employees');
define('USER', 'root');
define('PASSWORD', '');

class Connect {
    public static $connection;

    public static function connectDatabase() {
        if (!self::$connection) {
            try {
                self::$connection = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASENAME, USER, PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die('Database connection error. Please try again later.');
            }
        }
        return self::$connection;
    }
}

Connect::connectDatabase();

?>