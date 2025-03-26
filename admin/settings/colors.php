<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/adminxd.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <?php include 'add-color.php'; ?>
</head>

<body>
    <?php if (!isset($_SESSION["admin_id"])): ?>

        <div class="no-access">
            <ion-icon name="warning-outline"></ion-icon>
            <h1>You don't have permission to view this page.</h1>
            <h3>This page requires proper authorization for access.</h3>

            <p>Return to <a href="../index.php">CTU-Danao Apprel - Home Page</a>.</p>
        </div>

    <?php else: ?>

        <section id="sidebar" class="hide">
            <ion-icon name="menu-outline" class="menu-bar"></ion-icon>

            <ul class="side-menu top">
                <li>
                    <a href="../dashboard.php">
                        <ion-icon name="grid-outline"></ion-icon>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../analytics.php">
                        <ion-icon name="analytics-outline"></ion-icon>
                        <span class="text">Analytics</span>
                    </a>
                </li>
                <li>
                    <a href="../orders.php">
                        <ion-icon name="clipboard-outline"></ion-icon>
                        <span class="text">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="../users.php">
                        <ion-icon name="people-outline"></ion-icon>
                        <span class="text">Users</span>
                    </a>
                </li>
                <li>
                    <a href="../products.php">
                        <ion-icon name="pricetags-outline"></ion-icon>
                        <span class="text">Products</span>
                    </a>
                </li>
                <li>
                    <a href="../inventory.php">
                        <ion-icon name="cube-outline"></ion-icon>
                        <span class="text">Inventory</span>
                    </a>
                </li>
            </ul>
            <ul class="side-menu">
                <li class="active">
                    <a href="../settings.php">
                        <ion-icon name="settings-outline"></ion-icon>
                        <span class="text">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="../logout-admin.php" class="logout">
                        <ion-icon name="log-out-outline"></ion-icon>
                        <span class="text">Log out</span>
                    </a>
                </li>
            </ul>
        </section>

        <div class="background"></div>

        <div class="add-container">
            <h3>Add color</h3>
            <form action="" method="post">
                <div class="input-box">
                    <input type="text" name="color" required>
                    <label for="color">Color</label>
                </div>
                <div class="btn-container">
                    <button type="submit" id="confirm">Add</button>
                    <button type="button" id="cancel">Cancel</button>
                </div>
            </form>

            <script>
                let eyeicon = document.getElementById("eyeicon");
                let password = document.getElementById("password");

                eyeicon.onclick = function () {
                    if (password.type === "password" && password.value.trim() !== "") {
                        password.type = "text";
                        eyeicon.src = "../assets/images/icons/hide.png";
                    } else {
                        password.type = "password";
                        eyeicon.src = "../assets/images/icons/show.png";
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
        </div>

        <section id="content">
            <nav>
                <h2>Settings</h2>
            </nav>

            <main>
                <div class="settings-container">
                    <div class="settings-container-left">
                        <div class="settings-link">
                            <ion-icon name="key-outline"></ion-icon>
                            <a href="../settings.php">Admin</a>
                        </div>
                        <div class="settings-link">
                            <ion-icon name="expand-outline"></ion-icon>
                            <a href="sizes.php">Size</a>
                        </div>
                        <div class="settings-link active">
                            <ion-icon name="color-fill-outline"></ion-icon>
                            <a href="colors.php">Color</a>
                        </div>
                    </div>

                    <div class="settings-container-right">
                        <div class="container">
                            <div class="action-container top">
                                <div class="search">
                                    <form action="#">
                                        <div class="form-input">
                                            <input type="search" placeholder="Search">
                                            <button type="submit" class="search-btn"><ion-icon
                                                    name="search-outline"></ion-icon></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="action">
                                    <button class="add" id="addAdmin">Add color</button>
                                </div>
                            </div>

                            <div id="table-container">
                                <div id="table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Color ID</td>
                                                <td>Color</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $mysqli = require __DIR__ . "../../../database.php";

                                            $sql = "SELECT * FROM product_color LIMIT 18446744073709551615 OFFSET 1";
                                            $result = $mysqli->query($sql);

                                            if (!$result) {
                                                die("Invalid query: " . $mysqli->connect_error);
                                            }

                                            while ($row = $result->fetch_assoc()) {
                                                echo "
                                                    <tr>
                                                        <td>{$row['color_id']}</td>
                                                        <td>{$row['color']}</td>
                                                        <td>
                                                            <a href='delete-color.php?color_id={$row['color_id']}'><ion-icon name='trash-outline'></ion-icon></a>
                                                        </td>
                                                    </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </section>
        
        <script src="../assets/js/admin.js"></script>
    <?php endif; ?>
</body>

</html>