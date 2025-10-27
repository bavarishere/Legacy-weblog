<?php
session_start();
include 'header.php';
include 'db.php';
?>
<?php if (isset($_SESSION['is_logged']) === true) { ?><?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $frist_name = $_POST['frist_name'];
        $last_name = $_POST['last_name'];
        $bio = $_POST['bio'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_id = $_SESSION['user_id'];

        // image uploads
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $profile_image_path = '';
        if (isset($_FILES["profile_image"]) && !empty($_FILES["profile_image"]["name"])) {
            $image_name = basename($_FILES["profile_image"]["name"]);
            $target_file = $target_dir . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($imageFileType, $allowed)) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                    $profile_image_path = $target_file;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                }   
            }

        $sql = "UPDATE `users` SET frist_name='$frist_name', last_name='$last_name', bio='$bio', email='$email'" . 
               (!empty($password) ? ", password='$password'" : "") . 
               ($profile_image_path ? ", profile_image='$profile_image_path'" : "") . 
               " WHERE user_id=$user_id";

        $result = mysqli_query($conn, $sql);

        if ($result === true) {
            // Update session variables
            $_SESSION['frist_name'] = $frist_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['bio'] = $bio;
            $_SESSION['email'] = $email;
            if ($profile_image_path) {
                $_SESSION['profile_image'] = $profile_image_path;
            }
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?>
<?php 
$profileImage = !empty($_SESSION['profile_image']) 
    ? $_SESSION['profile_image'] 
    : 'uploads/profile_default.jpg';
?>


<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Back</a></li>
            </ul>
        </nav>
    </header>
    <form action="setting.php" method="POST" enctype="multipart/form-data">
        <h2>Settings</h2>
        <div>
            <label for="profile_image">Profile Image:</label>
            <input type="file" id="profile_image" name="profile_image"><br><br>
            <img src="<?php echo $profileImage; ?>" alt="Profile Image" style="width:100px;height:100px;"><br><br>
        </div>
        <div>
            <label for="frist_name">First Name:</label>
            <input type="text" id="frist_name" name="frist_name" value="<?php echo $_SESSION['frist_name']; ?>" ><br><br>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo isset($_SESSION['last_name']) ? $_SESSION['last_name'] : ''; ?>"><br><br>
        </div>
        <div>
            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" style="width: 500px; height: 50px;" placeholder="about me . . . . "><?php echo isset($_SESSION['bio']) ? $_SESSION['bio'] : ''; ?></textarea><br><br>
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" disabled><br><br>
        </div>
        <div>
            <label for="Email">Email:</label>
            <input type="email" id="Email" name="email" value="<?php echo $_SESSION['email']; ?>"><br><br>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" ><br><br>
        </div>
        <div>
            <button type="submit">Update Settings</button>
        </div>
    </form>
</body>
<?php 
} 
?>
<?php
include 'footer.php';
?>