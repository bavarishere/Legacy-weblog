<?php
session_start();
include '../header.php';
include '../db.php';
if (($_SESSION['is_admin']) === true) {

        if (isset($_GET['posts_id'])) {
            $posts_id = $_GET['posts_id'];

            // Prepare and execute the delete query
            $sql = "DELETE FROM posts WHERE posts_id = $posts_id";
            if (mysqli_query($conn, $sql)) {
                header("Location: all_posts.php");
            } else {
                echo "<p>Error deleting post: " . mysqli_error($conn) . "</p>";
            }
        }
    
} else {
    header("Location: 403.php");
    exit;
}
?>