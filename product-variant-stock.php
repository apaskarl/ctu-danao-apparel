<?php
session_start();

// Function to establish database connection
function connectToDatabase() {
    return require __DIR__ . "/database.php";
}

function fetchStockQuantity($productId, $sizeId = null, $colorId = null, $fetchBySize = true) {
    $mysqli = connectToDatabase();

    // Prepare the query based on whether fetching by size or color
    if ($fetchBySize) {
        $query = "SELECT quantity AS quantity FROM product_variant WHERE size_id = ? AND color_id = ? AND product_id = ?";
        $id1 = $sizeId;
        $id2 = $colorId;
        $id3 = $productId;
    } else {
    }

    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return array("error" => "Failed to prepare statement");
    }

    // Bind parameters and execute the statement
    if ($fetchBySize) {
        $stmt->bind_param("iii", $id1, $id2,$id3);
    } else {
        $stmt->bind_param("i", $id1);
    }
    if (!$stmt->execute()) {
        return array("error" => "Error in executing the statement");
    }

    // Get the result
    $result = $stmt->get_result();
    if (!$result) {
        return array("error" => "Error in getting result set");
    }

    // Fetch the row and retrieve the quantity
    $row = $result->fetch_assoc();
    $quantity = $row ? $row["quantity"] : null;

    // Close the statement
    $stmt->close();

    return array("stock" => $quantity);
}
// Get parameters from the URL
$productId = $_GET['productId'];
$sizeId = $_GET['sizeId'];
$colorId = $_GET['colorId'];
$fetchBySize = isset($_GET['fetchBySize']) ? $_GET['fetchBySize'] === 'true' : true;

// Fetch stock quantity
$stockData = fetchStockQuantity($productId, $sizeId, $colorId, $fetchBySize);

// Output JSON response
header('Content-Type: application/json');
echo json_encode($stockData);
