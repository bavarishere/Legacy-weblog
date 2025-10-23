<?php 
include 'header.php';
?>
<body>
    <header class="header">
        <div class="container is-max-tablet">
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item is-active" href="index.php">Home</a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">Categories</a>
                                <div class="navbar-dropdown">
                                    <a class="navbar-item">XSS</a>
                                    <a class="navbar-item">CSRF</a>
                                    <a class="navbar-item">SQLi</a>
                                </div>
                        </div>
                    <a class="navbar-item" href="about.php">About</a>
                </div>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="register.php">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light" href="login.php">
                                <strong>Log in</strong>
                            </a>
                        </div>
                    </div>
                </div>
        </nav>
        </div>
    </header>
</body>

<?php 
include 'footer.php';
?>