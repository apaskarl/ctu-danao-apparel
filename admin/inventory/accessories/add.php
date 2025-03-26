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
    $quantity = $_POST['quantity'];

    $product_id = mysqli_real_escape_string($mysqli, $product_id);
    $quantity = mysqli_real_escape_string($mysqli, $quantity);

    $sql = "INSERT INTO product_accessories (product_id,quantity)
        VALUES ('$product_id', '$quantity')";

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