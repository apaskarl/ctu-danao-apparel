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

        // Prepare statement for retrieving the order items
        $stmtOrderItems = $conn->prepare("SELECT * FROM order_data WHERE order_id = ?");
        $stmtOrderItems->bind_param("i", $orderId);
        $stmtOrderItems->execute();
        $result = $stmtOrderItems->get_result();

        // Check if order items exist
        if ($result->num_rows > 0) {
            $items = array();
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;

                // Update stock based on size_id and color_id
                if ($row['size_id'] != 0 && $row['color_id'] != 0) {
                    // Update product_variants
                    $stmtUpdateVariants = $conn->prepare("UPDATE product_variant SET quantity =quantity + ? WHERE product_id = ? AND size_id = ? AND color_id = ?");
                    $stmtUpdateVariants->bind_param("iiii", $row['quantity'], $row['product_id'], $row['size_id'], $row['color_id']);
                    $stmtUpdateVariants->execute();
                    $stmtUpdateVariants->close();
                } else {
                    // Update product_accessories
                    $stmtUpdateAccessories = $conn->prepare("UPDATE product_accessories SET quantity =quantity + ? WHERE product_id = ?");
                    $stmtUpdateAccessories->bind_param("ii", $row['quantity'], $row['product_id']);
                    $stmtUpdateAccessories->execute();
                    $stmtUpdateAccessories->close();
                }

                // Prepare statement for inserting data into order_cancelled
                $stmtInsertCancelled = $conn->prepare("INSERT INTO order_cancelled (order_id, user_id, product_img, product_id, size_id, color_id, quantity, price, subtotal, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmtInsertCancelled->bind_param("iisiiiiids", $row['order_id'], $row['user_id'], $row['product_img'], $row['product_id'], $row['size_id'], $row['color_id'], $row['quantity'], $row['price'], $row['subtotal'], $row['order_date']);
                $stmtInsertCancelled->execute();
                $stmtInsertCancelled->close();
            }

            // Prepare statement for deleting data from order_data
            $stmtDeleteOrder = $conn->prepare("DELETE FROM order_data WHERE order_id = ?");
            $stmtDeleteOrder->bind_param("i", $orderId);
            $stmtDeleteOrder->execute();
            $stmtDeleteOrder->close();

            // Commit the transaction
            $conn->commit();

            // Return a success response with the order items
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "items" => $items));
        } else {
            // Rollback the transaction if no items are found
            $conn->rollback();

            // Return an error response if no items are found
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "No items found for this order"));
        }

        $stmtOrderItems->close();
    } catch (mysqli_sql_exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();

        // Return an error response
        header('Content-Type: application/json');
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    }

    // Close connection
    $conn->close();
} else {
    // Return an error response if data is empty or not an array
    header('Content-Type: application/json');
    echo json_encode(array("success" => false, "message" => "No valid data received"));
}
?>
