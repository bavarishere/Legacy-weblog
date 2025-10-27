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
        <table border="1">
        <tr>
            <th>Post Image</th>
            <th>Post ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Author ID</th>
            <th>Category ID</th>
            <th>Publication Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM posts";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_all($result);
        foreach ($rows as $row) { ?>
        <tr>
            <td>
                <?php if (!empty($row[6])): ?>
                    <img src="<?php echo "../". htmlspecialchars($row[6]); ?>" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
                <?php else: ?>
                    <img src="../uploads/no-image.jpg" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
                <?php endif; ?>
            </td>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
            <td><?php echo $row[3]; ?></td>
            <td><?php echo $row[4]; ?></td>
            <td><?php echo $row[5]; ?></td>
            <td>
                <a href="read_post.php?posts_id=<?php echo $row[0]; ?>">Read</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</body>

<?php
include 'footer.php';
?>