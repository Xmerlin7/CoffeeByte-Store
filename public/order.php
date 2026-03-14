<?php
require_once '../classes/Database.php';
require_once '../classes/Order.php';

// 1. INITIALIZE
$db = new Database();
$pdo = $db->getConnection();

// Hardcoded user for this example
$user_id = 2;
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
$title = "CoffeeByte - My Orders";
ob_start();
?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- <style>
        :root {
            --primary: #6F4E37;
            --accent: #A67B5B;
            --bg: #f8f9fa;
            --text: #2d3436;
            --danger: #d63031;
            --success: #27ae60;
        }

  
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        h1 { color: var(--primary); text-align: center; margin-bottom: 30px; }

        .alert {
            background: white;
            border-left: 5px solid var(--success);
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            font-weight: 600;
            color: var(--success);
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        h2 { 
            font-size: 1.2rem; 
            margin-top: 0; 
            margin-bottom: 20px; 
            color: var(--primary); 
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        /* Form Styling */
        .order-form {
            display: grid;
            grid-template-columns: 1fr 2fr auto;
            gap: 15px;
            align-items: flex-end;
        }

        .form-group { display: flex; flex-direction: column; gap: 5px; }

        label { font-size: 0.85rem; font-weight: 600; color: #666; }

        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; background: #fafafa; font-size: 0.8rem; color: #999; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #eee; }

        .status-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #eee;
            text-transform: capitalize;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--accent); }

        .btn-outline-danger {
            background: transparent;
            color: var(--danger);
            border: 1px solid var(--danger);
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            color: white;
        }
    </style> -->



<div class="container">
    <h1 class='mt-3'>CoffeeByte Orders</h1>

    <?php if($message): ?>
        <div class="alert"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


    <div class="card">
        <h2>Place New Order</h2>
        <form method="POST" class="order-form">
            <div class="form-group">
                <label>Room ID</label>
                <input type="number" name="room_id" placeholder="e.g. 101" required>
            </div>
            <div class="form-group">
                <label>Notes (Optional)</label>
                <input type="text" name="notes" placeholder="Extra sugar, no milk...">
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
