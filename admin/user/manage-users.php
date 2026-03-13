<?php
require_once "../../classes/User.php";
require_once "../../config/functions.php";
checkAdmin();
$userObj = new User();
$users = $userObj->getAllUsers();
?>

<a href="add-user.php">+ Add User</a>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['name'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['role'] ?></td>
        <td>
            <a href="edit-user.php?id=<?= $user['id'] ?>">Edit</a>
            <a href="delete-user.php?id=<?= $user['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>