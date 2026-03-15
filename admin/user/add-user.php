<?php
require_once "../../classes/User.php";
// require_once "../../config/functions.php";
// checkAdmin();
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
<?php
$title = "CoffeeByte - Add User";
ob_start();
?>
<form class="admin-form" method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Name" class="form-input">

<input type="email" name="email" placeholder="Email" class="form-input">

<input type="password" name="password" placeholder="Password" class="form-input">

<select name="role" class="form-input">
<option value="user">User</option>
<option value="admin">Admin</option>
</select>

<input type="file" name="image" class="form-input">

<button class="btn-primary">Add User</button>

</form>
<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>