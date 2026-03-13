<?php
class Database {

    private static $instance = null;
    private $host = "localhost";
    private $db_name = "cafeteria_db";
    private $username = "cafeteria_admin";
    private $password = "1234";
    public $conn;

    public  function  __construct(){
        if(self::$instance !== null){
            return self::$instance;
        }
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        self::$instance = $this;
    }
    public function getConnection() {
        return $this->conn;
    }
}
?>
