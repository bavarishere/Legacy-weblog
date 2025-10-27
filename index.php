<?php
session_start();
include 'header.php';
include 'db.php';


?>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">categories</a>
                <ul>
                <?php
                    $sql = "SELECT category_id, category_name FROM category";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li><a href="category.php?category_id=' . $row['category_id'] . '">' . htmlspecialchars($row['category_name']) . '</a></li>';
                        }
                    } else {
                        echo '<li>No categories found</li>';
                    }
                ?>
                </ul>
            </li>
                <li><a href="about.php">About</a></li>
            </ul>
            <?php if (isset($_SESSION['is_logged']) === true) {
                $profileImage = !empty($_SESSION['profile_image']) 
                ? $_SESSION['profile_image'] 
                : 'uploads/profile_default.jpg';?>
                <img src="<?php echo $profileImage; ?>" alt="Profile Image" style="width:24px;height:24x;">
                <button><a href="dashboard.php"><?php echo $_SESSION['username']?></a>
                <button><a href="logout.php">Logout</a>
                </button>
                <?php } else { ?>
            <button><a href="login.php">Login</a>
            <button><a href="register.php">Register</a></button>
            <?php } ?>
        </nav>
    </header>
</body>

<?php
include 'footer.php';
?>