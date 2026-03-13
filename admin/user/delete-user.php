<?php
require_once "../../classes/User.php";

$userObj = new User();
$userObj->deleteUser($_GET['id']);

header("Location: manage-users.php");