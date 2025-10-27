<?php
session_start();
include 'header.php';
include 'db.php';
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $frist_name = $_POST['frist_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "INSERT INTO `users` (frist_name, username, email, password) VALUES ('$frist_name', '$username', '$email', '$password')";
    $result = mysqli_query($conn, $sql);

        if ($result === true){
            $user_id = mysqli_insert_id($conn);

            $_SESSION['is_logged'] = true;
            $_SESSION['username']  = $username;
            $_SESSION['user_id']   = $user_id;
            $_SESSION['frist_name'] = $frist_name;
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

}

?>

<body>
    <form action="register.php" method="POST">
        <h2>Register</h2>
        <div>
            <label for="frist_name">Name:</label>
            <input type="text" id="frist_name" name="frist_name" required><br><br>
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
        </div>
        <div>
            <label for="Email">Email:</label>
            <input type="email" id="Email" name="email" required><br><br>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    <button><a href="google_login.php">Sign in with Google</a></button><br>
</body>


<?php
include 'footer.php';
?>