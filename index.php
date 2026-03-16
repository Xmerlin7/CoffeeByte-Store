<?php 

require_once "./config/functions.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /public/login.php");
    exit;
}

checkLoggedIn();

?>