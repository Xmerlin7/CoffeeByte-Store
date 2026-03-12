<?php
include "../classes/Database.php";
$database = new Database();
$connection = $database->getConnection();

if (isset($_POST['update-btn'])) { //belng to verify email form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        header("Location: update_resetPassword.php?message=Passwords do not match.");
        exit();
    }

    // Validate password format
    $passwordpattern = "/^(?=.*[A-Za-z])[A-Za-z0-9]{8,}$/";
    if (!preg_match($passwordpattern, $password)) {
        header("Location: ../public/resetPassword.php?message=Password must be at least 8 characters long and contain at least one letter.");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update password in database
    $query = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $connection->prepare($query);
    $result = $stmt->execute([':password' => $hashed_password, ':email' => $email]);

    if ($result) {
        header("Location: ../public/login.php?message=Password updated successfully! You can now log in.");
        exit();
    } else {
        header("Location: ../public/resetPassword.php?message=Error updating password. Please try again.");
        exit();
    }
}
