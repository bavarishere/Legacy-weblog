<?php
session_start();
include 'header.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['is_logged'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['frist_name'] = $row['frist_name'];
        if (!empty($row['last_name'])) {
            $_SESSION['last_name'] = $row['last_name'];
        }
        if (!empty($row['bio'])) {
        $_SESSION['bio'] = $row['bio'];
        }
        if (!empty($row['profile_image'])) {
        $_SESSION['profile_image'] = $row['profile_image'];
        }
        if ($row['username'] === 'bavar') {
            $_SESSION['is_admin'] = true;
        } else {
            $_SESSION['is_admin'] = false;
        }
        header("Location: index.php"); // Redirect to a welcome page or dashboard
    } else {
        // Authentication failed
        echo "Username or Password is incorecct";
        $username = $_POST["username"];
    }
}
?>

<body>
    <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <input type="submit" value="Login"><br>
    <button><a href="google_login.php">Sign in with Google</a></button><br>
    <a href='register.php'>Need a registration?</a><br>
</form>
</body>


<?php
include 'footer.php';
?>
