<?php
require_once "../../classes/User.php";

$userObj = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../../assets/uploads/users/" . $image);

    $userObj->createUser([
        'name'     => $_POST['name'],
        'email'    => $_POST['email'],
        'password' => $_POST['password'],
        'image'    => $image,
        'role'     => $_POST['role']
    ]);

    header("Location: manage-users.php");
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text"     name="name"     placeholder="Name"><br>
    <input type="email"    name="email"    placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br>
    <input type="file" name="image"><br>
    <button>Add User</button>
</form>