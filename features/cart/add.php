<?php
session_start();

require_once "../../classes/Database.php";
require_once "../../classes/Cart.php";

$db = (new Database())->getConnection();

// $user_id = $_SESSION['user_id'];
$user_id = 2;

$product_id = $_POST['product_id'];

$cart = new Cart($db,$user_id);

$cart->addProduct($product_id,1);

echo json_encode(["success"=>true]);
?>
