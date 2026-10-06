<?php

namespace Model;

use PDO;
use PDOException;

require_once __DIR__ . "/../Config/Configuration.php";

class Connection {

    private static $stmt;

    public static function getInstance():PDO 
    {
    if (empty(self::$stmt)) {
        try {
            self::$stmt = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]);
            } catch (PDOException $error) {
                die("Erro de conexão:". $error->getMessage());
            }
        }
        return self::$stmt;
    }
}