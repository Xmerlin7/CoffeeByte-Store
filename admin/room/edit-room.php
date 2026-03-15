<?php
require_once "../../classes/Room.php";
require_once "../../config/functions.php";
checkAdmin();
$roomObj = new Room();
$room = $roomObj->getRoomById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomObj->updateRoom($_POST['id'], $_POST['room_number']);
    header("Location: manage-rooms.php");
}
?>
<?php
$title = "CoffeeByte - Manage Rooms";
ob_start();
?>
<div class="form-card">

<form method="POST" class="admin-form">

<input type="hidden" name="id" value="<?= $room['id'] ?>">

<div class="form-grid">

<div class="field full">

<label for="room_number">Room Number</label>

<input
type="text"
id="room_number"
name="room_number"
value="<?= htmlspecialchars($room['room_number']) ?>"
placeholder="Enter room number"
required
>

</div>

</div>

<div class="form-actions">

<button class="btn-save">
Save
</button>

</div>

</form>

</div>
<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>