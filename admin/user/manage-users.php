<?php
require_once "../../classes/User.php";
require_once "../../config/functions.php";
// checkAdmin();
$userObj = new User();
$users = $userObj->getAllUsers();
?>

<a href="add-user.php">+ Add User</a>

<table border="1">
    <tr>
        <th>Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>
        <td>
            <?php if (!empty($user['image'])): ?>
                <img
                    src="../../assets/uploads/users/<?= rawurlencode($user['image']) ?>"
                    alt="<?= htmlspecialchars($user['name']) ?>"
                    width="50"
                    height="50"
                    style="object-fit: cover; border-radius: 50%;"
                >
            <?php else: ?>
                No image
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
            <a href="edit-user.php?id=<?= $user['id'] ?>">Edit</a>
            <a href="delete-user.php?id=<?= $user['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>