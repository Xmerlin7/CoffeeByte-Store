<?php
session_start();

require_once "../../classes/Database.php";
require_once "../../classes/Cart.php";

$db = (new Database())->getConnection();
// $user_id = $_SESSION['user_id'];
$user_id = 2;

$action = $_GET['action'];
$cart = new Cart($db,$user_id);

$items = $cart->getItems();

if (!$action || $action != "state" ) {
    echo json_encode($items);
    } else {
        $result = [];
        foreach($items as $item){
            $result[] = [
                "product_id"=>$item["id"],
                "quantity"=>$item["quantity"]
            ];  
        }
        echo json_encode($result);
        }
?>