<?php 

// create the Order class


class Order{
    // properties 
    private $pdo;
    private $id;
    private $user_id;
    private $room_id;
    private $total_price;
    private $status;
    private $notes;
    private $order_date;

    // constructor
    public function __construct($pdo, $user_id = null, $total_price = null, $status = null, $notes = null, $order_date = null){
        $this->pdo = $pdo;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->status = $status;
        $this->notes = $notes;
        $this->order_date = $order_date;
    }

    // getters 
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getTotalPrice(){
        return $this->total_price;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getNotes(){
        return $this->notes;
    }
    public function getOrderDate(){
        return $this->order_date;
    }


    // setters 
    public function setStatus($status){
        $this->status = $status;
    }
    public function setNotes($notes){
        $this->notes = $notes;
    }

    // method to save the order to the database
    
    // CREATE ORDER FROM CART
    public function createOrder($room_id, $notes = null){
    try {

        $this->pdo->beginTransaction();

        // get user's cart
        $stmt = $this->pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$this->user_id]);

        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$cart){
            throw new Exception("Cart not found");
        }

        $cart_id = $cart['id'];

        // get cart items with product price
        $stmt = $this->pdo->prepare("
            SELECT 
                ci.product_id,
                ci.quantity,
                p.price AS unit_price
            FROM cart_items ci
            JOIN products p ON p.id = ci.product_id
            WHERE ci.cart_id = ?
        ");
        $stmt->execute([$cart_id]);

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$items){
            throw new Exception("Cart is empty");
        }

        // calculate total price
        $total = 0;
        foreach($items as $item){
            $total += $item['quantity'] * $item['unit_price'];
        }

        // create order
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (user_id, room_id, total_price, notes)
            VALUES (?, ?, ?, ?)
        ");

        $res = $stmt->execute([
            $this->user_id,
            $room_id,
            $total,
            $notes
        ]);

        if (!$res) {
            $err = $stmt->errorInfo();
            throw new Exception('Insert order failed: ' . ($err[2] ?? 'unknown'));
        }

        $order_id = $this->pdo->lastInsertId();

        // insert order items
        $stmt = $this->pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, unit_price)
            VALUES (?, ?, ?, ?)
        ");

        foreach($items as $item){
            $res = $stmt->execute([
                $order_id,
                $item['product_id'],
                $item['quantity'],
                $item['unit_price']
            ]);

            if (!$res) {
                $err = $stmt->errorInfo();
                throw new Exception('Insert order_item failed: ' . ($err[2] ?? 'unknown'));
            }
        }

        /**
         * IMPORTANT TEAM NOTE (Dev5 -> Dev4)
         * Cart is cleared after checkout
         */
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cart_id]);

        $this->pdo->commit();

        return $order_id;

    } catch(Exception $e){

        $this->pdo->rollBack();
        // echo "CreateOrder error: " . $e->getMessage();
        return false;
    }
    }


    // GET USER ORDERS

    public function getUserOrders(){
        $stmt = $this->pdo->prepare("
            SELECT o.*, r.room_number
            FROM orders o
            LEFT JOIN rooms r ON o.room_id = r.id
            WHERE o.user_id = ?
            ORDER BY o.order_date DESC
        ");

        $stmt->execute([$this->user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // FILTER ORDERS BY DATE

    public function getOrdersByDateRange($from, $to){

        $stmt = $this->pdo->prepare("
            SELECT *
            FROM orders
            WHERE user_id = ?
            AND DATE(order_date) BETWEEN ? AND ?
        ");

        $stmt->execute([$this->user_id, $from, $to]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // GET ORDER ITEMS
    
    public function getOrderItems($order_id){
        $stmt = $this->pdo->prepare("
            SELECT 
                p.name,
                oi.quantity,
                oi.unit_price,
                (oi.quantity * oi.unit_price) AS subtotal
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");

        $stmt->execute([$order_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // CANCEL ORDER
    
    public function cancelOrder($order_id){
        $stmt = $this->pdo->prepare("
            SELECT status
            FROM orders
            WHERE id = ? AND user_id = ?
        ");

        $stmt->execute([$order_id, $this->user_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$order || $order['status'] !== 'processing'){
            return false;
        }

        $stmt = $this->pdo->prepare("
            UPDATE orders
            SET status = 'cancelled'
            WHERE id = ?
        ");

        return $stmt->execute([$order_id]);
    }



    // ADMIN: GET ALL ORDERS
    
    public function getAllOrders(){
        $stmt = $this->pdo->prepare("
            SELECT 
                o.id,
                u.name AS user,
                r.room_number,
                o.total_price,
                o.status,
                o.order_date
            FROM orders o
            JOIN users u ON o.user_id = u.id
            LEFT JOIN rooms r ON o.room_id = r.id
            ORDER BY o.order_date DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // ADMIN: UPDATE ORDER STATUS
    
    public function updateStatus($order_id, $status){
        $allowed = ['processing','out_for_delivery','delivered'];

        if(!in_array($status, $allowed)){
            return false;
        }

        $stmt = $this->pdo->prepare("
            UPDATE orders
            SET status = ?
            WHERE id = ?
        ");

        return $stmt->execute([$status,$order_id]);
    }

}





















?>