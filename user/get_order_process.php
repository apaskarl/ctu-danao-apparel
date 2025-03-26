<?php
// Start session to manage user authentication
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect user to login page or handle authentication failure
        header("Location: login.php");
        exit;
    }

    // Retrieve user ID from session
    $userID = $_SESSION['user_id'];

    // Establish a database connection
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

    // Retrieve cart items for the logged-in user
    $sql = "SELECT order_processing.order_id, 
                order_processing.product_img, 
                order_processing.product_id, 
                product.product_name, 
                order_processing.size_id, 
                product_size.size, 
                order_processing.color_id, 
                product_color.color, 
                order_processing.price, 
                order_processing.quantity
            FROM order_processing
            INNER JOIN product ON order_processing.product_id = product.product_id
            INNER JOIN product_size ON order_processing.size_id = product_size.size_id
            INNER JOIN product_color ON order_processing.color_id = product_color.color_id
            WHERE order_processing.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = array();

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Add each cart item to the cartItems array
            $cartItems[] = array(
                'order_id' => $row['order_id'],
                'product_img' => $row['product_img'],
                'product_name' => $row['product_name'],
                'size' => $row['size'],
                'color' => $row['color'],
                'price' => $row['price'],
                'quantity' => $row['quantity']
            );
        }
    }
    $stmt->close();
    $conn->close();

    // Send the cart items as JSON response
    header('Content-Type: application/json');
    echo json_encode($cartItems);
?>
