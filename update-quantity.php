<?php
if (isset($_POST['variant_id']) && isset($_POST['new_quantity'])) {
    $mysqli = require __DIR__ . "/database.php";

    $stmt = $mysqli->prepare("UPDATE product_variant SET quantity = ? WHERE variant_id = ?");
    $stmt->bind_param("ii", $new_quantity, $variant_id);

    $new_quantity = $_POST['new_quantity'];
    $variant_id = $_POST['variant_id'];

    if ($stmt->execute()) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $mysqli->error;
    }

    $stmt->close();

    $mysqli->close();
} else {
    echo "Error: variant_id or new_quantity not set";
}
?>