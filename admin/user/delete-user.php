<?php
require_once "../../classes/User.php";
// require_once "../../config/functions.php";
// checkAdmin();
$userObj = new User();
$userObj->deleteUser($_GET['id']);

header("Location: manage-users.php");