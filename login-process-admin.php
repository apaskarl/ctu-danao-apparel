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

        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM admin WHERE email = ?";
        } else {
            $query = "SELECT * FROM admin WHERE username = ?";
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
                $_SESSION["admin_id"] = $user["admin_id"];

                header("Location: admin/dashboard.php");
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