<?php
$mysqli = require __DIR__ . "/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL error : " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    $update_sql = "UPDATE user SET firstname = ?, lastname = ?, email = ?, phone = ? WHERE user_id = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    if (!$update_stmt) {
        die("SQL error : " . $mysqli->error);
    }
    $update_stmt->bind_param("ssssi", $firstname, $lastname, $email, $phone, $user_id);
    if ($update_stmt->execute()) {
        $_SESSION["firstname"] = $firstname;
        $_SESSION["lastname"] = $lastname;
        $_SESSION["email"] = $email;
        $_SESSION["phone"] = $phone;

        header("Location: user.php");
        exit();
    } else {
        die($update_stmt->error);
    }
}
?>