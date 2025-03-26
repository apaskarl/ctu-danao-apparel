<?php
$mysqli = require __DIR__ . "../../../database.php";

$product_id = "";
$product_name = "";
$category_id = "";
$description = "";
$price = "";

$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["product_id"])) {
        header("location: admin-products.php");
        exit;
    }
    $product_id = $_GET["product_id"];

    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: ../products.php");
        exit;
    }

    $product_name = $row["product_name"];
    $description = $row["description"];
    $category_id = $row["category_id"];
    $price = $row["price"];

} else {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['desc'];
    $price = $_POST['price'];

    $product_name_escaped = mysqli_real_escape_string($mysqli, $product_name);

    $sql = "UPDATE product " .
        "SET product_name = '$product_name_escaped', category_id = '$category_id', description = '$description', price = '$price' " .
        "WHERE product_id = '$product_id'";

    $result = $mysqli->query($sql);

    if (!$result) {
        die("Invalid query: " . $mysqli->connect_error);
    }

    $success = "Product updated successfully.";

    header("location: ../products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Product</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../assets/css/add-product.css">
</head>

<body>
    <div class="container">
        <h3>Edit product</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <!-- <div class="img-container">
                <img src="assets/images/products/default.jpg" alt="">
                <input type="file" name="image" accept=".jpg, .jpeg, .png">
            </div> -->
            <div>
                <div class="input-box">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" value="<?php echo $product_name; ?>" required>
                </div>
                <div>
                    <label for="category_id">Category</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                        $category_query = "SELECT * FROM product_category";
                        $category_result = $mysqli->query($category_query);
                        if ($category_result->num_rows > 0) {
                            while ($row = $category_result->fetch_assoc()) {
                                echo "<option value='" . $row['category_id'] . "'>" . $row['category'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="input-box">
                    <label for="desc">Description</label>
                    <textarea name="desc" cols="30" rows="10" value="<?php echo $description; ?>"></textarea>
                </div>
                <div class="input-box">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="<?php echo $price; ?>" required>
                </div>


                <?php
                if (!empty($success)) {
                    echo $success;
                }
                ?>

                <div class="btn-container">
                    <button type="submit" class="btn">Submit</button>
                    <a href="../products.php" class="btn">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>