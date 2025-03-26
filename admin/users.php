<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - Admin</title>
    <link rel="stylesheet" href="assets/css/adminxd.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <section id="sidebar" class="hide">
        <ion-icon name="menu-outline" class="menu-bar"></ion-icon>
    
        <ul class="side-menu top">
            <li>
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
            <li class="active">
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
            <h2>Users</h2>
        </nav>

        <main>
            <div class="container">
                <div class="action-container top">
                    <div class="search">
                        <form action="#">
                            <div class="form-input">
                                <input type="search" placeholder="Search">
                                <button type="submit" class="search-btn"><ion-icon name="search-outline"></ion-icon></button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div id="table-container">
                    <div id="table">
                        <table class="table" id="user-table">
                            <thead>
                                <tr>
                                    <td>User ID</td>
                                    <td></td>
                                    <td>User</td>
                                    <td>Username</td>
                                    <td>Email</td>
                                    <td>Created At</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $mysqli = require __DIR__ . "../../database.php";

                                    $sql = "SELECT * FROM user";
                                    $result = $mysqli->query($sql);

                                    if (!$result) {
                                        die("Invalid query: " . $mysqli->connect_error);
                                    }

                                    while ($row = $result->fetch_assoc()) {
                                    $createdAt = strtotime($row['created_at']);
                                    $createdAtFormatted = date('F j, Y', $createdAt); // Format as "Month day, Year"
                                    $createdAtTime = date('g:i a', $createdAt);
                                        echo "
                                    <tr>
                                        <td>{$row['user_id']}</td>
                                        <td><img src='../{$row['profile_pic']}' alt='Profile Picture'></td>
                                        <td>{$row['firstname']} {$row['lastname']}</td>
                                        <td>{$row['username']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$createdAtFormatted} - {$createdAtTime}</td>
                                    </tr>";
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllButton = document.querySelector(".action-container .action button");
            const checkboxes = document.querySelectorAll("input[type='checkbox'][name='selected_users[]']");
            let allSelected = false;

            selectAllButton.addEventListener("click", function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !allSelected;
                });
                allSelected = !allSelected;
                selectAllButton.textContent = allSelected ? 'Deselect all' : 'Select all';
            });
        });
    </script>

    <script src="assets/js/admin.js"></script>
</body>
</html>