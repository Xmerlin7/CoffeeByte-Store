<?php
header('Content-Type: application/json');
session_start();

require_once "../../classes/Database.php";
require_once "../../classes/Cart.php";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
	http_response_code(401);
	echo json_encode(["success" => false, "message" => "Unauthorized"]);
	exit;
}

$product_id = (int)($_POST['product_id'] ?? 0);
$qty = (int)($_POST['quantity'] ?? 0);
if ($product_id <= 0) {
	http_response_code(422);
	echo json_encode(["success" => false, "message" => "Invalid product"]);
	exit;
}

try {
	$db = (new Database())->getConnection();
	$cart = new Cart($db, $user_id);
	$cart->updateQuantity($product_id, $qty);
	echo json_encode(["success" => true]);
} catch (Throwable $e) {
	http_response_code(500);
	echo json_encode(["success" => false, "message" => "Server error"]);
}
?>