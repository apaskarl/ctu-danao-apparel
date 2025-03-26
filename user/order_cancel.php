<?php
// Retrieve the JSON data sent from the client
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is not empty and is an array
if (!empty($data) && is_array($data)) {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cebutechapparel";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin a transaction
    $conn->begin_transaction();

    try {
        $orderId = $data['orderId'];
        // Prepare statements for retrieving size_id and color_id
        $stmtGetSizeId = $conn->prepare("SELECT size_id FROM product_size WHERE size = ?");
        $stmtGetColorId = $conn->prepare("SELECT color_id FROM product_color WHERE color = ?");

        // Prepare statements for moving data to order_cancelled table
        $stmtInsertCancelled = $conn->prepare("INSERT INTO order_cancelled (order_id, user_id, product_img, product_id, size_id, color_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Prepare statements for deleting from order_data table
        $stmtDeleteOrder = $conn->prepare("DELETE FROM order_data WHERE order_id = ?");

        // Prepare the update statements for product_variant and product_accessories tables
        $stmtUpdateVariant = $conn->prepare("UPDATE product_variant SET quantity = quantity + ? WHERE product_id = ? AND size_id = ? AND color_id = ?");
        $stmtUpdateAccessories = $conn->prepare("UPDATE product_accessories SET quantity = quantity + ? WHERE product_id = ?");

        // Bind parameters
        $stmtGetSizeId->bind_param("s", $size);
        $stmtGetColorId->bind_param("s", $color);
        $stmtInsertCancelled->bind_param("iisiiiiii", $orderId, $user_id, $imageUrl, $product_id, $size_id, $color_id, $quantity, $price, $subtotal);
        $stmtDeleteOrder->bind_param("i", $orderId);
        $stmtUpdateVariant->bind_param("iiii", $quantity, $product_id, $size_id, $color_id);
        $stmtUpdateAccessories->bind_param("ii", $quantity, $product_id);

        // Process each item in the order
        foreach ($data['items'] as $item) {
            // Extract item details
            $size = $item['size'];
            $color = $item['color'];
            $user_id = $item['userID'];
            $product_id = $item['productId'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $imageUrl = $item['productImg'];
            $subtotal = $price * $quantity;

            // Retrieve size_id
            $stmtGetSizeId->execute();
            $stmtGetSizeId->bind_result($size_id);
            $stmtGetSizeId->fetch();
            $stmtGetSizeId->reset();

            // Retrieve color_id
            $stmtGetColorId->execute();
            $stmtGetColorId->bind_result($color_id);
            $stmtGetColorId->fetch();
            $stmtGetColorId->reset();

            // Insert into order_cancelled table
            $stmtInsertCancelled->execute();

            // Delete from order_data table
            $stmtDeleteOrder->execute();

            // Update the correct table based on whether color and size are "NULL COLOR" and "NULL SIZE" or not
            if ($color_id === 0 && $size_id === 0) {
                $stmtUpdateAccessories->execute();
            } else {
                $stmtUpdateVariant->execute();
            }
        }

        // Commit the transaction
        $conn->commit();

        // Close statements
        $stmtGetSizeId->close();
        $stmtGetColorId->close();
        $stmtInsertCancelled->close();
        $stmtDeleteOrder->close();
        $stmtUpdateVariant->close();
        $stmtUpdateAccessories->close();

        // Close connection
        $conn->close();

        // Return a success response
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => "Order cancelled successfully"));
    } catch (mysqli_sql_exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();

        // Close connection
        $conn->close();

        // Return an error response
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    }
} else {
    // Return an error response if data is empty or not an array
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "No valid data received"));
}
?>
