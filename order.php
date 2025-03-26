<?php
// Retrieve the JSON data sent from the client
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is not empty
if (!empty($data)) {
    // Database connection details
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

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Extract userID from the data
        $user_id = $data['userID'];

        // Insert into order_id_number table to generate a new order_id
        $stmtOrderID = $conn->prepare("INSERT INTO order_id_number (order_id) VALUES (null)");
        $stmtOrderID->execute();
        $order_id = $conn->insert_id; // Get the auto-incremented order_id
        $stmtOrderID->close();

        // Prepare the insert statement for order_data table
        $stmtOrder = $conn->prepare("INSERT INTO order_data (order_id, user_id, product_img, product_id, size_id, color_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Prepare the update statement for product_variant and product_accessories tables
        $stmtUpdateVariant = $conn->prepare("UPDATE product_variant SET quantity = quantity - ? WHERE product_id = ? AND size_id = ? AND color_id = ?");
        $stmtUpdateAccessories = $conn->prepare("UPDATE product_accessories SET quantity = quantity - ? WHERE product_id = ?");

        // Prepare statements to get color_id and size_id from product_color and product_size tables
        $stmtColor = $conn->prepare("SELECT color_id FROM product_color WHERE color = ?");
        $stmtSize = $conn->prepare("SELECT size_id FROM product_size WHERE size = ?");

        // Prepare statement to get product_id from product table based on product_name
        $stmtProduct = $conn->prepare("SELECT product_id FROM product WHERE product_name = ?");

        // Prepare statement to delete items from user_cart
        $stmtDeleteCart = $conn->prepare("DELETE FROM user_cart WHERE user_id = ? AND product_name = ? AND color = ? AND size = ?");

        // Insert each item from the data array into the order_data table and update quantity in the product_variant table
        foreach ($data['items'] as $item) {
            // Get product_id based on product_name
            $productName = $item['product_name'];
            $stmtProduct->bind_param("s", $productName);
            $stmtProduct->execute();
            $stmtProduct->bind_result($product_id);
            $stmtProduct->fetch();
            $stmtProduct->reset();

            // Get color_id
            $stmtColor->bind_param("s", $item['color']);
            $stmtColor->execute();
            $stmtColor->bind_result($color_id);
            $stmtColor->fetch();
            $stmtColor->reset();

            // Get size_id
            $stmtSize->bind_param("s", $item['size']);
            $stmtSize->execute();
            $stmtSize->bind_result($size_id);
            $stmtSize->fetch();
            $stmtSize->reset();

            $quantity = $item['quantity'];
            $price = $item['price'];
            $subtotal = $item['subtotal'];
            $product_img = $item['product_img'];

            // Insert into order_data table
            $stmtOrder->bind_param("iisiiiiii", $order_id, $user_id, $product_img, $product_id, $size_id, $color_id, $quantity, $price, $subtotal);
            $stmtOrder->execute();

            // Update the correct table based on whether color_id and size_id are null or not
            if ($color_id === 0 && $size_id === 0) {
                $stmtUpdateAccessories->bind_param("ii", $quantity, $product_id);
                $stmtUpdateAccessories->execute();
            } elseif ($color_id !== null && $size_id !== null) {
                $stmtUpdateVariant->bind_param("iiii", $quantity, $product_id, $size_id, $color_id);
                $stmtUpdateVariant->execute();
            }

            // Delete item from user_cart
            $stmtDeleteCart->bind_param("isss", $user_id, $productName, $item['color'], $item['size']);
            $stmtDeleteCart->execute();
        }

        // Commit the transaction
        $conn->commit();

        // Close statements
        $stmtOrder->close();
        $stmtUpdateVariant->close();
        $stmtUpdateAccessories->close();
        $stmtColor->close();
        $stmtSize->close();
        $stmtProduct->close();
        $stmtDeleteCart->close();
        $conn->close();

        // Return a success response
        echo json_encode(array("success" => true, "message" => "Data inserted successfully"));
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $conn->rollback();

        // Close connection
        $conn->close();

        // Return an error response
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    }
} else {
    // Return an error response if data is empty
    echo json_encode(array("success" => false, "message" => "No data received"));
}
?>