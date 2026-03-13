<?php
require_once 'Database.php';


class Product{
    private $conn;
    private $table = "products";

    public function __construct(){
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function create($name, $price, $category_id, $image, $status='available'){
        $query = "insert into {$this->table} (name, price, category_id, image, status) values (:name, :price, :category_id, :image, :status)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':name' =>$name,
            ':price' =>$price,
            'category_id' =>$category_id,
            ':image'=>$image,
            ':status'=>$status
        ]);
    }

    public function getAll(){
        $query = "select * from {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id){
        $query = "select * from {$this->table} where id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id, $name, $price, $category_id, $image, $status) {

        $query = "UPDATE {$this->table}
                  SET name = :name,
                      price = :price,
                      category_id = :category_id,
                      image = :image,
                      status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':price' => $price,
            ':category_id' => $category_id,
            ':image' => $image,
            ':status' => $status
        ]);
    }

    // DELETE PRODUCT
    public function delete($id) {

        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

}
?>