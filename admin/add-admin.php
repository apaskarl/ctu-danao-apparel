<?php
$mysqli = require __DIR__ . "../../database.php";
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$firstname = isset($_POST['firstname']) ? testInput($_POST['firstname']) : '';
$lastname = isset($_POST['lastname']) ? testInput($_POST['lastname']) : '';
$username = isset($_POST['username']) ? testInput($_POST['username']) : '';
$password = isset($_POST['password']) ? testInput($_POST['password']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (username, password_hash, firstname, lastname) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            die("SQL error : " . $mysqli->error);
        }
        $stmt->bind_param("ssss", $_POST["username"], $password_hash, $_POST["firstname"], $_POST["lastname"]);
        if ($stmt->execute()) {
            header("Location: settings.php");
            exit();
        } else {
            die($stmt->error);
        }
    
}
?>