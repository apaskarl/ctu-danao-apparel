<?php
include 'database.php';

// Get the POST data sent from the client-side JavaScript
$data = json_decode(file_get_contents("php://input"));

// Extract the form data
$userID = $data->user_id;
$productImage = $data->product_img;
$productName = $data->product_name;
$size = $data->size;
$color = $data->color;
$price = $data->price;
$quantity = $data->quantity;

// Function to update the cart in the database
function deleteCartInDatabase($userID, $productImage, $productName, $size, $color, $price, $quantity, $mysqli)
{
    // Escape input data to prevent SQL injection
    $productName = $mysqli->real_escape_string($productName);
    $size = $mysqli->real_escape_string($size);
    $color = $mysqli->real_escape_string($color);
    $productImage = $mysqli->real_escape_string($productImage);

    // SQL query to update the cart
    $sql = "DELETE FROM  user_cart 
            WHERE  user_id = ? AND product_img = ? AND product_name = ? AND size = ? AND color = ? AND price = ? AND quantity = ?";

    // Prepare the SQL statement
    $stmt = $mysqli->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("issssii", $userID, $productImage, $productName, $size, $color, $price, $quantity);
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
    $updateSuccess = deleteCartInDatabase($userID, $productImage, $productName, $size, $color, $price, $quantity, $mysqli);

    // Prepare response
    $response = array();
    if ($updateSuccess) {
        $response['success'] = true;
        $response['message'] = "Item deleted successfully in the database.";
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