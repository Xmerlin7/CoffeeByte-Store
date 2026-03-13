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
    public function save(){

        $sql = "INSERT INTO orders (user_id, total_price, status, notes, order_date)
                VALUES (:user_id, :total_price, :status, :notes, :order_date)";

        $stmt = $this->pdo->prepare($sql);

        $result = $stmt->execute([
            ':user_id' => $this->user_id,
            ':total_price' => $this->total_price,
            ':status' => $this->status,
            ':notes' => $this->notes,
            ':order_date' => $this->order_date
        ]);

        if($result){
            echo "New order created successfully";
        }else{
            echo "Error inserting order";
        }

        $this->pdo = null;
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