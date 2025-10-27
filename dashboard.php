<?php
session_start();
include 'header.php';
include 'db.php';
// echo $_SESSION['is_admin'];

if (isset($_SESSION['is_logged']) === true) {
    
    $sql = "SELECT * FROM posts where author_id = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_all($result);
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
                <li><a href="index.php">Home</a></li>
                <li><a href="setting.php">Settings</a></li>
                <li><a href="new_post.php">New Post</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) { ?>
                <li><a href="admin/dashboard.php">Admin Dashboard</a></li>
                <?php } ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <img src="<?php echo $profileImage; ?>" alt="Profile Image" style="width:24px;height:24x;">
        </nav>
    </header>
    <div>
        <h1>Welcome to your dashboard, <?php echo $_SESSION['username']; ?>!</h1>
    </div>
        <section>
            <h1>My blog posts</h1>
        </section>
        <table border="1">
            <tr>
                <th>Post image</th>
                <th>Post ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Author ID</th>
                <th>Publication Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
            <tr>
                <td>
                    <?php if (!empty($row[6])): ?>
                        <img src="<?php echo htmlspecialchars($row[6]); ?>" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
                    <?php else: ?>
                        <img src="uploads/no-image.jpg" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
                    <?php endif; ?>
                </td>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php echo $row[2]; ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[5]; ?></td>
                <td>
                    <a href="read_post.php?posts_id=<?php echo $row[0]; ?>">Read</a> |
                    <a href="edit_post.php?posts_id=<?php echo $row[0]; ?>">Edit</a> |
                    <a href="delete_post.php?posts_id=<?php echo $row[0]; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table> 

</body>
<?php
} else {
    header("Location: login.php");
    exit;
}
?>
<?php
include 'footer.php'; 
?>