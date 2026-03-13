<?php
class Cart
{
    private $pdo, $user_id, $cart_id;

    public function __construct($pdo, $user_id)
    {
        $this->pdo = $pdo;
        $this->user_id = $user_id;
        $this->cart_id = $this->getOrCreateCart();
    }

    private function getOrCreateCart()
    {
        $stmt = $this->pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$this->user_id]);

        $cart = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cart)
            return $cart['id'];

        $stmt = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->execute([$this->user_id]);

        return $this->pdo->lastInsertId();
    }

    public function addProduct($product_id, $quantity = 1)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO cart_items (cart_id, product_id, quantity)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
        ");

        return $stmt->execute([
            $this->cart_id,
            $product_id,
            $quantity
        ]);
    }

    public function removeProduct($product_id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM cart_items
            WHERE cart_id = ? AND product_id = ?
        ");

        return $stmt->execute([
            $this->cart_id,
            $product_id
        ]);
    }

    public function updateQuantity($product_id, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeProduct($product_id);
        }

        $stmt = $this->pdo->prepare("
            UPDATE cart_items
            SET quantity = ?
            WHERE cart_id = ? AND product_id = ?
        ");

        return $stmt->execute([
            $quantity,
            $this->cart_id,
            $product_id
        ]);
    }

    public function getItems()
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.name,
                p.price,
                ci.quantity,
                (p.price * ci.quantity) AS total
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?
        ");

        $stmt->execute([$this->cart_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal()
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(p.price * ci.quantity) AS total
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?
        ");

        $stmt->execute([$this->cart_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public function getCount()
    {
        $stmt = $this->pdo->prepare("
            SELECT SUM(quantity) AS count
            FROM cart_items
            WHERE cart_id = ?
        ");

        $stmt->execute([$this->cart_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    }
}
