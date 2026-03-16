<?php
require_once "../../classes/User.php";
require_once "../../config/functions.php";
checkAdmin();
$userObj = new User();
$users = $userObj->getAllUsers();
?>
<?php
$title = "CoffeeByte - Dashboard";
ob_start();
?>
<div class="users-page ">

<div class="w-100 d-flex justify-content-between align-items-center">
    <h2 class="m-0">Users</h2>
    <a href="add-user.php" class="btn-checkout m-0" style="width: fit-content;">
        + Add User
    </a>
</div>

<div class="table-wrapper card">

<table class="admin-table">

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
class="user-avatar"
onerror="handleImageError(this)"
>
<?php else: ?>
<span class="no-image">No image</span>
<?php endif; ?>
</td>

<td><?= htmlspecialchars($user['name']) ?></td>
<td><?= htmlspecialchars($user['email']) ?></td>
<td>
<span class="role-badge">
<?= htmlspecialchars($user['role']) ?>
</span>
</td>

<td class="actions">

<a href="edit-user.php?id=<?= $user['id'] ?>" class="btn-edit">
Edit
</a>

<a href="delete-user.php?id=<?= $user['id'] ?>" class="btn-delete">
Delete
</a>

</td>

</tr>
<?php endforeach; ?>

</table>

</div>

</div>

<script src="/assets/js/script.js"></script>

<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>