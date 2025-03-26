<?php
$mysqli = require __DIR__ . "../../../database.php";
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$firstname = isset($_POST['size']) ? testInput($_POST['size']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO product_size (size) VALUES (?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("SQL error : " . $mysqli->error);
    }
    $stmt->bind_param("s", $_POST["size"]);
    if ($stmt->execute()) {
        header("Location: sizes.php");
        exit();
    } else {
        die($stmt->error);
    }

}
?>