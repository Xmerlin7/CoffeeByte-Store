<?php  
require_once '../../classes/Database.php';
require_once '../../classes/Order.php';

// 1. INITIALIZE DATABASE & CLASSES
$db = new Database();
$pdo = $db->getConnection();
$orderObj = new Order($pdo);

$message = "";

// 2. HANDLE THE UPDATE ACTION (Must happen before fetching data)
if (isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];
    
    // Using the update method from your Order class
    // Ensure your Order class has: public function updateStatus($id, $status) { ... }
    if ($orderObj->updateStatus($orderId, $newStatus)) {
        $message = "Order #$orderId updated to " . str_replace('_', ' ', $newStatus) . "!";
    } else {
        $message = "Error: Could not update order.";
    }
}

// 3. FETCH FRESH DATA FROM DB
$allOrders = $orderObj->getAllOrders(); 
?>


<?php
$title = "CoffeeByte - Dashboard - All orders";
ob_start();
?>

    <h2>Orders</h2>
    
    <?php if($message): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Current Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allOrders as $o): ?>
                <tr>
                    <td><strong>#<?= htmlspecialchars($o['id']) ?></strong></td>
                    <td><?= htmlspecialchars($o['user']) ?></td>
                    <td>
                        <span class="status-badge"><?= str_replace('_', ' ', $o['status']) ?></span>
                    </td>
                    <td>
                        <form method="POST" class="update-form">
                            <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                            
                            <select name="status">
                                <option value="processing" <?= $o['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="out_for_delivery" <?= $o['status'] == 'out_for_delivery' ? 'selected' : '' ?>>Out for Delivery</option>
                                <option value="delivered" <?= $o['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                <option value="cancelled" <?= $o['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>

                            <button name="update_status" type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<?php
$content = ob_get_clean();
include "../../layouts/dash.php";
?>