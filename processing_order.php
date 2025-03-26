<?php
// process_order.php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order_id from the AJAX request
    $orderId = $_POST['order_id'];

    // Validate and sanitize the input
    if (!empty($orderId) && is_numeric($orderId)) {
        // Database connection
        $mysqli = require __DIR__ . "/database.php";

        // Example action: Transfer data from order_data to order_processing for the given order_id
        $sqlTransfer = "
            INSERT INTO order_processing (order_id, user_id, product_img, product_id, size_id, color_id, quantity, price, subtotal, order_date)
            SELECT order_id, user_id, product_img, product_id, size_id, color_id, quantity, price, subtotal, order_date
            FROM order_data
            WHERE order_id = ?
        ";

        // Prepare the SQL statement
        $stmt = $mysqli->prepare($sqlTransfer);
        if ($stmt) {
            // Bind the parameters and execute the statement
            $stmt->bind_param('i', $orderId);
            if ($stmt->execute()) {
                // Optional: Delete data from order_data after transfer
                $sqlDelete = "DELETE FROM order_data WHERE order_id = ?";
                $stmtDelete = $mysqli->prepare($sqlDelete);
                if ($stmtDelete) {
                    $stmtDelete->bind_param('i', $orderId);
                    $stmtDelete->execute();
                    $stmtDelete->close();
                }

                echo "Order processed successfully.";
            } else {
                echo "Error processing order: " . $mysqli->error;
            }
            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }

        // Close the database connection
        $mysqli->close();
    } else {
        echo "Invalid order ID.";
    }
} else {
    echo "Invalid request method.";
}
?>
