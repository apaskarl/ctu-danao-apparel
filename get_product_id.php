<?php
// Database connection
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

// Get product name from request
$data = json_decode(file_get_contents("php://input"));
$productName = $data->productName; // Corrected

// Query database to get product ID
$sql = "SELECT product_id FROM product WHERE product_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productName);
$stmt->execute();
$result = $stmt->get_result();

// Fetch product ID
if ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    echo json_encode(array("product_id" => $product_id));
} else {
    echo json_encode(array("error" => "Product not found"));
}

$stmt->close();
$conn->close();
?>


