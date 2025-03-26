<?php
if (isset($_GET["variant_id"]) && isset($_GET['product_id'])) {
    $variant_id = $_GET["variant_id"];
    $product_id = $_GET['product_id'];

    $mysqli = require __DIR__ . "../../../../database.php";

    $sql = "DELETE FROM product_variant WHERE variant_id = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Error in preparing statement: " . $mysqli->error);
    }

    $stmt->bind_param("i", $variant_id);

    if ($stmt->execute()) {
        header("Location: product.php?product_id=$product_id");
        exit();
    } else {
        echo "Error deleting variant: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Variant ID or Product ID not provided";
}
?>