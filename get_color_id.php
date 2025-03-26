<?php 
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

// Get data from JSON request
$data = json_decode(file_get_contents("php://input"));
$color = isset($data->color) ? $data->color : null; // Set $color to null if not provided

// Prepare and execute SQL query
$sql = "SELECT color_id FROM product_color WHERE color = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $color);
$stmt->execute();
$result = $stmt->get_result();

// Fetch product ID
if ($row = $result->fetch_assoc()) {
    $color_id = $row['color_id'];
    echo json_encode(array("color_id" => $color_id));
} else {
    echo json_encode(array("color_id" => 0)); // Return null if color is not found or empty
}

$stmt->close();
$conn->close();
?>
