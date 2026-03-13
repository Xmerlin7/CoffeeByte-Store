<?php
require_once __DIR__ . '/../classes/Database.php';

class Room {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllRooms() {
        $stmt = $this->conn->prepare("SELECT * FROM rooms");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRoom($room_number) {
        $stmt = $this->conn->prepare("INSERT INTO rooms (room_number) VALUES (?)");
        $stmt->execute([$room_number]);
    }

    public function updateRoom($id, $room_number) {
        $stmt = $this->conn->prepare("UPDATE rooms SET room_number = ? WHERE id = ?");
        $stmt->execute([$room_number, $id]);
    }

    public function deleteRoom($id) {
        $stmt = $this->conn->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
    }
}