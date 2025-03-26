<?php
session_start();
$mysqli = require __DIR__ . "../../database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="assets/css/adminxd.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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
            <li class="active">
                <a href="dashboard.php">
                    <ion-icon name="grid-outline"></ion-icon>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <ion-icon name="analytics-outline"></ion-icon>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <ion-icon name="clipboard-outline"></ion-icon>
                    <span class="text">Orders</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <ion-icon name="people-outline"></ion-icon>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="products.php">
                    <ion-icon name="pricetags-outline"></ion-icon>
                    <span class="text">Products</span>
                </a>
            </li>
            <li>
                <a href="inventory.php">
                    <ion-icon name="cube-outline"></ion-icon>
                    <span class="text">Inventory</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="settings.php">
                    <ion-icon name="settings-outline"></ion-icon>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout-admin.php" class="logout">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span class="text">Log out</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <h2>Dashboard</h2>
        </nav>

        <main>
            <ul class="box-info">
                <a href="orders.php">
                    <li>
                        <div class="icon-box">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <span class="text">
                            <?php 
                            $sql_count_pending = "SELECT COUNT(DISTINCT order_id) as count FROM order_data";
                            $result_pending = $mysqli->query($sql_count_pending);
                            if ($result_pending) {
                                $row_pending = $result_pending->fetch_assoc();
                                $count_pending = $row_pending['count'];
                            } else {
                                $count_pending = 0;
                            }
                            ?>
                            <h3><?php echo $count_pending; ?></h3>
                            <p>Pending Orders</p>
                        </span>
                    </li>
                </a>
                <a href="users.php">
                    <li>
                        <div class="icon-box">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                        <span class="text">
                            <?php
                            $sql_count_user = "SELECT COUNT(DISTINCT user_id) as count FROM user";
                            $result_user = $mysqli->query($sql_count_user);
                            if ($result_user) {
                                $row_user = $result_user->fetch_assoc();
                                $count_user = $row_user['count'];
                            } else {
                                $count_user = 0;
                            }
                            ?>
                            <h3><?php echo $count_user; ?></h3>
                            <p>Users</p>
                        </span>
                    </li>
                </a>
                <a href="orders/completed.php">
                    <li>
                        <div class="icon-box">
                            <ion-icon name="wallet-outline"></ion-icon>
                        </div>
                        <span class="text">
                        <?php
                        $sql_total_sales = "SELECT SUM(subtotal) AS total_sales FROM order_completed";
                        $result_total = $mysqli->query($sql_total_sales);

                        if ($result_total) {
                            $row_total = $result_total->fetch_assoc();
                            $sum_total = $row_total['total_sales'];
                        } else {
                            $sum_total = 0;
                        }
                        ?>
                        <h3>₱<?php echo $sum_total; ?>.00</h3>
                        <p>Total Sales</p>
                        </span>
                    </li>
                </a>
            </ul>
        </main>
    </section>
    <script src="assets/js/admin.js"></script>
    <?php endif; ?>
</body>
</html>