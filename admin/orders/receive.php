<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin</title>
    <link rel="stylesheet" href="../assets/css/adminxd.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
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
                <a href="#">
                    <ion-icon name="analytics-outline"></ion-icon>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li class="active">
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
            <li>
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

    <section id="content">
        <nav>
            <h2>Orders</h2>
        </nav>

        <main>
            <div class="container">
                <div class="action-container top">
                    <div class="search">
                        <form action="receive.php" method="GET">
                            <div class="form-input">
                                <input type="search" name="search_order_id" placeholder="Search Order ID">
                                <button type="submit" class="search-btn"><ion-icon name="search-outline"></ion-icon></button>
                            </div>
                        </form>
                    </div>

                    <div class="orders-nav">
                <div class="action">
                    <?php
                            $mysqli = require __DIR__ . "../../../database.php";

                            $sql_count_pending = "SELECT COUNT(DISTINCT order_id) as count FROM order_data";
                            $result_pending = $mysqli->query($sql_count_pending);
                            if ($result_pending) {
                                $row_pending = $result_pending->fetch_assoc();
                                $count_pending = $row_pending['count'];
                            } else {
                                $count_pending = 0;
                            }

                            $sql_count_processing = "SELECT COUNT(DISTINCT order_id) as count FROM order_processing";
                            $result_processing = $mysqli->query($sql_count_processing);
                            if ($result_processing) {
                                $row_processing = $result_processing->fetch_assoc();
                                $count_processing = $row_processing['count'];
                            } else {
                                $count_processing = 0;
                            }

                            $sql_count_ready = "SELECT COUNT(DISTINCT order_id) as count FROM order_receive";
                            $result_ready = $mysqli->query($sql_count_ready);
                            if ($result_ready) {
                                $row_ready = $result_ready->fetch_assoc();
                                $count_ready = $row_ready['count'];
                            } else {
                                $count_ready = 0;
                            }

                            $sql_count_completed = "SELECT COUNT(DISTINCT order_id) as count FROM order_completed";
                            $result_completed = $mysqli->query($sql_count_completed);
                            if ($result_completed) {
                                $row_completed = $result_completed->fetch_assoc();
                                $count_completed = $row_completed['count'];
                            } else {
                                $count_completed = 0;
                            }

                            $sql_count_cancelled = "SELECT COUNT(DISTINCT order_id) as count FROM order_cancelled";
                            $result_cancelled = $mysqli->query($sql_count_cancelled);
                            if ($result_cancelled) {
                                $row_cancelled = $result_cancelled->fetch_assoc();
                                $count_cancelled = $row_cancelled['count'];
                            } else {
                                $count_cancelled = 0;
                            }
                            ?>
                    
                            <a href="../orders.php">Pending <span>(<?php echo $count_pending; ?>)</span></a>
                            <a href="processing.php">Processing <span>(<?php echo $count_processing; ?>)</span></a>
                            <a href="receive.php" class="active">Ready <span>(<?php echo $count_ready; ?>)</span></a>
                            <a href="completed.php">Completed <span>(<?php echo $count_completed; ?>)</span></a>
                            <a href="cancel.php">Cancelled <span>(<?php echo $count_cancelled; ?>)</span></a>
                        </div>
                    </div>
                </div>
                
                <div id="table-container">
                    <div id="table">
                        <table class="table" id="order-table">
                            <thead>
                                <tr>
                                    <td>Order ID</td>
                                    <td>Buyer Name</td>
                                    <td>Total Quantity</td>
                                    <td>Total</td>
                                    <td>Date Ordered</td>
                                    <td></td>
                            </thead>
                            <tbody>
                                <?php
                                    $mysqli = require __DIR__ . "../../../database.php";

                                    $search_order_id = isset($_GET['search_order_id']) ? $_GET['search_order_id'] : '';

                                    $sql = "SELECT 
                                                oRe.order_id, oRe.order_date,
                                                CONCAT(u.firstname, ' ', u.lastname) AS full_name,
                                                SUM(oRe.quantity) AS total_quantity,
                                                SUM(oRe.subtotal) AS total_cost,
                                                u.user_id
                                            FROM 
                                                order_receive oRe
                                            JOIN 
                                                user u ON oRe.user_id = u.user_id";

                                    if (!empty($search_order_id) && $search_order_id !== 'all') {
                                        $sql .= " WHERE oRe.order_id = ?";
                                    }

                                    $sql .= " GROUP BY 
                                                oRe.order_id, full_name
                                            ORDER BY 
                                                oRe.order_id DESC";

                                $stmt = $mysqli->prepare($sql);

                                if (!empty($search_order_id) && $search_order_id !== 'all') {
                                    $stmt->bind_param("s", $search_order_id);
                                }

                                $stmt->execute();
                                $result = $stmt->get_result();

                                if (!$result) {
                                    die("Invalid query: " . $mysqli->error);
                                }

                                while ($row = $result->fetch_assoc()) {
                                    $orderDate = strtotime($row['order_date']);
                                    $orderDateFormatted = date('F j, Y', $orderDate);
                                    $orderDateTime = date('g:i a', $orderDate);

                                    echo "
                                    <tr>
                                        <td>{$row['order_id']}</td>
                                        <td>{$row['full_name']}</td>
                                        <td>{$row['total_quantity']}</td>
                                        <td>₱" . number_format($row['total_cost'], 2) . "</td>
                                        <td>{$orderDateFormatted} - {$orderDateTime}</td>
                                        <td><button class='completed' data-order-id='{$row['order_id']}'>Completed</button></td>
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

    <script src="../assets/js/admin.js"></script>
</body>
</html>

