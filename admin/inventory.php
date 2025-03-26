<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Admin</title>
    <link rel="stylesheet" href="assets/css/adminxd.css">
    <link rel="stylesheet" href="assets/css/admin.css">
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
            <li class="active">
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
            <h2>Inventory</h2>
        </nav>

        <main>
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
                </div>

                <div id="table-container">
                    <div id="table">
                        <table id="inventory-table" class="table">
                            <thead>
                                <tr>
                                    <td>Product ID</td>
                                    <td></td>
                                    <td>Product</td>
                                    <td>Category</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mysqli = require __DIR__ . "../../database.php";

                                $sql = "SELECT p.*, pc.category FROM product p
                                    INNER JOIN product_category pc ON p.category_id = pc.category_id";
                                $result = $mysqli->query($sql);

                                if (!$result) {
                                    die("Invalid query: " . $mysqli->connect_error);
                                }

                                while ($row = $result->fetch_assoc()) {
                                    $createdAt = strtotime($row['created_at']);
                                    $createdAtFormatted = date('F j, Y', $createdAt);
                                    $createdAtTime = date('g:i a', $createdAt);

                                    echo "
                                        <tr class='selectable-row'>
                                            <td>{$row['product_id']}</td>
                                            <td><img src='" . substr($row['product_img1'], 3) . "'></td>
                                            <td>{$row['product_name']}</td>
                                            <td>{$row['category']}</td>
                                            <td>";
                                                if($row['category'] === 'Accessories'){
                                                    echo "<a href='inventory/accessories/product.php?product_id={$row['product_id']}'><ion-icon name='add-outline'></ion-icon></a>";
                                                } else {
                                                    echo "<a href='inventory/variants/product.php?product_id={$row['product_id']}'><ion-icon name='add-outline'></ion-icon></a>";
                                                } "
                                            </td>
                                        </tr>
                                ";
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
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll('.delete-prod');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    const productRow = button.closest('tr');
                    const productId = productRow.querySelector('td:nth-child(2)').innerText;
                    const productName = productRow.querySelector('td:nth-child(4)').innerText;

                    const overlay = document.createElement('div');
                    overlay.classList.add('confirmation-overlay');
                    document.body.appendChild(overlay);

                    const confirmationDiv = document.createElement('div');
                    confirmationDiv.classList.add('confirmation');
                    confirmationDiv.innerHTML = `
                    <p>Are you sure you want to delete the product</p>
                    <h5 class="prod-details">"${productName}" (ID: ${productId})?<h5>
                    <div class="confirmation-buttons">
                        <button class="ok-btn">Delete</button>
                        <button class="cancel-btn">Cancel</button>
                    </div>
                `;
                    document.body.appendChild(confirmationDiv);

                    const okBtn = confirmationDiv.querySelector('.ok-btn');
                    const cancelBtn = confirmationDiv.querySelector('.cancel-btn');

                    okBtn.addEventListener('click', function () {
                        window.location.href = button.getAttribute('href');
                        confirmationDiv.remove();
                        overlay.remove();
                    });

                    cancelBtn.addEventListener('click', function () {
                        confirmationDiv.remove();
                        overlay.remove();
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAllButton = document.querySelector(".action-container .action button");
            const deleteButton = document.getElementById("deleteProduct");
            const checkboxes = document.querySelectorAll("input[type='checkbox'][name='selected_products[]']");
            let allSelected = false;

            function updateDeleteButtonStatus() {
                const atLeastOneChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                if (atLeastOneChecked || allSelected) {
                    deleteButton.classList.remove('disable');
                } else {
                    deleteButton.classList.add('disable');
                }
            }

            selectAllButton.addEventListener("click", function () {
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = !allSelected;
                    const row = checkbox.closest('.selectable-row');
                    row.classList.toggle('selected', allSelected);
                    if (allSelected) {
                        row.style.backgroundColor = '';
                    } else {
                        row.style.backgroundColor = '#f0f0f0';
                    }
                });
                allSelected = !allSelected;
                selectAllButton.textContent = allSelected ? 'Deselect all' : 'Select all';
                updateDeleteButtonStatus();
            });

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const row = checkbox.closest('.selectable-row');
                    row.classList.toggle('selected', checkbox.checked);
                    if (checkbox.checked) {
                        row.style.backgroundColor = '#f0f0f0'; 
                    } else {
                        row.style.backgroundColor = ''; 
                    }
                    updateDeleteButtonStatus();
                });
            });
        });
    </script>

    <script src="assets/js/admin.js"></script>
</body>

</html>