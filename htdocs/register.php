<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>CT Designs - Register</title>
    </head>
    <body>
        <form action="register.php" method="POST">
            <div class="imgContainer">
                <a href="index.php"><img src="images/ctLogo.png" width="350px"/></a>
            </div>

            <div class="formContainer">
                <small>All fields are required!</small>
                <br/>
                <label for="fuser">Username</label>
                <input id="fuser" type="text" name="username" required="required" />
                <br/>
                <label for="fpass">Password</label>
                <input id="fpass" type="password" name="password" required="required" />
                <br/>
                <label for="femail">Email Address</label>
                <input id="femail" type="text" name="email_address" required="required" />
                <br/>
            </div>
            
            <div class="submitButton2">
                <input type="submit" value="Register" />
            </div>
        </form>

        <div class="bottomLinks">
            Already a User? <a href="login.php">Log in Here</a>
        </div>

        <footer>
                CT Designs © - 2020
        </footer>
    </body>
</html>

<?php

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "dbPassword";
$dbName = "design_items";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email_address = $_POST["email_address"];
    
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO `users` (`id`, `username`, `password`, `email_address`) VALUES (NULL, '$username', '$password', '$email_address')";

    if($conn -> query($sql) === TRUE){
        echo '<script>alert("User created successfully");</script>'; 
    } else {
        echo '<script>alert("Error creating user");</script>';
    }

    $conn->close();
}
?>