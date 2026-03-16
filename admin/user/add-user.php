<?php
require_once "../../classes/User.php";
require_once "../../config/functions.php";
checkAdmin();
$userObj = new User();

$errors = [];
$formData = [
    'name' => '',
    'email' => '',
    'role' => 'user'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData['name'] = trim($_POST['name'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['role'] = $_POST['role'] ?? 'user';

    $password = trim($_POST['password'] ?? '');
    $image = null;

    if ($formData['name'] === '') {
        $errors[] = 'Name is required.';
    }

    if ($formData['email'] === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Password is required.';
    }

    if (!in_array($formData['role'], ['user', 'admin'], true)) {
        $errors[] = 'Please select a valid role.';
    }

    $existingUsers = $userObj->getAllUsers();
    if ($existingUsers) {
        foreach ($existingUsers as $existingUser) {
            if (strcasecmp($existingUser['email'], $formData['email']) === 0) {
                $errors[] = 'This email already exists.';
                break;
            }
        }
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $originalName = basename($_FILES['image']['name']);
            $image = time() . '_' . preg_replace('/\s+/', '_', $originalName);
            $uploadPath = "../../assets/uploads/users/" . $image;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $errors[] = 'Image upload failed.';
            }
        } else {
            $errors[] = 'Please choose a valid image file.';
        }
    }

    if (empty($errors)) {
        $userObj->createUser([
            'name'     => $formData['name'],
            'email'    => $formData['email'],
            'password' => $password,
            'image'    => $image,
            'role'     => $formData['role']
        ]);

        header("Location: manage-users.php");
        exit;
    }
}
?>
<?php
$title = "CoffeeByte - Add User";
ob_start();
?>

<h2>Add User</h1>
<p class="page-sub">Fill in the details below to create a new user.</p>

<div class="form-card">
<form class="admin-form" method="POST" enctype="multipart/form-data">

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<input
type="text"
name="name"
placeholder="Name"
class="form-input"
value="<?= htmlspecialchars($formData['name']) ?>"
required
>

<input
type="email"
name="email"
placeholder="Email"
class="form-input"
value="<?= htmlspecialchars($formData['email']) ?>"
required
>

<input type="password" name="password" placeholder="Password" class="form-input" required>

<select name="role" class="form-input">
<option value="user" <?= $formData['role'] === 'user' ? 'selected' : '' ?>>User</option>
<option value="admin" <?= $formData['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
</select>

<input type="file" name="image" class="form-input" accept="image/*">

<button class="btn-primary">Add User</button>

</form>
</div>

<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>