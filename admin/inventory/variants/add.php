<?php
$mysqli = require __DIR__ . "../../../../database.php";

$product_id = ""; 

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
}

$color_id = "";
$size_id = "";
$quantity = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $color_id = $_POST['color_id'];
    $size_id = $_POST['size_id'];
    $quantity = $_POST['quantity'];

    $product_id = mysqli_real_escape_string($mysqli, $product_id);
    $color_id = mysqli_real_escape_string($mysqli, $color_id);
    $size_id = mysqli_real_escape_string($mysqli, $size_id);
    $quantity = mysqli_real_escape_string($mysqli, $quantity);

    $sql = "INSERT INTO product_variant (product_id, color_id, size_id, quantity)
        VALUES ('$product_id', '$color_id', '$size_id', '$quantity')";

    if ($mysqli->query($sql) === TRUE) {
        header("Location: product.php?product_id=" . $_GET['product_id']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Variant</title>
    <link rel="stylesheet" href="../../../assets/style.css">
    <link rel="stylesheet" href="../../assets/css/add-product.css">
</head>

<body>
    <div class="container">
        <h3>New product variant</h3>
        <form method="post" enctype="multipart/form-data" id="form-variant">
            <div>
                <div class="input-box">
                    <label for="product_id">Product ID</label>
                    <input type="text" name="product_id" value="<?php echo $product_id; ?>" required readonly>
                </div>

                <div>
                    <label for="color_id">Color</label>
                    <select name="color_id" required>
                        <option value="">Select Color</option>
                        <?php
                        $color_query = "SELECT * FROM product_color";
                        $color_result = $mysqli->query($color_query);
                        if ($color_result->num_rows > 0) {
                            while ($row = $color_result->fetch_assoc()) {
                                echo "<option value='" . $row['color_id'] . "'>" . $row['color'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="size_id">Size</label>
                    <select name="size_id" required>
                        <option value="">Select Size</option>
                        <?php
                        $size_query = "SELECT * FROM product_size";
                        $size_result = $mysqli->query($size_query);
                        if ($size_result->num_rows > 0) {
                            while ($row = $size_result->fetch_assoc()) {
                                echo "<option value='" . $row['size_id'] . "'>" . $row['size'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <!-- class="input-box" -->
                <div>
                    <label for="quantity">Quantity</label>
                    <input type="text" name="quantity" value="<?php echo $quantity; ?>" required>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn">Submit</button>
                    <a href="product.php?product_id=<?php echo $product_id; ?>" class="btn">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>