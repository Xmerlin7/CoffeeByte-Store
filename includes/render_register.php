<?php
include "../classes/Database.php";
$database = new Database();
$connection = $database->getConnection();

if (isset($_POST['register-btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $namepattern = "/^(?=(?:.*[a-zA-Z]){6,})[a-zA-Z\s]+$/";
    if (!preg_match($namepattern, $name)) {
        header("location:../public/register.php?name_message=Name must be at least 6 characters long and contain letters only.");
        exit();
    }


    $passwordpattern = "/^(?=.*[A-Za-z])[A-Za-z0-9]{8,}$/";
    if (!preg_match($passwordpattern, $password)) {
        header("location:../public/register.php?password_message=Password must be at least 8 characters long and contain at least one letter.");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:../public/register.php?email_message=Please enter a valid email address.");
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "select * from users where email = :email";
    $sqlquery = $connection->prepare($query);
    $sqlquery->execute([':email' => $email]);
    $data = $sqlquery->fetchAll(PDO::FETCH_ASSOC);
    if ($data) {
        header("location:../public/register.php?email_is_exist=Email already exists. Please use a different email.");
        exit();
    }

    $insert_user = "insert into users (name, email, password) values (:name, :email, :password)";
    $sqlinsert = $connection->prepare($insert_user);
    $sqlinsert->execute([':name' => $name, ':email' => $email, ':password' => $hashed_password]);
    header("location:../public/register.php?success_message=Registration successful! You can now log in.");
    exit();
}
