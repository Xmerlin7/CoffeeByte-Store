<?php
require_once 'classes/Database.php';
require_once 'classes/Cart.php';
require_once 'classes/Order.php';

$dbClass = new Database();
$pdo = $dbClass->getConnection();


// ============================
// TEST USER
// ============================
// use an existing user from the database
$user_id = 1;
$Order = new Order($pdo, $user_id);

// ============================
// TEST 1: CREATE ORDER
// ============================
echo "<h2>Test Create Order</h2>";

$room_id = 1;
$notes = "Testing order creation";

$order_id = $Order->createOrder($room_id, $notes);

if ($order_id) {
    echo "Order created successfully. Order ID: " . $order_id . "<br>";
} else {
    echo "Order creation failed.<br>";
}

// ============================
// TEST 2: GET USER ORDERS
// ============================
echo "<h2>Test Get User Orders</h2>";

$orders = $Order->getUserOrders();

echo "<pre>";
print_r($orders);
echo "</pre>";

// ============================
// TEST 3: FILTER ORDERS BY DATE
// ============================
echo "<h2>Test Orders By Date Range</h2>";

$date_from = "2024-01-01";
$date_to   = "2030-01-01";

$filtered = $Order->getOrdersByDateRange($date_from, $date_to);

echo "<pre>";
print_r($filtered);
echo "</pre>";

// ============================
// TEST 4: GET ORDER ITEMS
// ============================
echo "<h2>Test Order Items</h2>";

if (!empty($orders)) {
    $first_order_id = $orders[0]['id'];
    $items = $Order->getOrderItems($first_order_id);

    echo "<pre>";
    print_r($items);
    echo "</pre>";
}

// ============================
// TEST 5: CANCEL ORDER
// ============================
echo "<h2>Test Cancel Order</h2>";

if (!empty($orders)) {
    $order_to_cancel = $orders[0]['id'];
    $result = $Order->cancelOrder($order_to_cancel);

    if ($result) {
        echo "Order cancelled successfully.<br>";
    } else {
        echo "Order could not be cancelled (maybe not processing).<br>";
    }
}

// ============================
// TEST 6: ADMIN - GET ALL ORDERS
// ============================
echo "<h2>Test Get All Orders (Admin)</h2>";

$adminOrder = new Order($pdo); // no user_id needed
$allOrders = $adminOrder->getAllOrders();

echo "<pre>";
print_r($allOrders);
echo "</pre>";

// ============================
// TEST 7: ADMIN UPDATE STATUS
// ============================
echo "<h2>Test Update Order Status</h2>";

if (!empty($allOrders)) {
    $test_order = $allOrders[0]['id'];
    $update = $adminOrder->updateStatus($test_order, "out_for_delivery");

    if ($update) {
        echo "Order status updated successfully.<br>";
    } else {
        echo "Failed to update order status.<br>";
    }
}

echo "<h2>Testing Completed</h2>";

?>