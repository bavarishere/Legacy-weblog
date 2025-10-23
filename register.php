<?php 
include 'header.php';
include 'db.php';
?>

<?php

$name = $_POST['name'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($_POST['submit'])) {
  if(empty($_POST['name'])){
    echo "<div class='notification is-danger'><button class='delete'></button>error: Name is required</div>";
  } elseif (empty($_POST['username'])) {
    echo "<div class='notification is-danger'><button class='delete'></button>error: Username is required</div>";
  } elseif (empty($_POST['email'])) {
    echo "<div class='notification is-danger'><button class='delete'></button>error: Email is required</div>";
  } elseif (empty($_POST['password'])) {
    echo "<div class='notification is-danger'><button class='delete'></button>error: Password is required</div>";
  } else {
    echo "<div class='notification is-success'><button class='delete'></button>Success: User registered successfully!</div>";
  }
}

?>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
      const $notification = $delete.parentNode;

      $delete.addEventListener('click', () => {
        $notification.parentNode.removeChild($notification);
      });
    });
  });
</script>



<body>
  <section class="hero" style="background-color: #303030ff;">
    <div class="hero-body">
      <div class="container is-max-tablet">
        <h1 class="title">Registration Page</h1>
        <h2 class="subtitle">Create your account</h2>
      </div>
    </div>
  </section>
  <div class="container is-max-tablet mt-5">

    <!-- this is form code -->
    <form class="box" action="register.php" method="POST">
      
      <div class="field">
          <label class="label">Name</label>
          <div class="control">
            <input class="input" name="name" type="text" placeholder="Enter your name" value=<?php echo $name; ?>>
          </div>
      </div>

      <div class="field">
        <label class="label">Username</label>
        <div class="control">
          <input class="input" name="username" type="text" placeholder="Choose a username" value=<?php echo $username; ?>>
        </div>
      </div>

      <div class="field">
          <label class="label">Email</label>
          <div class="control">
            <input class="input" name="email" type="email" placeholder="Enter your email" value=<?php echo $email; ?>>
          </div>
      </div>
      
      <div class="field">
        <label class="label">Password</label>
        <div class="control">
          <input class="input" name="password" type="password" placeholder="Create a password">
        </div>
      </div>

      <div class="section">
      </div>

      <div class="field">
        <div class="control">
          <input class="button is-primary navbar-center" name="submit" type="submit" value="Register">
        </div>
      </div>

    </form>
    <div class="section">
    </div>
  </div>
</body>
<?php 
include 'footer.php';
?>