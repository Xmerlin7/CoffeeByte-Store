<?php
function checkAdmin() {
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: /public/login.php");
        exit;
    }
}