<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cebutechapparel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $response = array("success" => false, "message" => "Connection failed: " . $conn->connect_error);
    echo json_encode($response);
    exit; // Stop further execution
}

// Retrieve JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Extract product and user ID from the decoded data
$product = $data['product'] ?? null;
$userID = $data['userID'] ?? null;
$qty  = $data['numQty'] ?? null;

// Check if product and user ID are provided
if (!$product || !$userID || !$qty) {
    $response = array("success" => false, "message" => "Product or userID is missing");
    echo json_encode($response);
    exit; // Stop further execution
}

// Check if the product already exists in the user's cart
$sql_check = "SELECT * FROM user_cart WHERE user_id = ? AND product_name = ? AND size = ? AND color = ? AND stock = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("isssi", $userID, $product['name'], $product['size'], $product['color'],$product['stock']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    $row = $result_check->fetch_assoc();
    $newQuantity = $row['quantity'] + $qty;
    $newSubtotal = $product['price'] * $newQuantity;
    
    $sql_update = "UPDATE user_cart SET quantity = ?, subtotal = ? WHERE user_id = ? AND product_name = ? AND size = ? AND color = ? AND stock = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiisssi", $newQuantity, $newSubtotal, $userID, $product['name'], $product['size'], $product['color'],$product['stock']);
    
    $stmt_update->execute();
    
    if ($stmt_update->affected_rows > 0) {
        $response = array("success" => true, "message" => "Product quantity updated successfully");
        echo json_encode($response);
    } else {
        // If no rows were affected, respond with an error message
        $response = array("success" => false, "message" => "Failed to update product quantity");
        echo json_encode($response);
    }
    
    $stmt_update->close();
} else {
    // If the product does not exist, insert it into the cart
    $subtotal = $product['price'] * $qty;
    $sql_insert = "INSERT INTO user_cart (user_id, product_img, product_name, size, color,stock, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issssiidi", $userID, $product['image'], $product['name'], $product['size'], $product['color'], $product['stock'],$product['price'], $qty, $subtotal);
    $stmt_insert->execute();
    
    if ($stmt_insert->affected_rows > 0) {
        // If the insertion was successful, respond with a success message
        $response = array("success" => true, "message" => "Product saved successfully");
        echo json_encode($response);
    } else {
        // If no rows were affected, respond with an error message
        $response = array("success" => false, "message" => "Failed to save product");
        echo json_encode($response);
    }
    
    $stmt_insert->close();
}

// Close the database connection
$conn->close();
?>
