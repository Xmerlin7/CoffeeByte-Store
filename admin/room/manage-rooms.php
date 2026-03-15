<?php
require_once "../../classes/Room.php";
// require_once "../../config/functions.php";
// checkAdmin();
$roomObj = new Room();
$rooms = $roomObj->getAllRooms();
?>
<?php
$title = "CoffeeByte - Manage Rooms";
ob_start();
?>
<div class="rooms-page">

<a href="add-room.php" class="btn-primary add-room-btn">
+ Add Room
</a>

<div class="table-wrapper card">

<table class="admin-table">

<tr>
<th>ID</th>
<th>Room Number</th>
<th>Actions</th>
</tr>

<?php foreach ($rooms as $room): ?>
<tr>

<td>
<span class="room-id">
#<?= $room['id'] ?>
</span>
</td>

<td>
<span class="room-number">
<?= htmlspecialchars($room['room_number']) ?>
</span>
</td>

<td>

<div class="actions">

<a
href="edit-room.php?id=<?= $room['id'] ?>"
class="btn-edit"
>
Edit
</a>

<a
href="delete-room.php?id=<?= $room['id'] ?>"
class="btn-delete"
>
Delete
</a>

</div>

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