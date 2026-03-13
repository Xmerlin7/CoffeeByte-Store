<?php
require_once 'classes/Database.php';
require_once 'classes/Cart.php';

$dbClass = new Database();
$connection = $dbClass->getConnection();

$user_id = 2;

if ($connection) {
    echo "عاش يا سيف! الداتابيز متصلة وزي الفل.";

    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
    echo "============ Cart Operations Test ============";
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";


    // // cart object
    $cart = new Cart($connection, $user_id);

    // // add product
    // $cart->addProduct(1,1);
    // $cart->addProduct(2,3);

    // // update product
    $cart->updateQuantity(2, 6);

    // // remove product
    // $cart->removeProduct(2);

    echo "<br/>";
    echo "<br/>";

    // // get cart items
    var_dump($cart->getItems());

    echo "<br/>";
    echo "<br/>";

    // // get total price
    var_dump($cart->getTotal());

    echo "<br/>";
    echo "<br/>";

    // // get total count
    var_dump($cart->getCount());
}