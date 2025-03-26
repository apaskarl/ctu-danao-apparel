<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="assets/checkout.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <link rel="stylesheet" href="assets/orderDetails_admin.css">
    
    <script src="https://kit.fontawesome.com/583fcf263c.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <header id="header">
        <div>
            <a href="admin.php" style="text-decoration: none;">
                <h4 id="logo-header">CTU-Danao Apparel - Admin</h4>
            </a>
        </div>
        <div>
            <ul id="navbar">
                <li><a href="admin.php">Products</a></li>
                <li><a class="active" href="orders.php">Orders</a></li>
            </ul>
        </div>
    </header>

    <section id="cart" class="section-p1-cart">
        <table width="100%" id="parentElementId">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

    <script src="orderDetails_admin.js"></script>
    <script src="script.js"></script>

</body>

</html>