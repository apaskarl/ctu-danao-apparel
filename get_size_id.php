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

$data = json_decode(file_get_contents("php://input"));
$size = $data->size;

$sql = "SELECT size_id FROM product_size WHERE size = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $size);
$stmt->execute();
$result = $stmt->get_result();

// Fetch product ID
if ($row = $result->fetch_assoc()) {
    $size_id = $row['size_id'];
    echo json_encode(array("size_id" => $size_id));
} else {
    echo json_encode(array("size_id" => 0));
}

$stmt->close();
$conn->close();


?>