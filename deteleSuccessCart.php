<?php
include 'database.php';

// Get the POST data sent from the client-side JavaScript
$data = json_decode(file_get_contents("php://input"));

// Function to delete items from the cart in the database
function deleteCartInDatabase($stringItem, $mysqli) {
    // Initialize response array
    $response = array();
    $successCount = 0;

    // Loop through each item in the array
    foreach ($stringItem as $item) {
        // Extract item data
        $productName = $item->productName;
        $size = $item->size;
        $color = $item->color;

        // Escape input data to prevent SQL injection
        $productName = $mysqli->real_escape_string($productName);
        $size = $mysqli->real_escape_string($size);
        $color = $mysqli->real_escape_string($color);

        // SQL query to delete the item from the cart
        $sql = "DELETE FROM user_cart 
                WHERE product_name = ? AND size = ? AND color = ?";

        // Prepare the SQL statement
        $stmt = $mysqli->prepare($sql);

        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $productName, $size, $color);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            $successCount++;
        }
    }

    // Check if any items were successfully deleted
    if ($successCount > 0) {
        $response['success'] = true;
        $response['message'] = "Successfully deleted $successCount item(s) from the database.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to delete items from the database.";
    }

    return $response;
}

// Check if the database connection is successful
if ($mysqli) {
    // Call the deleteCartInDatabase function
    $response = deleteCartInDatabase($data, $mysqli);

    // Send response back to client-side JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If database connection failed
    $response['success'] = false;
    $response['message'] = "Failed to connect to the database.";
    header('Content-Type: application/json');
    echo json_encode($response);
}

exit;
?>
