<?php
session_start();
include '../header.php';
include '../db.php';
if (($_SESSION['is_admin']) === true) {?>
<?php

$sql= "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Back</a></li>
                <li><a href="new_user.php">ADD New User</a></li>
            </ul>
        </nav>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Bio</th>
                <th>Profile Image</th>
                <th>Manage</th>
            </tr>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['frist_name']); ?></td>
                <td><?php if (!empty($user['last_name'])){
                    echo htmlspecialchars($user['last_name']);
                } ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php if (!empty($user['bio'])){
                    echo htmlspecialchars($user['bio']);
                } ?></td>
                <td>
                    <?php if (!empty($user['profile_image'])): ?>
                        <img src="<?php echo "../". htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" style="width:100px; height:auto; border-radius:6px;">
                    <?php else: ?>
                        <img src="../uploads/profile_default.jpg" alt="Profile Image" style="width:100px; height:auto; border-radius:6px;">
                    <?php endif; ?>
                </td>
                <td><button><a href="edit_user.php?user_id=<?php echo $user['user_id']; ?>">Edit</a></button><button><a href="delete_user.php?user_id=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a></button></td>
            </tr>
            <?php } ?>
        </table>
    </header>
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