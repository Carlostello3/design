<html>
    <head>
        <title>CT Designs - Home</title>
    </head>
    <?php
        session_start();
        if($_SESSION['user']){

        } else {
            header("location:index.php");
        }

        $user = $_SESSION['user'];
    ?>

    <body>
        <h2>Home Page</h2>
        <p>Welcome <?php Print "$user"?>!</p>
        <a href="logout.php">Log Out</a>
    </body>
</html>