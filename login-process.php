<?php
$mysqli = require __DIR__ . "/database.php";

$emailOrUsernameErr = $passwordErr = "";
$emailInputClass = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["emailOrUsername"])) {
        $emailOrUsernameErr = "This field is required";
        $emailInputClass = "borderErr";
    } else if (empty($_POST["password"])) {
        $passwordErr = "This field is required";
    } else {
        $emailOrUsername = $_POST["emailOrUsername"];
        $password = $_POST["password"];

        // Check if the input is an email or a username
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            // If input is an email
            $query = "SELECT * FROM user WHERE email = ?";
        } else {
            // If input is a username
            $query = "SELECT * FROM user WHERE username = ?";
        }

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $emailOrUsername);
        $stmt->execute();

        if ($stmt->error) {
            die("Error in SQL query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            if (password_verify($password, $user["password_hash"])) {
                session_start();
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["lastname"] = $user["lastname"];
                $_SESSION["profile_pic"] = $user["profile_pic"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["phone"] = $user["phone"];
                header("Location: index.php");
                exit;
            } else {
                $passwordErr = "Incorrect password";
            }
        } else {
            $emailOrUsernameErr = "Incorrect email address or username";
            $emailInputClass = "borderErr";
        }
    }
}
?>