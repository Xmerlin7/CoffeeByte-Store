<?php
require_once "../../classes/Room.php";
// require_once "../../config/functions.php";
// checkAdmin();
$roomObj = new Room();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomObj->createRoom($_POST['room_number']);
    header("Location: manage-rooms.php");
}
?>
<?php
$title = "CoffeeByte - Add User";
ob_start();
?>
<div class="form-card">

<form method="POST" class="admin-form">

<div class="form-grid">

<div class="field full">
<label for="room_number">Room Number</label>

<input
type="text"
id="room_number"
name="room_number"
placeholder="Room Number"
required
>

</div>

</div>

<div class="form-actions">

<button class="btn-save">
Add Room
</button>

</div>

</form>

</div>
<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>