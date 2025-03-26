<?php
session_start();

// Function to establish database connection
function connectToDatabase() {
    return require __DIR__ . "/database.php";
}

function getCategoryName($category_id) {
    $mysqli = connectToDatabase();

        $query = "SELECT category FROM product_category WHERE  category_id = ?";
        $id1 = $category_id;


    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return array("error" => "Failed to prepare statement");
    }


    $stmt->bind_param("i", $id1);

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
    $category = $row ? $row["category"] : null;

    // Close the statement
    $stmt->close();

    return array("category" => $category);
}
// Get parameters from the URL
$categoryId = $_GET['product_category'];

// Fetch stock quantity
$category = getCategoryName($categoryId);
error_log("Category: " . json_encode($category));

// Output JSON response
header('Content-Type: application/json');
echo json_encode($category);
