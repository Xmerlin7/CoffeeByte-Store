<?php
require_once "../../classes/User.php";
// require_once "../../config/functions.php";
// checkAdmin();
$userObj = new User();
$user = $userObj->getUserById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentUser = $userObj->getUserById($_POST['id']);
    $imageName = $currentUser['image'] ?? null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['image']['name']);
        $imageName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
        $uploadPath = "../../assets/uploads/users/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            if (!empty($currentUser['image'])) {
                $oldImagePath = "../../assets/uploads/users/" . $currentUser['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $imageName = $currentUser['image'] ?? null;
        }
    }

    $userObj->updateUser($_POST['id'], [
        'name'  => $_POST['name'],
        'email' => $_POST['email'],
        'image' => $imageName,
        'role'  => $_POST['role']
    ]);
    header("Location: manage-users.php");
}
?>
<?php
$title = "CoffeeByte - Edit User";
ob_start();
?>
<form class="admin-form" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

<div class="form-group">
<label>Name</label>
<input
type="text"
name="name"
class="form-input"
value="<?= htmlspecialchars($user['name']) ?>"
>
</div>

<div class="form-group">
<label>Email</label>
<input
type="email"
name="email"
class="form-input"
value="<?= htmlspecialchars($user['email']) ?>"
>
</div>

<?php if (!empty($user['image'])): ?>
<div class="form-group">
<label>Current Image</label>
<br>
<img
src="../../assets/uploads/users/<?= rawurlencode($user['image']) ?>"
alt="<?= htmlspecialchars($user['name']) ?>"
class="user-avatar-lg"
>
</div>
<?php endif; ?>

<div class="form-group">
<label>Upload New Image</label>
<input type="file" name="image" accept="image/*" class="form-input">
</div>

<div class="form-group">
<label>Role</label>
<select name="role" class="form-input">

<option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>
User
</option>

<option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>
Admin
</option>

</select>
</div>

<button class="btn-primary">Save</button>

</form>
<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>