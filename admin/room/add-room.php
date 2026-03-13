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

<form method="POST">
    <input type="text" name="room_number" placeholder="Room Number"><br>
    <button>Add Room</button>
</form>