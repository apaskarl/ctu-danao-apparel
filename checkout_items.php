<?php
$mysqli = include 'database.php'; // Make sure to include your database connection file

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

try {
    // Start transaction
    $mysqli->begin_transaction();

    foreach ($data as $item) {
        $userID = $item['user_id'];
        $productName = $item['product_name'];
        $size = $item['size'];
        $color = $item['color'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $subtotal = $item['subtotal'];
        $productImg = $item['product_img']; // Get the product_img value from the JSON data

        // Check if the item already exists in order_checkout table
        $stmt = $mysqli->prepare("SELECT quantity FROM order_checkout WHERE user_id = ? AND product_name = ? AND size = ? AND color = ?");
        $stmt->bind_param("isss", $userID, $productName, $size, $color);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Item exists, update the quantity
            $stmt->bind_result($existingQuantity);
            $stmt->fetch();
            $newQuantity = $existingQuantity + $quantity;

            // Update the quantity for the existing item
            $stmtUpdate = $mysqli->prepare("UPDATE order_checkout SET quantity = ?, subtotal = ? WHERE product_name = ?");
            $newSubtotal = $price * $newQuantity;
            $stmtUpdate->bind_param("iis", $newQuantity, $newSubtotal, $productName);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            // Item does not exist, insert a new row
            $stmtInsert = $mysqli->prepare("INSERT INTO order_checkout (user_id, product_img, product_name, size, color, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->bind_param("issssidi", $userID, $productImg, $productName, $size, $color, $price, $quantity, $subtotal);
            $stmtInsert->execute();
            $stmtInsert->close();
        }

        $stmt->close();

    }

    // Commit transaction
    $mysqli->commit();
    echo json_encode(['success' => true, 'message' => 'Checkout successful.']);
} catch (Exception $e) {
    // Rollback transaction on error
    $mysqli->rollback();
    echo json_encode(['success' => false, 'message' => 'Checkout failed: ' . $e->getMessage()]);
}

$mysqli->close();


?>