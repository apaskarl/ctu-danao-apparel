<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL error : " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
    $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    $update_sql = "UPDATE user SET firstname = ?, lastname = ?, email = ?, phone = ? WHERE user_id = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    if (!$update_stmt) {
        die("SQL error : " . $mysqli->error);
    }
    $update_stmt->bind_param("ssssi", $firstname, $lastname, $email, $phone, $user_id);
    if ($update_stmt->execute()) {
        $_SESSION["firstname"] = $firstname;
        $_SESSION["lastname"] = $lastname;
        $_SESSION["email"] = $email;
        $_SESSION["phone"] = $phone;

        header("Location: user.php");
        exit();
    } else {
        die($update_stmt->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - CTU-Danao Apparel</title>
    <link rel="stylesheet" href="assets/profile.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/mediaqueries.css">
    <script src="https://kit.fontawesome.com/583fcf263c.js" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <div class="edit-profile-header">
            <div>
                <a href="user.php"><ion-icon name="arrow-back-outline"></ion-icon></a>
                <h3>Edit profile</h3>
            </div>
            <input type="submit" value="Save">
        </div>

        <div class="user-container-mobile">
            <div class="profile-nav edit">
                <div class="profile-nav-user">
                    <div class="img-container">
                        <img src="<?php echo isset($_SESSION["profile_pic"]) ? $_SESSION["profile_pic"] : 'default_profile_pic.jpg'; ?>"
                            class="user-pic edit">
                        <input type="file" id="profilePicInputMobile" name="profilePic" accept="image/*"
                            style="display: none;">
                        <button id="editImageButtonMobile"><ion-icon name="camera-outline"></ion-icon></button>
                    </div>
                </div>
            </div>

            <div class="profile-edit-container">
                <div class="edit-name">
                    <div class="edit-input-box">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname"
                            value="<?php echo htmlspecialchars($user['firstname']); ?>">
                    </div>
                    <div class="edit-input-box">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname"
                            value="<?php echo htmlspecialchars($user['lastname']); ?>">
                    </div>
                </div>
                <div class="edit-input-box">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="edit-input-box">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
            </div>
        </div>
    </form>

    <script>
        // Function to handle the edit image button click
        function handleEditImageButtonClick(event) {
            event.preventDefault();
            document.getElementById('profilePicInputMobile').click();
        }

        // Add event listener for the edit image button
        document.getElementById('editImageButtonMobile').addEventListener('click', handleEditImageButtonClick);

        // Handle file input change event
        document.getElementById('profilePicInputMobile').addEventListener('change', function (event) {
            const form = new FormData();
            form.append('profilePic', event.target.files[0]);

            fetch('update-profile-pic.php', {
                method: 'POST',
                body: form
            })
                .then(response => {
                    if (response.ok) {
                        // Profile picture updated successfully
                        location.reload(); // Reload the page to display the new profile picture
                    } else {
                        // Handle error
                        console.error('Failed to update profile picture');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <script src="script.js"></script>
    <script src="sideMenu.js"></script>
</body>

</html>