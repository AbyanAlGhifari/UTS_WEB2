<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $db_name = 'university';
    private $username = 'root';
    private $password = '';
    private static $conn = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                $db = new Database();
                self::$conn = new PDO(
                    "mysql:host={$db->host};dbname={$db->db_name}",
                    $db->username,
                    $db->password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
