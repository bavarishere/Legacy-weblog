<?php
session_start();
include '../header.php';
include '../db.php';
if (($_SESSION['is_admin']) === true) {

        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            // Prepare and execute the delete query
            $sql = "DELETE FROM users WHERE user_id = $user_id";
            if (mysqli_query($conn, $sql)) {
                header("Location: users.php");
            } else {
                echo "<p>Error deleting user: " . mysqli_error($conn) . "</p>";
            }
        }
    
} else {
    header("Location: 403.php");
    exit;
}
?>