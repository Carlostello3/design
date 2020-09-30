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
        <div class="main_grid">
        <?php
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "dbPassword";
        $dbName = "design_items";

        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

        if($conn -> connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM products";
        $result = $conn -> query($sql);

        if($result->num_rows > 0){
            echo "some results";
        } else {
            echo "0 results";
        }

        ?>
        </div>
    </body>
</html>