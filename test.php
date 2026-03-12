<?php
require_once './classes/Database.php';
require_once 'classes/Order.php';

$dbClass = new Database();
$connection = $dbClass->getConnection();

if($connection) {
    echo "عاش يا سيف! الداتابيز متصلة وزي الفل.";
}

$o = new order($connection, 1, 100.50, 'processing', 'Please deliver between 5-6 PM', date('Y-m-d H:i:s'));
$o->save();