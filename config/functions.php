<?php
function ensureSessionStarted() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function checkAdmin() {
    ensureSessionStarted();

    if (!isset($_SESSION['user_id'])) {
        header("Location: /public/login.php");
        exit;
    }

    if (($_SESSION['user_role'] ?? '') !== 'admin') {
        header("Location: /public/home.php");
        exit;
    }
}

function checkUser() {
    ensureSessionStarted();

    if (!isset($_SESSION['user_id'])) {
        header("Location: /public/login.php");
        exit;
    }

    $role = $_SESSION['user_role'] ?? '';
    if ($role === 'admin') {
        header("Location: /admin/dashboard.php");
        exit;
    }

    if ($role !== 'user') {
        header("Location: /public/login.php");
        exit;
    }
}