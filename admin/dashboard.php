<?php
session_start();
include '../header.php';
include '../db.php';
// echo $_SESSION['is_admin'];
?>
<?php 
if (($_SESSION['is_admin']) === true) {
    $profileImage = "../" . !empty($_SESSION['profile_image']) 
    ? "../".$_SESSION['profile_image'] 
    : '../uploads/profile_default.jpg';
?>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="all_posts.php">All Posts</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="../dashboard.php">Dashboard</a></li>
                </ul>
                <img src="<?php echo $profileImage; ?>" alt="Profile Image" style="width:24px;height:24x;">
            </nav>
        </header>
        <h1>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
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