<?php
session_start();
include 'header.php';
include 'db.php';

$category_id = intval($_GET['category_id']);
$sql2 = "SELECT category_name FROM `category` where category_id = $category_id";
$result2 = mysqli_query($conn, $sql2);
$cat_row = mysqli_fetch_assoc($result2);
$category_name = $cat_row['category_name'] ?? '';


$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.author_id = users.user_id WHERE posts.category_id = $category_id";
$result = mysqli_query($conn, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// echo $category_id;

?>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">back</a>
                </li>
            </ul>
        </nav>
    </header>
        <section>
            <h1><?php echo "Search result for: " . htmlspecialchars($category_name); ?></h1>
        </section>
        <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Author ID</th>
                        <th>Category Name</th>
                        <th>Publication Date</th>
                    </tr>
                </thead>
                <tbody>
                     <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php if (!empty($post['image'])): ?>
                                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="Post Image" width="100">
                                    <?php else: ?>
                                        <img src="uploads/no-image.jpg" alt="Post Image" width="100">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($post['title']) ?></td>
                                <td><?= htmlspecialchars($post['content']) ?></td>
                                <td><?= htmlspecialchars($post['username']) ?></td>
                                <td><?= htmlspecialchars($category_name) ?></td>
                                <td><?= htmlspecialchars($post['publication_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No posts found in this category.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

        </table>
</body>
<?php
include 'footer.php';
?>