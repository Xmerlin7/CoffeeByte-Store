<?php 

// create the Order class


class order{
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
    public function __construct($pdo,$user_id, $total_price, $status, $notes, $order_date){
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
    
    public function createOrder($room_id, $notes = null)
    {
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

            // get cart items
            $stmt = $this->pdo->prepare("
                SELECT product_id, quantity, unit_price
                FROM cart_items
                WHERE cart_id = ?
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

            $stmt->execute([
                $this->user_id,
                $room_id,
                $total,
                $notes
            ]);

            $order_id = $this->pdo->lastInsertId();

            // insert order items
            $stmt = $this->pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, unit_price)
                VALUES (?, ?, ?, ?)
            ");

            foreach($items as $item){
                $stmt->execute([
                    $order_id,
                    $item['product_id'],
                    $item['quantity'],
                    $item['unit_price']
                ]);
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
            return false;
        }
    }


    public function updateStatus($new_status){
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':status' => $new_status,
            ':id' => $this->id
        ]);

        if($result){
            echo "Order status updated successfully";
        }else{
            echo "Error updating order status";
        }

        $this->pdo = null;
    }

}




?>