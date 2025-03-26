<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - CebuTech Apparel</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" type="text/css" href="assets/login-signup.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php include 'login-process-admin.php'; ?>
</head>

<body>
    <div class="container login">
        <form method="post" class="form" id="loginForm">
            <h2>Admin</h2>
            <div class="input-box">
                <input type="text" name="emailOrUsername"
                    value="<?php echo isset($_POST['emailOrUsername']) ? htmlspecialchars($_POST['emailOrUsername']) : ''; ?>"
                    required>
                <label for="emailOrUsername">Username</label>
                <p class="error">
                    <?php echo $emailOrUsernameErr; ?>
                </p>
            </div>
            <div class="input-box">
                <input type="password" id="password" name="password"
                    value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
                    required>
                <label for="password">Password</label>
                <img src="assets/images/icons/hide.png" id="eyeicon" alt="">
                <p class="error">
                    <?php echo $passwordErr; ?>
                </p>
            </div>
            <button type="submit" value="Sign in" class="btn" id="signin"><span>Sign in</span></button>
        </form>
    </div>
    <script>
        let eyeicon = document.getElementById("eyeicon");
        let password = document.getElementById("password");

        eyeicon.onclick = function () {
            if (password.type === "password" && password.value.trim() !== "") {
                password.type = "text";
                eyeicon.src = "assets/images/icons/show.png";
            } else {
                password.type = "password";
                eyeicon.src = "assets/images/icons/hide.png";
            }
        };

        window.onload = function () {
            if (password.value.trim() === "") {
                eyeicon.style.display = "none";
            }
        };

        password.addEventListener("input", function () {
            if (password.value.trim() === "") {
                eyeicon.style.display = "none";
            } else {
                eyeicon.style.display = "inline-block";
            }
        });
    </script>
</body>

</html>