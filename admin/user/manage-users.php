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

<a href="add-user.php" class="btn-primary add-user-btn">
+ Add User
</a>

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
<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>