<?php
session_start();
function connectToDatabase() {
    return require __DIR__ . "/database.php";
}

function getStock() {
    $mysqli = connectToDatabase();

    // Check if product_id is provided in the URL
    if(isset($_GET['product_id'])) {
        // Get the product_id from the URL
        $product_id = intval($_GET['product_id']);

        // Query to get stock for the product with the given product_id
        $stock_query = "SELECT quantity FROM product_accessories WHERE product_id = ?";

        // Prepare the statement
        $stmt = $mysqli->prepare($stock_query);
        $quantity = null;
        if ($stmt) {
            // Bind the product_id parameter
            $stmt->bind_param("i", $product_id);

            // Execute the statement
            $stmt->execute();

            // Bind the result variables
            $stmt->bind_result($quantity);

            // Fetch the result
            $stmt->fetch();

            // Close the statement
            $stmt->close();

            // Return the stock quantity as JSON
            header('Content-Type: application/json');
            echo json_encode(array('quantity' => $quantity));
        } else {
            // Error in preparing the statement
            echo json_encode(array('error' => 'Unable to prepare statement'));
        }
    } else {
        // No product_id provided in the URL
        echo json_encode(array('error' => 'No product ID provided'));
    }
}

// Call the function to get the product stock
getStock();
?>
