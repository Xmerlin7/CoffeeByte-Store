<?php
require_once "../../classes/User.php";

$userObj = new User();
$user = $userObj->getUserById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userObj->updateUser($_POST['id'], [
        'name'  => $_POST['name'],
        'email' => $_POST['email'],
        'role'  => $_POST['role']
    ]);
    header("Location: manage-users.php");
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <input type="text"  name="name"  value="<?= $user['name'] ?>"><br>
    <input type="email" name="email" value="<?= $user['email'] ?>"><br>

    <select name="role">
        <option value="user"  <?= $user['role'] == 'user'  ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select><br>

    <button>Save</button>
</form>