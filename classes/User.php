<?php
require_once __DIR__ . '/../classes/Database.php';
class User {
    private $conn;
    public function __construct($conn){
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        $statement = $this->conn->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>