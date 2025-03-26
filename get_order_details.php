<?php
// Start session to manage user authentication
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page or handle authentication failure
    header("Location: login.php");
    exit;
}

// Retrieve user ID from session
$userID = $_SESSION['user_id'];

// Establish a database connection
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


// Retrieve cart items for the logged-in user with product details
$sql = "SELECT od.product_img, p.product_name, ps.size, pc.color, od.quantity, od.price,od.order_date
        FROM order_data od
        INNER JOIN product p ON od.product_id = p.product_id
        INNER JOIN product_size ps ON od.size_id = ps.size_id
        INNER JOIN product_color pc ON od.color_id = pc.color_id
        WHERE od.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Add each cart item to the cartItems array
        $cartItems[] = array(
            'product_img' => $row['product_img'],
            'product_name' => $row['product_name'],
            'size' => $row['size'],
            'color' => $row['color'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'date' => $row['order_date']

        );
    }
}
$stmt->close();
$conn->close();

// Send the cart items as JSON response
header('Content-Type: application/json');
echo json_encode($cartItems);
?>
