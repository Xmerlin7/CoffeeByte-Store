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

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

    <input type="text"  name="name"  value="<?= htmlspecialchars($user['name']) ?>"><br>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"><br>

    <?php if (!empty($user['image'])): ?>
        <img
            src="../../assets/uploads/users/<?= rawurlencode($user['image']) ?>"
            alt="<?= htmlspecialchars($user['name']) ?>"
            width="60"
            height="60"
            style="object-fit: cover; border-radius: 50%;"
        ><br>
    <?php endif; ?>

    <input type="file" name="image" accept="image/*"><br>

    <select name="role">
        <option value="user"  <?= $user['role'] == 'user'  ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select><br>

    <button>Save</button>
</form>