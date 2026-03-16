<?php
require_once '../classes/Database.php';
require_once '../classes/Order.php';
require_once '../classes/Room.php';
require_once '../config/functions.php';

checkUser();
$r = new Room();
$rooms = $r->getAllRooms();

// 1. INITIALIZE
$db = new Database();
$pdo = $db->getConnection();

// $user_id = 2;
$user_id = $_SESSION['user_id'];
$order = new Order($pdo, $user_id);

$message = "";

// =======================
// 2. LOGIC (Must happen before fetching data)
// =======================

// CREATE ORDER
if(isset($_POST['create'])){
    $room_id = $_POST['room_id'];
    $notes = $_POST['notes'];
    $id = $order->createOrder($room_id, $notes);

    if($id){
        $message = "Order #$id created successfully!";
    } else {
        $message = "Order creation failed.";
    }
}

// CANCEL ORDER
if(isset($_POST['cancel'])){
    $order_id = $_POST['order_id'];
    if($order->cancelOrder($order_id)){
        $message = "Order #$order_id has been cancelled.";
    } else {
        $message = "Could not cancel order.";
    }
}

// =======================
// 3. GET DATA (Fresh data from DB)
// =======================
$userOrders = $order->getUserOrders();
?>

<?php
$title = "CoffeeByte - Your Orders";
ob_start();
?>

<div class="container">
    <h1 class='mt-3'>Your Orders</h1>

    <?php if($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


    <div class="card">
        <h2>Place New Order</h2>
        <form method="POST" class="order-form">
            <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-select" required>
                    <option selected disabled>Select Room</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['id'] ?>">
                            <?= $room['room_number'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Notes (Optional)</label>
                <textarea type="text" name="notes" placeholder="Extra sugar, no milk..."></textarea>
            </div>
            <button name="create" class="btn btn-primary">Confirm Order</button>
        </form>
    </div>

    <div class="card">
        <h2>My Order History</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($userOrders)): ?>
                    <tr><td colspan="5" style="text-align:center; color:#999;">No orders found.</td></tr>
                <?php else: ?>
                    <?php foreach($userOrders as $o): ?>
                    <tr>
                        <td><strong>#<?= $o['id'] ?></strong></td>
                        <td>Room <?= htmlspecialchars($o['room_id']) ?></td>
                        <td>
                            <span class="status-pill"><?= str_replace('_', ' ', $o['status']) ?></span>
                        </td>
                        <td style="font-size: 0.85rem; color: #666;"><?= date('M d, H:i', strtotime($o['order_date'])) ?></td>
                        <td>
                            <?php if($o['status'] == 'processing'): ?>
                                <form method="POST" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                    <button name="cancel" class="btn btn-outline-danger">Cancel</button>
                                </form>
                            <?php else: ?>
                                <span style="font-size:0.8rem; color:#ccc;">Fixed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
include "../layouts/main.php";
?>
