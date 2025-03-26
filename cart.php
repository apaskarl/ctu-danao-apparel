<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - CTU-Danao Apparel</title>
    <link rel="icon" type="image/png" href="assets/images/icons/ctudanaoapparel.png">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/cart.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <script src="https://kit.fontawesome.com/583fcf263c.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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
                            <a href="cart.php"><ion-icon name="cart-outline"></ion-icon><span style="display: none;">0</span></a>
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

    <div class="toast"></div>

    <section id="cart-header">
        <h1>My Cart</h1>
    </section>

    <section id="cart" class="section-p1-cart">
        <div class="cart-container">
            <table width="100%" id="parentElementId">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>
    
    <section id="footer">
        <footer id="footer">
            <div class="row">
                <div class="col">
                    <h3>CTU-Danao Apparel</h3>
                    <p>CTU-Danao Apparel is the official online store for Cebu Technological University - Danao Campus, offering a wide range of stylish and high-quality college apparel. Show your school spirit with our exclusive collection and represent CTU-Danao with pride!</p>
                </div>
                <div class="col">
                    <h3>Contact Us</h3>
                    <div class="footer-contact">
                        <div class="footer-infos">
                            <ion-icon name="mail-outline"></ion-icon>
                            <p><a href="mailto:ctudanaoapparel@gmail.com" target="_blank">ctudanaoapparel@gmail.com</a></p>
                        </div>
                        <div class="footer-infos">
                            <ion-icon name="call-outline"></ion-icon>
                            <p>09085275762</p>
                        </div>
                        <div class="footer-infos">
                            <ion-icon name="location-outline"></ion-icon>
                            <p>Sabang, Danao</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <h3>Follow us on</h3>
                    <div class="footer-contact">
                        <div class="footer-infos">
                            <ion-icon name="logo-facebook"></ion-icon>
                            <p><a href="https://www.facebook.com/profile.php?id=61560501741202" target="_blank">CTU-Danao Apparel</a></p>
                        </div>
                        <div class="footer-infos">
                            <ion-icon name="logo-instagram"></ion-icon>
                            <p><a href="https://www.instagram.com/ctuapparel/?hl=en&fbclid=IwAR3k3OpvH1c7VJVT4vYYGvFcjqgCULJO5_qeNQsvGkMeGdJ_0-9g_2_ZiIk" target="_blank">@ctudanaoapparel</a></p>
                        </div>
                        <div class="footer-infos">
                            <ion-icon name="logo-twitter"></ion-icon>
                            <p><a href="https://x.com/ctudanao2204?fbclid=IwAR267egfNFmSUuTHAQzWDwpr5VBPJ961hdXRbHiDmhzKu4zSl6-QCXO4HtY" target="_blank">@ctudanao_apparel</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p class="copyright">CTU-Danao Apparel © All Rights Reserved</p>
        </footer>
    </section>
    
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
    <script src="cart.js"></script>
    <script src="toast.js"></script>
</body>

</html>