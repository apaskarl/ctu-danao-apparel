<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - CebuTech Apparel</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/checkout.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <link rel="stylesheet" href="assets/orderDetails.css">
    
    <script src="https://kit.fontawesome.com/583fcf263c.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="menu-wrap" id="menuWrap">
        <div class="menu-wrap-content">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Menu</h2>
                <a class="close-btn" id="closeBtn"><ion-icon name="close-outline"></ion-icon></a>
            </div>

            <div class="menu-nav-links">
                <ul>
                    <a href="index.php">
                        <li>Home</li>
                    </a>
                    <hr>
                    <a class="active" href="shop.php">
                        <li>Shop</li>
                    </a>
                    <hr>
                    <a href="about.php">
                        <li>About</li>
                    </a>
                    <hr>
                    <a href="contact.php">
                        <li>Contact</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.getElementById('menuBtn');
            const menuWrap = document.getElementById('menuWrap');
            const closeBtn = document.getElementById('closeBtn');
            const overlay = document.getElementById('overlay');
            menuBtn.addEventListener('click', function () {
                menuWrap.classList.toggle('active');
                overlay.style.display = menuWrap.classList.contains('active') ? 'block' : 'none';
                document.body.style.overflow = menuWrap.classList.contains('active') ? 'hidden' : '';
                if (menuWrap.classList.contains('active')) {
                    menuWrap.style.position = 'fixed';
                    menuWrap.style.top = '0';
                    menuWrap.style.left = '0';
                    menuWrap.style.height = '100%';
                    menuWrap.style.width = '30%';
                    menuWrap.style.overflowY = 'auto';
                } else {
                    menuWrap.style.position = 'absolute';
                    menuWrap.style.top = '0';
                    menuWrap.style.left = '-30%';
                    menuWrap.style.width = '0';
                }
            });

            closeBtn.addEventListener('click', function () {
                menuWrap.classList.remove('active');
                overlay.style.display = 'none';
                document.body.style.overflow = '';
                menuWrap.style.position = 'absolute';
                menuWrap.style.top = '0';
                menuWrap.style.left = '-30%';
                menuWrap.style.width = '0';
            });

            document.addEventListener('click', function (event) {
                if (!menuWrap.contains(event.target) && event.target !== menuBtn) {
                    menuWrap.classList.remove('active');
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                    menuWrap.style.position = 'absolute';
                    menuWrap.style.top = '0';
                    menuWrap.style.left = '-30%';
                    menuWrap.style.width = '0';
                }
            });
        });
    </script>

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

            <div class="nav-menu">
                <?php if (!isset($_SESSION["user_id"])): ?>
                    <a href="login.php"><ion-icon name="person-circle-outline"></ion-icon></a>
                <?php else: ?>
                    <img src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>"
                        class="user-pic" onclick="toggleMenu()">
                    <li class="fave">
                        <a href="fave.php"><ion-icon name="heart-outline"></ion-icon></a>
                    </li>
                    <li class="cart">
                        <a href="cart.php"><ion-icon name="cart-outline"></ion-icon></a>
                    </li>
                <?php endif; ?>
                <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                        <?php if (isset($_SESSION["user_id"])): ?>
                            <div class="user-info">
                                <img
                                    src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>">
                                <p><?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>
                                    <?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>
                                </p>
                            </div>
                            <hr>
                            <a href="user.php" class="sub-menu-link">
                                <ion-icon name="person"></ion-icon>
                                <p>Profile</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                            <a href="#" class="sub-menu-link">
                                <ion-icon name="settings"></ion-icon>
                                <p>Settings</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                            <a href="logout.php" class="sub-menu-link">
                                <ion-icon name="log-out"></ion-icon>
                                <p>Log out</p>
                                <span><ion-icon name="chevron-forward-outline"></ion-icon></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </ul>
    </header>

    <section id="cart" class="section-p1-cart">
        <h4 style="display: flex; justify-content: center; align-items: center; padding: 30px 0; font-size: 23px;">Recent Purchases</h4>
        <table width="100%" id="parentElementId">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>
    <div class="infoContainer" id="checkOutInfo">
        <div class="information">
            <h3 class="personalText">Personal Information</h3><hr>
            <form action="/action_page.php">
                <label for="fname">First name:</label>
                <?php if (isset($_SESSION["user_id"])): ?>
                <input type="text" id="fname" name="fname" value="<?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>" readonly>

                <label for="lname">Last name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>" readonly>

                <label for="contactNum">Contact Number:</label>
                <input type="tel" id="contactNum" name="contact" required>

                <label for="emailAdd">Email Address:</label>
                <input type="email" id="emailAdd" name="email" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ''; ?>" required>
                <?php endif; ?>
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>

                <label for="course">Course:</label>
                <input type="text" id="course" name="course" required>

                <label for="session">Session (Day or Night):</label>
                <input type="text" id="session" name="session" required>

                <label for="section">Section:</label>
                <input type="text" id="section" name="section" required>

                <button class = "button_Submit" id="btn_submit">Order Now</button>
            </form>                 
        </div>

    </div>
    
    <section id="footer">
        <footer id="footer">
            <div class="row">
                <div class="col">
                    <h3>CebuTech Apparel</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ex nam, sunt consectetur necessitatibus
                        voluptates impedit aperiam nisi doloribus praesentium placeat incidunt, illo eius libero quod
                        eveniet
                        ad. Expedita, porro iste.</p>
                </div>
                <div class="col">
                    <h3>Contact Us</h3>
                    <div class="footer-contact">
                        <div class="footer-infos">
                            <ion-icon name="mail-outline"></ion-icon>
                            <p>cebutechapparel@gmail.com</p>
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
                            <a href=""><ion-icon name="logo-facebook"></ion-icon></a>
                            <p>CebuTech Apparel</p>
                        </div>
                        <div class="footer-infos">
                            <a href=""><ion-icon name="logo-instagram"></ion-icon></a>
                            <p>@cebutechapparel</p>
                        </div>
                        <div class="footer-infos">
                            <a href=""><ion-icon name="logo-twitter"></ion-icon></a>
                            <p>@cebutech_apparel</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p class="copyright">CebuTech Apparel © All Rights Reserved</p>
        </footer>
    </section>

    <script src="orderDetails.js"></script>
    <script src="purchase.js"></script>
    <script src="script.js"></script>

</body>

</html>