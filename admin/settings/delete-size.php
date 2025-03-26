<?php
if (isset($_GET["size_id"])) {
    $size_id = $_GET["size_id"];

    $mysqli = require __DIR__ . "../../../database.php";

    // Start a transaction
    $mysqli->begin_transaction();

    try {
        // First, delete from product_variant where this size is referenced
        $sql_delete_variant = "DELETE FROM product_variant WHERE size_id = ?";
        $stmt_delete_variant = $mysqli->prepare($sql_delete_variant);

        if (!$stmt_delete_variant) {
            throw new Exception("Error in preparing statement: " . $mysqli->error);
        }

        $stmt_delete_variant->bind_param("i", $size_id);

        if (!$stmt_delete_variant->execute()) {
            throw new Exception("Error deleting product_variant: " . $stmt_delete_variant->error);
        }

        $stmt_delete_variant->close();

        // Then, delete from product_size
        $sql_delete_size = "DELETE FROM product_size WHERE size_id = ?";
        $stmt_delete_size = $mysqli->prepare($sql_delete_size);

        if (!$stmt_delete_size) {
            throw new Exception("Error in preparing statement: " . $mysqli->error);
        }

        $stmt_delete_size->bind_param("i", $size_id);

        if (!$stmt_delete_size->execute()) {
            throw new Exception("Error deleting product_size: " . $stmt_delete_size->error);
        }

        $stmt_delete_size->close();

        // Commit transaction
        $mysqli->commit();

        header("Location: sizes.php");
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $mysqli->rollback();

        echo "Error: " . $e->getMessage();
    } finally {
        $mysqli->close();
    }
} else {
    echo "Size ID not provided";
}
?>