<?php
session_start();
include 'header.php';
include 'db.php';

$post_id = intval($_GET['posts_id']);
$sql = "SELECT * FROM `posts` where posts_id = $post_id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);



?>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
        </nav>
    </header>
    <div>
        <?php if (!empty($row['image'])): ?>
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
        <?php else: ?>
            <img src="uploads/no-image.jpg" alt="Post Image" style="width:100px; height:auto; border-radius:6px;">
        <?php endif; ?>
        <h1><?php echo htmlspecialchars($row['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
        <p><strong>Author ID:</strong> <?php echo htmlspecialchars($row['author_id']); ?></p>
        <p><strong>Publication Date:</strong> <?php echo htmlspecialchars($row['publication_date']); ?></p>
    </div>
</body>
<?php
include 'footer.php';
?>