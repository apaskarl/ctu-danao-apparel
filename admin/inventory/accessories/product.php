<?php
$mysqli = require __DIR__ . "../../../../database.php";

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$sql = "SELECT pa.accessory_id, p.product_name,pa.quantity 
        FROM product_accessories pa 
        INNER JOIN product p ON pa.product_id = p.product_id
        WHERE pa.product_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error in preparing statement: " . $mysqli->error);
}

$stmt->bind_param("i", $product_id);

$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die("Invalid query: " . $mysqli->error);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Variants - Admin</title>
    <link rel="stylesheet" href="../../assets/css/adminxd.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function updateQuantity(variantId, newQuantity) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log("Quantity updated successfully");
                    } else {
                        console.error("Error updating quantity");
                    }
                }
            };
            xhr.open("POST", "update-quantity_accessories.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("variant_id=" + variantId + "&new_quantity=" + newQuantity);
        }
    </script>
</head>

<body>
    <section id="sidebar" class="hide">
        <ion-icon name="menu-outline" class="menu-bar"></ion-icon>
    
        <ul class="side-menu top">
            <li>
                <a href="../../dashboard.php">
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
                <a href="../../orders.php">
                    <ion-icon name="clipboard-outline"></ion-icon>
                    <span class="text">Orders</span>
                </a>
            </li>
            <li>
                <a href="../../users.php">
                    <ion-icon name="people-outline"></ion-icon>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="../../products.php">
                    <ion-icon name="pricetags-outline"></ion-icon>
                    <span class="text">Products</span>
                </a>
            </li>
            <li class="active">
                <a href="../../inventory.php">
                    <ion-icon name="cube-outline"></ion-icon>
                    <span class="text">Inventory</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <ion-icon name="settings-outline"></ion-icon>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
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
                        <select name="sort" id="">
                            <option value="">Sort</option>
                        </select>
                        <ion-icon name="filter-outline" class="filter-icon"></ion-icon>
                    </div>

                    <div class="action">
                        <a href="add.php?product_id=<?php echo $product_id; ?>" class="add">Add New Variant</a>
                    </div>
                </div>

                <div id="table-container">
                    <div id="table">
                        <table id="product-variant-table" class="table">
                            <thead>
                                <tr>
                                    <td>Accessory ID</td>
                                    <td>Product</td>
                                    <td>Stock</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                        <tr>
                                            <td>$row[accessory_id]</td>
                                            <td>$row[product_name]</td>
                                            <td><input type='number' value='$row[quantity]' onchange='updateQuantity($row[accessory_id], this.value)'></td>
                                            <td><a href='delete.php?variant_id=$row[accessory_id]&product_id=$product_id' class='delete-var'><ion-icon name='trash-outline'></ion-icon></a></td>
                                        </tr>
                                    ";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="action-container bottom">
                </div>
            </div>
        </main>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll('.delete-var');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    const productRow = button.closest('tr');
                    const variantId = productRow.querySelector('td:first-child').innerText;
                    const productName = productRow.querySelector('td:nth-child(2)').innerText;
                    const color = productRow.querySelector('td:nth-child(3)').innerText;
                    const size = productRow.querySelector('td:nth-child(4)').innerText;

                    const overlay = document.createElement('div');
                    overlay.classList.add('confirmation-overlay');
                    document.body.appendChild(overlay);

                    const confirmationDiv = document.createElement('div');
                    confirmationDiv.classList.add('confirmation');
                    confirmationDiv.innerHTML = `
                    <p>Are you sure you want to delete this variant?</p>
                    <h5 class="prod-details">${productName} / ${color} / ${size}</h5>
                    <div class="confirmation-buttons">
                        <button class="ok-btn">Delete</button>
                        <button class="cancel-btn">Cancel</button>
                    </div>
                `;
                    document.body.appendChild(confirmationDiv);

                    // Add event listeners to buttons
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
                        row.style.backgroundColor = '#f0f0f0'; // Add background color
                    } else {
                        row.style.backgroundColor = ''; // Remove background color
                    }
                    updateDeleteButtonStatus();
                });
            });
        });
    </script>

    <script src="../../assets/js/admin.js"></script>
</body>

</html>