<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="assets/style.css">
    
    <link rel="stylesheet" href="assets/login-signup.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <?php include 'signup-process.php'; ?> -->
</head>

<body>
    <section id="main-header">
        <div class="menu-wrap" id="menuWrap">
            <div class="menu-wrap-content">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <a class="close-btn" id="closeBtn"><ion-icon name="close-outline"></ion-icon></a>
                </div>

                <div class="menu-user">
                    <a href="user.php">
                        <?php if (!isset($_SESSION["user_id"])): ?>
                            <p><a href="login.php">Log in</a><span>/</span><a href="signup.php">Sign up</a></p>
                        <?php else: ?>
                            <img
                                src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>">
                            <p>
                                <?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>
                                <?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>
                            </p>
                        <?php endif ?>
                    </a>
                </div>
    
                <div class="menu-nav-links">
                    <ul>
                        <a href="index.php" class="hide-mobile">
                            <li><ion-icon name="home-outline"></ion-icon>Home</li>
                        </a>
                        <a href="shop.php">
                            <li><ion-icon name="pricetags-outline"></ion-icon>Shop</li>
                        </a>
                        <a href="about.php">
                            <li><ion-icon name="information-circle-outline"></ion-icon>About</li>
                        </a>
                        <a href="contact.php">
                            <li><ion-icon name="call-outline"></ion-icon>Contact</li>
                        </a>
                        <a href="settings.php" class="show-mobile">
                            <li><ion-icon name="settings-outline"></ion-icon>Settings</li>
                        </a>
                        <?php if (isset($_SESSION["user_id"])): ?>
                            <a href="logout.php" class="show-mobile">
                                <li><ion-icon name="log-out-outline"></ion-icon>Log out</li>
                            </a>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    
        <div class="overlay" id="overlay"></div>
    
        <header id="header">
            <ul id="navbar">
                <div class="nav-menu">
                    <li>
                        <ion-icon name="menu-outline" class="menu-btn" id="menuBtn"></ion-icon>
                    </li>
                </div>
    
                <div class="nav-menu nav-center">
                    <a href="index.php" style="text-decoration: none;">
                        <h4 id="logo-header"><span>CTU-Danao</span> Apparel</h4>
                    </a>
                </div>
    
                <div class="nav-menu right">
                    <?php if (!isset($_SESSION["user_id"])): ?>
                        <li>
                            <a href="login.php"><ion-icon name="person-circle-outline"></ion-icon></a>
                        </li>
                    <?php else: ?>
                        <img src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>"
                            class="user-pic" onclick="toggleMenu()">
                        <li class="wishlist">
                            <a href="wishlist.php" class="icon-right"><ion-icon name="heart-outline"></ion-icon></a>
                        </li>
                        <li class="cart">
                            <a href="cart.php" class="icon-right"><ion-icon name="cart-outline"></ion-icon></a>
                        </li>
                    <?php endif; ?>
                    <div class="sub-menu-wrap" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img
                                    src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>">
                                <p>
                                    <?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>
                                    <?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>
                                </p>
                            </div>
                            <hr>
                            <a href="user.php" class="sub-menu-link">
                                <ion-icon name="person"></ion-icon>
                                <p>Profile</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                            <a href="settings.php" class="sub-menu-link">
                                <ion-icon name="settings"></ion-icon>
                                <p>Settings</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                            <a href="logout.php" class="sub-menu-link">
                                <ion-icon name="log-out"></ion-icon>
                                <p>Log out</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                        </div>
                    </div>
                </div>
            </ul>
        </header>
    </section>
    
    <div class="container signup">
        <form method="post" class="form">
            <h2>Sign Up</h2>

            <div class="name">
                <div class="input-box" style="width: 48%;">
                    <input type="text" id="firstname" name="firstname"
                        value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>"
                        required>
                    <label for="firstname">First name</label>
                    <p class="error">
                        <?php echo $firstnameErr; ?>
                    </p>
                </div>
                <div class="input-box" style="width: 48%; display: inline-end;">
                    <input type="text" id="lastname" name="lastname"
                        value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>"
                        required>
                    <label for="lastname">Last name</label>
                    <p class="error">
                        <?php echo $lastnameErr; ?>
                    </p>
                </div>
            </div>

            <div class="input-box">
                <input type="text" id="email" name="email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <label for="email">Email address</label>
                <p class="error">
                    <?php echo $emailErr; ?>
                </p>
            </div>

            <div class="input-box">
                <input type="text" id="username" name="username"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required>
                <label for="username">Username</label>
                <p class="error">
                    <?php echo $usernameErr; ?>
                </p>
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password"
                    value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
                    required>
                <img src="assets/images/icons/show.png" id="eyeicon" alt="">
                <label for="password">Password</label>
                <p class="error">
                    <?php echo $passwordErr; ?>
                </p>
            </div>

            <div class="input-box">
                <input type="password" id="repassword" name="repassword"
                    value="<?php echo isset($_POST['repassword']) ? htmlspecialchars($_POST['repassword']) : ''; ?>"
                    required>
                <img src="assets/images/icons/show.png" id="eyeicon2" alt="">
                <label for="repassword">Retype Password</label>
                <p class="error">
                    <?php echo $repasswordErr; ?>
                </p>
            </div>
            <button type="submit" name="signup"><span>Register</span></button>
            <p class="form-link">Already have an account? <a href="login.php">Log in</a></p>
        </form>
    </div>

    <script>
        let eyeicon = document.getElementById("eyeicon");
        let password = document.getElementById("password");

        eyeicon.onclick = function () {
            if (password.type === "password" && password.value.trim() !== "") {
                password.type = "text";
                eyeicon.src = "assets/images/icons/hide.png";
            } else {
                password.type = "password";
                eyeicon.src = "assets/images/icons/show.png";
            }
        };

        window.onload = function () {
            if (password.value.trim() === "") {
                eyeicon.style.display = "none";
            }

            if (repassword.value.trim() === "") {
                eyeicon2.style.display = "none";
            }
        };

        password.addEventListener("input", function () {
            if (password.value.trim() === "") {
                eyeicon.style.display = "none";
            } else {
                eyeicon.style.display = "inline-block";
            }
        });

        let eyeicon2 = document.getElementById("eyeicon2");
        let repassword = document.getElementById("repassword");

        eyeicon2.onclick = function () {
            if (repassword.type === "password" && repassword.value.trim() !== "") {
                repassword.type = "text";
                eyeicon2.src = "assets/images/icons/hide.png";
            } else {
                repassword.type = "password";
                eyeicon2.src = "assets/images/icons/show.png";
            }
        };

        repassword.addEventListener("input", function () {
            if (repassword.value.trim() === "") {
                eyeicon2.style.display = "none";
            } else {
                eyeicon2.style.display = "inline-block";
            }
        });
    </script>

    <div class="nav-mobile">
        <div class="icon-container">
            <div class="icon">
                <a href="index.php"><ion-icon name="home-outline"></ion-icon></a>
            </div>
            <div class="icon">
                <?php if (!isset($_SESSION["user_id"])): ?>
                    <a href="login.php"><ion-icon name="person-outline"></ion-icon></a>
                <?php else: ?>
                    <a href="user.php"><ion-icon name="person-outline"></ion-icon></a>
                <?php endif; ?>
            </div>
            <div class="icon">
                <ion-icon name="menu-outline" id="menuBtnMobile"></ion-icon>
            </div>
            <div class="icon">
                <?php if (!isset($_SESSION["user_id"])): ?>
                    <a href="login.php"><ion-icon name="heart-outline"></ion-icon></a>
                <?php else: ?>
                    <a href="wishlist.php"><ion-icon name="heart-outline"></ion-icon></a>
                <?php endif; ?>
            </div>
            <div class="icon">
                <?php if (!isset($_SESSION["user_id"])): ?>
                    <a href="login.php"><ion-icon name="cart-outline"></ion-icon></a>
                <?php else: ?>
                    <a href="cart.php"><ion-icon name="cart-outline"></ion-icon></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="sideMenu.js"></script>
</body>

</html>