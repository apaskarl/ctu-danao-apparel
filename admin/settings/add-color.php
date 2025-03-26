<?php
$mysqli = require __DIR__ . "../../../database.php";
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$firstname = isset($_POST['color']) ? testInput($_POST['color']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO product_color (color) VALUES (?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        die("SQL error : " . $mysqli->error);
    }
    $stmt->bind_param("s", $_POST["color"]);
    if ($stmt->execute()) {
        header("Location: colors.php");
        exit();
    } else {
        die($stmt->error);
    }

}
?>