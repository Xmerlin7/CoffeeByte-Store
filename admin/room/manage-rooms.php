<?php
require_once "../../classes/Room.php";
// require_once "../../config/functions.php";
// checkAdmin();
$roomObj = new Room();
$rooms = $roomObj->getAllRooms();
?>

<a href="add-room.php">+ Add Room</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Room Number</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($rooms as $room): ?>
    <tr>
        <td><?= $room['id'] ?></td>
        <td><?= $room['room_number'] ?></td>
        <td>
            <a href="edit-room.php?id=<?= $room['id'] ?>">Edit</a>
            <a href="delete-room.php?id=<?= $room['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>