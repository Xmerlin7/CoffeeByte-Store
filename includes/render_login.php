<?php
session_start();
require_once '../classes/Database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header("Location: ../public/login.php?message=Please fill all fields");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../public/login.php?message=Enter valid email");
    exit;
}

try {
    $db         = new Database();
    $connection = $db->getConnection();

    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt  = $connection->prepare($query);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: ../public/home.php");
    } else {
        header("Location: ../public/login.php?message=Invalid email or password");
    }
} catch (PDOException $e) {
    header("Location: ../public/login.php?message=Something went wrong");
}
exit;
