<?php
// Assuming you have a database connection established

// Connect to your database - Replace with your actual database credentials
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

// Query to get the last order_id
$sql = "SELECT order_id FROM order_id_number ORDER BY order_id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the last order_id
    $row = $result->fetch_assoc();
    echo $row["order_id"];
} else {
    echo "0 results";
}
$conn->close();
?>
