<?php
session_start();

require_once "../../classes/Database.php";
require_once "../../classes/Cart.php";

$db = (new Database())->getConnection();

// $user_id = $_SESSION['user_id'];
$user_id = 2;

$product_id = $_POST['product_id'];
$qty = $_POST['quantity'];

$cart = new Cart($db,$user_id);

$cart->updateQuantity($product_id,$qty);

echo json_encode(["success"=>true]);
?>