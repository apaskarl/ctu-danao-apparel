<?php
include 'database.php';

// Get the POST data sent from the client-side JavaScript
$data = json_decode(file_get_contents("php://input"));

// Extract the form data
$userID = $data->user_id;
$productName = $data->product_name;
$size = $data->size;
$color = $data->color;
$price = $data->price;
$quantity = $data->quantity;
$subTotal = $data->subtotal;

// Function to update the cart in the database
function updateCartInDatabase($userID, $productName, $size, $color, $price, $quantity, $subTotal, $mysqli) {
    // Escape input data to prevent SQL injection
    $productName = $mysqli->real_escape_string($productName);
    $size = $mysqli->real_escape_string($size);
    $color = $mysqli->real_escape_string($color);

    // SQL query to update the cart
    $sql = "UPDATE user_cart 
            SET quantity = ?, subtotal = ?
            WHERE user_id = ? AND product_name = ? AND size = ? AND color = ?";

    // Prepare the SQL statement
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("iiisss", $quantity, $subTotal, $userID, $productName, $size, $color);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        return true; // Update successful
    } else {
        return false; // Update failed
    }
}

// Check if the database mysq$mysqliection is successful
if ($mysqli) {
    // Call the updateCartInDatabase function
    $updateSuccess = updateCartInDatabase($userID, $productName, $size, $color, $price, $quantity, $subTotal, $mysqli);

    // Prepare response
    $response = array();
    if ($updateSuccess) {
        $response['success'] = true;
        $response['message'] = "Cart updated successfully in the database.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to update cart in the database.";
    }
}

// Send response back to client-side JavaScript
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
