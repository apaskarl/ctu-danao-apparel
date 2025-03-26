<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Now - CTU-Danao Apparel</title>
    <link rel="icon" type="image/png" href="assets/images/icons/ctudanaoapparel.png">
    <link rel="stylesheet" href="assets/sproduct.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/shop.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <script src="https://kit.fontawesome.com/583fcf263c.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

    <div class="toast">
        <div class="toast-content">
            <ion-icon name="checkmark-outline" class="check success"></ion-icon>

            <div class="message">
                <span class="text text-1">Successfully added to cart</span>
            </div>

            <div class="progress success"></div>
        </div>
    </div>

    <section id="prod-details" class="section-p1">
        <?php
        $mysqli = require __DIR__ . "/database.php";
        $color_id = null;
        $size_id = null;
        if (isset($_GET['product_id']) || isset($_GET['category'])) {
            $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

            $variants_sql = "SELECT color_id, size_id FROM product_variant WHERE product_id = $product_id";
            $variants_result = $mysqli->query($variants_sql);
            $available_colors = [];
            $available_sizes = [];

            if ($variants_result->num_rows > 0) {
                while ($variants_row = $variants_result->fetch_assoc()) {
                    $color_sql = "SELECT color FROM product_color WHERE color_id = " . $variants_row['color_id'];
                    $color_result = $mysqli->query($color_sql);
                    $color_row = $color_result->fetch_assoc();
                    $available_colors[$variants_row['color_id']] = $color_row['color'];

                    $size_sql = "SELECT size FROM product_size WHERE size_id = " . $variants_row['size_id'];
                    $size_result = $mysqli->query($size_sql);
                    $size_row = $size_result->fetch_assoc();
                    $available_sizes[$variants_row['size_id']] = $size_row['size'];
                }
            }

            $product_sql = "SELECT product_id, product_name, price, description, product_img1, product_img2, product_img3, product_img4 FROM product WHERE product_id = $product_id";
            $product_result = $mysqli->query($product_sql);

            if ($product_result->num_rows > 0) {
                $row = $product_result->fetch_assoc();
                ?>
                <script>
                    let products = [{
                        name: "<?php echo $row['product_name']; ?>",
                        tag: "product<?php echo $row['product_id']; ?>",
                        price: <?php echo $row['price']; ?>,
                        size: "",
                        color: "",
                        inCart: 0,
                        stock: 0,
                        image: "<?php echo substr($row['product_img1'], 6); ?>"
                    }];
                </script>

                <div class="single-prod-img">
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="<?php echo substr($row["product_img1"], 6); ?>" alt="" width="100%" class="small-img selected">
                        </div>
                        <div class="small-img-col">
                            <img src="<?php echo substr($row["product_img2"], 6); ?>" alt="" width="100%" class="small-img">
                        </div>
                        <div class="small-img-col">
                            <img src="<?php echo substr($row["product_img3"], 6); ?>" alt="" width="100%" class="small-img">
                        </div>
                        <div class="small-img-col">
                            <img src="<?php echo substr($row["product_img4"], 6); ?>" alt="" width="100%" class="small-img">
                        </div>
                    </div>

                    <img src="<?php echo substr($row["product_img1"], 6); ?>" id="main-img">

                    
                </div>

                <div class="small-img-group-mobile">
                        <div class="small-img-col-mobile">
                            <img src="<?php echo substr($row["product_img1"], 6); ?>" class="small-img selected">
                    </div>
                    <div class="small-img-col-mobile">
                        <img src="<?php echo substr($row["product_img2"], 6); ?>" class="small-img">
                    </div>
                    <div class="small-img-col-mobile">
                        <img src="<?php echo substr($row["product_img3"], 6); ?>" class="small-img">
                    </div>
                    <div class="small-img-col-mobile">
                        <img src="<?php echo substr($row["product_img4"], 6); ?>" class="small-img">
                    </div>
                </div>

                <div class="single-prod-details">
                    <h2><?php echo $row['product_name']; ?></h2>
                    <h4>₱<?php echo $row['price']; ?>.00</h4>
                    <hr>
                    <div class="prod-option">
                    <?php if (!empty($available_colors)) { ?>
                            <div id="selectCOLOR">
                                <h5>COLOR</h5>
                                <?php foreach ($available_colors as $color_id => $color_name) { ?>
                                    <button class="color-btn" data-color="<?php echo $color_name; ?>" data-color-id = "<?php echo $color_id?>"><?php echo $color_name; ?></button>
                                <?php } ?>
                            </div>
                        <?php } else if (empty($available_colors)) { ?>
                            <div id="selectCOLOR" style="display: none;">
                                <button class="color-btn" data-color="" class="selected"></button>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="prod-option">
                        <?php if (!empty($available_sizes)) { ?>
                            <div id="selectSize">
                                <h5>SIZE</h5>
                                <?php foreach ($available_sizes as $size_id => $size_name) { ?>
                                    <button class="size-btn" data-product-id="<?php echo $product_id;?>" data-size="<?php echo $size_name; ?>" data-size-id = "<?php echo $size_id?>"><?php echo $size_name; ?></button>
                                <?php } ?>
                            </div>
                        <?php } else if (empty($available_sizes)) { ?>
                            <div id="selectSize" style="display: none;">
                                <button class="size-btn" data-size="" class="selected"></button>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="prod-option">
                        <div id="selectQuantity">
                            <h5>QUANTITY</h5>
                            <div class="qty-wrapper">
                                <button class="minus qty-btn">-</button>
                                <input type="number" class="quantity" value="1" readonly>
                                <button class="plus qty-btn">+</button>
                            </div>
                        </div>
                    </div>
                    <h5 class="stock" id="stocks" style="display: none;"></h5>
                    
                    <a href="#" class="add-cart"><span>Add to cart</span></a>
                    <a href="#" class="add-wishlist"><span>Add to wishlist</span></a>

                    <h4>Product details</h4>
                    <p><?php echo $row['description']; ?></p>
                </div>
                
                <?php
            } else {
                echo "Product not found";
            }
        } else {
            echo "No product ID provided";
        }
        ?>
    </section>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".add-wishlist").addEventListener("click", function(event) {
        event.preventDefault();

        const userId = <?php echo $_SESSION['user_id']; ?>; 
                    const productId = <?php echo $product_id; ?>;

                    fetch("add_to_wishlist.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ user_id: userId, product_id: productId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showSuccessMessage("Product added to wishlist");
                            } else if (data.message === "Product already in the wishlist") {
                                showFailedMessage("Product already in the wishlist");
                            } else {
                                alert("Failed to add product to wishlist.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("An error occurred while adding product to wishlist.");
                        });
                });

                function showSuccessMessage(message) {
                    const toast = document.querySelector('.toast');
                    toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="heart-outline" class="check wishlist"></ion-icon>
                <div class="message">
                    <span class="text text-1">${message}</span>
                </div>
                <div class="progress wishlist"></div>
            </div>
        `;
                    toast.classList.add("active");
                    const progress = document.querySelector('.progress');
                    progress.classList.add("active");

                    setTimeout(() => {
                        toast.classList.remove("active");
                    }, 2000);

                    setTimeout(() => {
                        progress.classList.remove("active");
                    }, 2300);
                }

                function showFailedMessage(message) {
                    const toast = document.querySelector('.toast');
                    toast.innerHTML = `
            <div class="toast-content">
                <ion-icon name="alert-outline" class="check wishlist-failed"></ion-icon>
                <div class="message">
                    <span class="text text-1">${message}</span>
                </div>
                <div class="progress wishlist-failed"></div>
            </div>
        `;
                    toast.classList.add("active");
                    const progress = document.querySelector('.progress');
                    progress.classList.add("active");

                    setTimeout(() => {
                        toast.classList.remove("active");
                    }, 2000);

                    setTimeout(() => {
                        progress.classList.remove("active");
                    }, 2300);
                }
            });
    </script>

    <!-- CHANGE MAIN IMAGE -->
    <script>
        window.onload = function () {
            window.scrollTo(0, 0);
        }

        var mainImg = document.getElementById('main-img');
        var smallImg = document.getElementsByClassName("small-img");

        smallImg[0].onclick = function () {
            mainImg.src = smallImg[0].src;
        }
        smallImg[1].onclick = function () {
            mainImg.src = smallImg[1].src;
        }
        smallImg[2].onclick = function () {
            mainImg.src = smallImg[2].src;
        }
        smallImg[3].onclick = function () {
            mainImg.src = smallImg[3].src;
        }

        for (var i = 0; i < smallImg.length; i++) {
            smallImg[i].onclick = function () {
                mainImg.src = this.src;
                var prevSelected = document.querySelector('.small-img.selected');
                if (prevSelected) {
                    prevSelected.classList.remove('selected');
                }
                this.classList.add('selected');
            }
        }
    </script>

    <!-- TOAST MESSAGE -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.add-cart').addEventListener('click', function (event) {
            <?php if (!isset($_SESSION["user_id"])): ?>
                    event.preventDefault();
                    const toast = document.querySelector('.toast');
                    toast.innerHTML = `
                        <div class="toast-content">
                            <ion-icon name="alert-outline" class="check failed"></ion-icon>
                            <div class="message">
                                <span class="text text-1">You need to log in first</span>
                            </div>
                            <div class="progress failed"></div>
                        </div>
                    `;
                    toast.classList.add("active");
                    const progress = document.querySelector('.progress');
                    progress.classList.add("active");

                    setTimeout(() => {
                        toast.classList.remove("active");
                    }, 2000);

                    setTimeout(() => {
                        progress.classList.remove("active");
                    }, 2300);
                <?php endif; ?>
            });
        });
    </script>

    <script src="script.js"></script>
    <script src="sideMenu.js"></script>
    <script src="stockQty.js"></script>
    <script src="script.js"></script>
    <script src="toast.js"></script>
    <?php if (isset($_SESSION["user_id"])): ?>
        <script src="cart.js"></script>
    <?php endif; ?>
</body>

</html>