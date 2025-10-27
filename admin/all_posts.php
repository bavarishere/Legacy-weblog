<?php
session_start();
include '../header.php';
include '../db.php';
if (($_SESSION['is_admin']) === true) {?>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Back</a></li>
            </ul>
        </nav>
    </header>
    <h1>All Posts</h1>
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
                <a href="read_post.php?posts_id=<?php echo $row[0]; ?>">Read</a> |
                <a href="edit.php?posts_id=<?php echo $row[0];; ?>">Edit</a> |
                <a href="delete_post.php?posts_id=<?php echo $row[0];; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
<?php
} else {
    header("Location: ../403.php");
    exit;
}
?>

<?php
include '../footer.php';
?>