<?php
require_once __DIR__ . '/Database.php';

class Category {
    private $conn;
    private $table = 'categories';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // ── CREATE ────────────────────────────────────────────
    public function create(string $name): bool {
        $query = "INSERT INTO {$this->table} (name) VALUES (:name)";
        $stmt  = $this->conn->prepare($query);
        return $stmt->execute([':name' => trim($name)]);
    }

    // ── READ ALL ──────────────────────────────────────────
    public function getAll(): array {
        $query = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ── READ ONE ──────────────────────────────────────────
    public function getById(int $id): array|false {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ── UPDATE ────────────────────────────────────────────
    public function update(int $id, string $name): bool {
        $query = "UPDATE {$this->table} SET name = :name WHERE id = :id";
        $stmt  = $this->conn->prepare($query);
        return $stmt->execute([
            ':id'   => $id,
            ':name' => trim($name)
        ]);
    }

    // ── DELETE ────────────────────────────────────────────
    public function delete(int $id): bool {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt  = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    // ── EXISTS (check duplicate name) ─────────────────────
    public function nameExists(string $name, int $excludeId = 0): bool {
        $query = "SELECT COUNT(*) FROM {$this->table}
                  WHERE name = :name AND id != :exclude";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute([':name' => trim($name), ':exclude' => $excludeId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // ── COUNT products in a category ─────────────────────
    public function countProducts(int $id): int {
        $query = "SELECT COUNT(*) FROM products WHERE category_id = :id";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return (int)$stmt->fetchColumn();
    }
}
?>