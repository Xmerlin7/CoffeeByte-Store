<?php
require_once 'classes/Database.php';

$dbClass = new Database();
$connection = $dbClass->getConnection();

if($connection) {
    echo "عاش يا سيف! الداتابيز متصلة وزي الفل.";
}