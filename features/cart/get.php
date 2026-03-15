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

$action = $_GET['action'] ?? null;

try {
    $db = (new Database())->getConnection();
    $cart = new Cart($db, $user_id);
    $items = $cart->getItems();

    if ($action !== "state") {
        echo json_encode($items);
    } else {
        $result = [];
        foreach ($items as $item) {
            $result[] = [
                "product_id" => $item["id"],
                "quantity" => $item["quantity"]
            ];
        }
        echo json_encode($result);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error"]);
}
?>