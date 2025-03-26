<?php
session_start();
$mysqli = require __DIR__ . "/database.php";
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function checkEmail($mysqli, $email)
{
    $check_email_query = "SELECT * FROM user WHERE email = ?";
    $stmt_check_email = $mysqli->prepare($check_email_query);
    if (!$stmt_check_email) {
        die("SQL error : " . $mysqli->error);
    }
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result = $stmt_check_email->get_result();
    return $result->num_rows > 0;
}
function checkUsername($mysqli, $username)
{
    $check_username_query = "SELECT * FROM user WHERE username = ?";
    $stmt_check_username = $mysqli->prepare($check_username_query);
    if (!$stmt_check_username) {
        die("SQL error : " . $mysqli->error);
    }
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result = $stmt_check_username->get_result();
    return $result->num_rows > 0;
}

$firstnameErr = $lastnameErr = $emailErr = $usernameErr = $passwordErr = $repasswordErr = "";
$firstname = isset($_POST['firstname']) ? testInput($_POST['firstname']) : '';
$lastname = isset($_POST['lastname']) ? testInput($_POST['lastname']) : '';
$email = isset($_POST['email']) ? testInput($_POST['email']) : '';
$username = isset($_POST['username']) ? testInput($_POST['username']) : '';
$password = isset($_POST['password']) ? testInput($_POST['password']) : '';
$repassword = isset($_POST['repassword']) ? testInput($_POST['repassword']) : '';
$profile_pic = "assets/images/users/userpics/default_pfp.jpg";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Name validation
    if (!preg_match("/^[a-zA-z ]*$/", $firstname)) {
        $firstnameErr = "Invalid first name";
    } else if (!preg_match("/^[a-zA-z ]*$/", $lastname)) {
        $lastnameErr = "Invalid last name";
    }
    // Email validation
    else if (checkEmail($mysqli, $email)) {
        $emailErr = "Email address already exists";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email address";
    }
    // Email validation
    else if (checkUsername($mysqli, $username)) {
        $usernameErr = "Username already taken";
    }
    // Password validation
    else if (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters long";
    } else if (strlen($password) > 16) {
        $passwordErr = "Password must be at most 16 characters long";
    } else if (!preg_match("/[a-z]/", $password)) {
        $passwordErr = "Must contain at least one lowercase letter";
    } else if (!preg_match("/[A-Z]/", $password)) {
        $passwordErr = "Must contain at least one uppercase letter";
    } else if (preg_match('/\s/', $password)) {
        $passwordErr = "Spaces are not allowed";
    } else if ($password !== $repassword) {
        $repasswordErr = "Password does not match";
    }
    // Insert in the database
    else {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (firstname, lastname, email, username, password_hash, profile_pic) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            die("SQL error : " . $mysqli->error);
        }
        $stmt->bind_param("ssssss", $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["username"], $password_hash, $profile_pic);
        if ($stmt->execute()) {
            $_SESSION['signup_email'] = $email;
            header("Location: login.php");
            exit();
        } else {
            die($stmt->error);
        }
    }
}
?>