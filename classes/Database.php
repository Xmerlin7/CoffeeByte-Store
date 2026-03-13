<?php
class Database {
    private $host = "localhost";
    private $db_name = "cafeteria_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        // If a connection already exists, reuse it
        if (self::$instance !== null) {
            $this->conn = self::$instance->conn;
            return;
        }

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            self::$instance = $this; // save first instance
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->conn;
    }
}