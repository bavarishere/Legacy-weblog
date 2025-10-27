<?php
ob_start();
session_start();
include 'header.php';
include 'db.php';


// var_dump($_SESSION);
// die();

if (isset($_SESSION['is_logged']) === true) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['user_id'];
        $category_id = $_POST['category'];

        // image uploads
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = '';
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($imageFileType, $allowed)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = $target_file;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
                } else {
                    echo "Sorry, only JPG, JPEG, PNG files are allowed.";
                }   
            }
            $sql = "INSERT INTO `posts` (title, content, author_id, category_id, image) VALUES ('$title', '$content', '$author_id', '$category_id', " . ($image_path ? "'$image_path'" : "NULL") . ")";
            
            $result = mysqli_query($conn, $sql);
            if ($result === true) {
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    } else {
        header("Location: login.php");
        exit;
}

$sql = "SELECT * FROM category";    
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result);
ob_end_flush();
?>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="dashboard.php">back</a>
                </li>
                <li>
                    <?php echo $_SESSION['username']?>
                </li>
            </ul>
        </nav>
    </header>
        <section>
            <h1>Write a blog post</h1>
        </section>

        <form action="" method="POST" enctype="multipart/form-data">

        <!-- Username -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="" placeholder="title" required><br>

        <!-- Bio -->
        <label for="content">Content:</label><br>
        <textarea style="width: 500px; height: 200px;" id="content" name="content" placeholder="Hi, in this post I want to talk about..." required></textarea><br>
    
        <select id="category" name="category">
            <?php foreach($rows as $row){
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
            ?>
        </select><br><br>
        <label for="file">Post image :</label>
        <input type="file" name="image" accept="image/*"><br><br>
        <input type="submit" value="Post">
    </form>
</body>