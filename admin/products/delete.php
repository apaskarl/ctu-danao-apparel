<?php
if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];

    $mysqli = require __DIR__ . "../../../database.php";

    // Delete product variants first
    $sql_delete_variants = "DELETE FROM product_variant WHERE product_id = ?";
    $stmt_delete_variants = $mysqli->prepare($sql_delete_variants);

    if (!$stmt_delete_variants) {
        die("Error in preparing statement: " . $mysqli->error);
    }

    $stmt_delete_variants->bind_param("i", $product_id);

    if (!$stmt_delete_variants->execute()) {
        echo "Error deleting product variants: " . $mysqli->error;
        exit(); // Exit if deletion fails
    }

    $stmt_delete_variants->close();

    // Delete product variants first
    $sql_delete_accessories = "DELETE FROM product_accessories WHERE product_id = ?";
    $stmt_delete_accessories = $mysqli->prepare($sql_delete_accessories);

    if (!$stmt_delete_accessories) {
        die("Error in preparing statement: " . $mysqli->error);
    }

    $stmt_delete_accessories->bind_param("i", $product_id);

    if (!$stmt_delete_accessories->execute()) {
        echo "Error deleting product accessories: " . $mysqli->error;
        exit(); // Exit if deletion fails
    }

    $stmt_delete_accessories->close();

    // Now delete the product
    $sql_delete_product = "DELETE FROM product WHERE product_id = ?";
    $stmt_delete_product = $mysqli->prepare($sql_delete_product);

    if (!$stmt_delete_product) {
        die("Error in preparing statement: " . $mysqli->error);
    }

    $stmt_delete_product->bind_param("i", $product_id);

    if ($stmt_delete_product->execute()) {
        // Redirect back to admin.php after successful deletion
        header("Location: ../products.php");
        exit();
    } else {
        echo "Error deleting product: " . $mysqli->error;
    }

    $stmt_delete_product->close();
    $mysqli->close();
} else {
    echo "Product ID not provided";
}
?>