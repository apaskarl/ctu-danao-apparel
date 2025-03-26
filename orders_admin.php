<?php
// Start session to manage user authentication
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page or handle authentication failure
    header("Location: login.php");
    exit;
}

// Initialize variables
$cartItems = array();
$error = '';

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cebutechapparel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error = "Connection failed: " . $conn->connect_error;
} else {
    // Retrieve cart items for all users with product details
    $sql = "SELECT od.*, p.product_name, ps.size, pc.color, od.quantity, od.price, od.order_date, u.firstname, u.lastname
            FROM order_data od
            INNER JOIN product p ON od.product_id = p.product_id
            INNER JOIN product_size ps ON od.size_id = ps.size_id
            INNER JOIN product_color pc ON od.color_id = pc.color_id
            INNER JOIN user u ON od.user_id = u.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Add each cart item to the cartItems array
            $cartItems[] = array(
                'product_img' => $row['product_img'],
                'product_name' => $row['product_name'],
                'size' => $row['size'],
                'color' => $row['color'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'date' => $row['order_date'],
                'full_name' => $row['firstname'] . ' ' . $row['lastname']
            );
        }
    } else {
        $error = "No cart items found for any user.";
    }

    $conn->close();
}

// Send the response
if ($error !== '') {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => $error));
} else {
    header('Content-Type: application/json');
    echo json_encode($cartItems);
}
?>
