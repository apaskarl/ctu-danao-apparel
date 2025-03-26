<?php
if (isset($_GET["color_id"])) {
    $color_id = $_GET["color_id"];

    $mysqli = require __DIR__ . "../../../database.php";

    // Start a transaction
    $mysqli->begin_transaction();

    try {
        // First, delete from product_variant where this color is referenced
        $sql_delete_variant = "DELETE FROM product_variant WHERE color_id = ?";
        $stmt_delete_variant = $mysqli->prepare($sql_delete_variant);

        if (!$stmt_delete_variant) {
            throw new Exception("Error in preparing statement: " . $mysqli->error);
        }

        $stmt_delete_variant->bind_param("i", $color_id);

        if (!$stmt_delete_variant->execute()) {
            throw new Exception("Error deleting product_variant: " . $stmt_delete_variant->error);
        }

        $stmt_delete_variant->close();

        // Then, delete from product_color
        $sql_delete_color = "DELETE FROM product_color WHERE color_id = ?";
        $stmt_delete_color = $mysqli->prepare($sql_delete_color);

        if (!$stmt_delete_color) {
            throw new Exception("Error in preparing statement: " . $mysqli->error);
        }

        $stmt_delete_color->bind_param("i", $color_id);

        if (!$stmt_delete_color->execute()) {
            throw new Exception("Error deleting product_color: " . $stmt_delete_color->error);
        }

        $stmt_delete_color->close();

        // Commit transaction
        $mysqli->commit();

        header("Location: colors.php");
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $mysqli->rollback();

        echo "Error: " . $e->getMessage();
    } finally {
        $mysqli->close();
    }
} else {
    echo "Color ID not provided";
}
?>