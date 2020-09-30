<html>
    <head>
        <title>CT Designs - Home</title>
    </head>
    <?php
        session_start();
        
        if($_SESSION['username']){
        } else {
            header("location:index.php");
        }
        

        $username = $_SESSION['username'];
    ?>

    <body>
        <h2>Home Page</h2>
        <p>Welcome <?php Print "$username"?>!</p>
        <a href="logout.php">Log Out</a>
    </body>
</html>