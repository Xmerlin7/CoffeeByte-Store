<?php
require_once "../../classes/Room.php";
// require_once "../../config/functions.php";
// checkAdmin();
$roomObj = new Room();
$room = $roomObj->getRoomById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomObj->updateRoom($_POST['id'], $_POST['room_number']);
    header("Location: manage-rooms.php");
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $room['id'] ?>">
    <input type="text" name="room_number" value="<?= $room['room_number'] ?>"><br>
    <button>Save</button>
</form>