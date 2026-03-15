<?php
require_once "../../classes/Room.php";
require_once "../../config/functions.php";
checkAdmin();
$roomObj = new Room();
$roomObj->deleteRoom($_GET['id']);

header("Location: manage-rooms.php");