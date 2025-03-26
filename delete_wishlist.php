<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $wishlist_id = $_POST['wishlist_id'];

    // Prepare the SQL statement to delete the wishlist item
    $sql = "DELETE FROM wishlist WHERE wishlist_id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $wishlist_id, $_SESSION["user_id"]);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}
?>
