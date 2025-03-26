<?php
session_start();

// Check if the file has been uploaded
if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    // Get file details
    $fileTmpPath = $_FILES['profilePic']['tmp_name'];
    $fileName = $_FILES['profilePic']['name'];
    $fileSize = $_FILES['profilePic']['size'];
    $fileType = $_FILES['profilePic']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Check if the file is an image
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileExtension, $allowedExtensions)) {
        // Set new filename
        $newFileName = $_SESSION["user_id"] . '.' . $fileExtension;

        // Move the uploaded file to a permanent location
        $uploadPath = __DIR__ . '/assets/images/users/userpics/' . $newFileName;
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // Update the user's profile picture in the session
            $_SESSION["profile_pic"] = 'assets/images/users/userpics/' . $newFileName;

            // Update profile picture in the database
            $mysqli = require __DIR__ . "/database.php";
            $userId = $_SESSION["user_id"];
            $updateQuery = "UPDATE user SET profile_pic = ? WHERE user_id = ?";
            $stmt = $mysqli->prepare($updateQuery);
            $stmt->bind_param('si', $_SESSION["profile_pic"], $userId);
            if ($stmt->execute()) {
                // Send success response
                http_response_code(200);
                exit;
            } else {
                // Error updating profile picture in the database
                http_response_code(500);
                exit;
            }
        } else {
            // Error moving the uploaded file
            http_response_code(500);
            exit;
        }
    } else {
        // File type not allowed
        http_response_code(400);
        exit;
    }
} else {
    // No file uploaded or error occurred
    http_response_code(400);
    exit;
}
?>