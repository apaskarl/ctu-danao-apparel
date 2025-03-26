<?php
$mysqli = require __DIR__ . "../../../database.php";

$product_name = "";
$category_id = "";
$description = "";
$price = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['desc'];
    $price = $_POST['price'];

    // Process image uploads
    $number_of_images = $_POST['numberImg'];
    $uploaded_files = [];

    for ($i = 1; $i <= $number_of_images; $i++) {
        $target_dir = "../../assets/images/uploads/";
        $target_file = $target_dir . basename($_FILES["image" . $i]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is selected
        if (!empty($_FILES["image" . $i]["tmp_name"])) {
            // Check if file is an image
            $check = getimagesize($_FILES["image" . $i]["tmp_name"]);
            if ($check !== false) {
                // Check file size
                if ($_FILES["image" . $i]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                } else {
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                    } else {
                        // Upload file
                        if (move_uploaded_file($_FILES["image" . $i]["tmp_name"], $target_file)) {
                            $uploaded_files[] = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            } else {
                echo "File is not an image.";
            }
        }
    }

    // Insert product information into database
    if (!empty($uploaded_files)) {
        $product_name_escaped = mysqli_real_escape_string($mysqli, $product_name);
        $category_id_escaped = mysqli_real_escape_string($mysqli, $category_id);
        $description_escaped = mysqli_real_escape_string($mysqli, $description);
        $price_escaped = mysqli_real_escape_string($mysqli, $price);

        // Inserting into database
        $sql = "INSERT INTO product (product_name, category_id, description, price";
        for ($i = 0; $i < count($uploaded_files); $i++) {
            $sql .= ", product_img" . ($i + 1);
        }
        $sql .= ") VALUES ('$product_name_escaped', '$category_id_escaped', '$description_escaped', '$price_escaped'";
        foreach ($uploaded_files as $index => $file) {
            $sql .= ", '$file'";
        }
        $sql .= ")";

        if ($mysqli->query($sql) === TRUE) {
            $success_message = "Product added successfully.";
            header("location: ../products.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $sql = "SELECT description FROM product WHERE product_id = $product_id";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $description = $row['description'];
    } else {
        echo "Error retrieving product description: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Product</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../assets/css/add-product.css">
</head>

<body>
    <div class="container">
        <h3>Add a new product</h3>
        <form method="post" enctype="multipart/form-data" oninput="toggleImageInputs()">
            <div class="img-container">
                <label for="numberImg">Number of images (5 max)</label>
                <select name="numberImg" id="numberImg" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                <input type="file" name="image1" accept=".jpg, .jpeg, .png">
                <label for="image2" style="display: none;">Image 2</label>
                <input type="file" name="image2" accept=".jpg, .jpeg, .png" style="display: none;">
                <label for="image3" style="display: none;">Image 3</label>
                <input type="file" name="image3" accept=".jpg, .jpeg, .png" style="display: none;">
                <label for="image4" style="display: none;">Image 4</label>
                <input type="file" name="image4" accept=".jpg, .jpeg, .png" style="display: none;">
            </div>

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
                    <textarea name="desc" cols="30" rows="10"><?php echo htmlspecialchars($description); ?></textarea>
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
                    <button type="submit" class="btn">Add product</button>
                    <a href="../products.php" class="btn">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleImageInputs() {
            var select = document.getElementById("numberImg");
            var number = select.options[select.selectedIndex].value;
            var imageContainers = document.querySelectorAll(".img-container input[type='file']");

            for (var i = 0; i < imageContainers.length; i++) {
                if (i < number) {
                    imageContainers[i].style.display = "flex";
                } else {
                    imageContainers[i].style.display = "none";
                }
            }
        }
    </script>
</body>

</html>