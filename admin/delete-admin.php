<?php
if (isset($_GET["admin_id"])) {
    $admin_id = $_GET["admin_id"];

    $mysqli = require __DIR__ . "../../database.php";

    $sql_delete_admin = "DELETE FROM admin WHERE admin_id = ?";
    $stmt_delete_admin = $mysqli->prepare($sql_delete_admin);

    if (!$stmt_delete_admin) {
        die("Error in preparing statement: " . $mysqli->error);
    }

    $stmt_delete_admin->bind_param("i", $admin_id);

    if ($stmt_delete_admin->execute()) {
        header("Location: settings.php");
        exit();
    } else {
        echo "Error deleting product: " . $mysqli->error;
    }

    $stmt_delete_admin->close();
    $mysqli->close();
} else {
    echo "Product ID not provided";
}
?>