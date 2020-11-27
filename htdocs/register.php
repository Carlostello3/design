<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>CT Designs - Register</title>
    </head>
    <body>
        <form action="register.php" method="POST">
            <div class="imgContainer">
                <a href="index.html"><img src="images/ctLogo.png" width="350px"/></a>
            </div>

            <div class="formContainer">
                <small>All fields are required!</small>
                <br/>
                <label for="fFirst">First</label>
                <input id="fFirst" type="text" name="first_name" required="required" />
                <br/>
                <label for="fLast">Last</label>
                <input id="fLast" type="text" name="last_name" required="required" />
                <br/>
                <label for="fUser">Username</label>
                <input id="fUser" type="text" name="username" required="required" />
                <br/>
                <label for="fPass">Password</label>
                <input id="fPass" type="password" name="password" required="required" />
                <br/>
                <label for="fEmail">Email Address</label>
                <input id="fEmail" type="email" name="email_address" required="required" 
                pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"/>
                <br/>
            </div>
            
            <div class="submitButton2">
                <input type="reset" value="Clear" />
                <input type="submit" value="Register" />
            </div>
        </form>

        <div class="bottomLinks">
            Already a User? <a href="login.html">Log in Here</a>
        </div>

        <footer>
                CT Designs &#169 - 2020
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
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `users` WHERE `email_address` LIKE '$email_address'";

    if ($result->num_rows < 0){
        echo '<script>alert("Email address already in use");</script>';
    } else {
        $sql = "INSERT INTO `users` (`id`, `username`, `password`, `email_address`, `first_name`, `last_name`) VALUES (NULL, '$username', '$password', '$email_address', '$first_name', '$last_name')";
        if($conn -> query($sql) === TRUE){
            echo '<script>alert("User created successfully");
            window.location.href="login.html";</script>'; 
            
        } else {
            echo '<script>alert("Error creating user");</script>';
        }
    }
    $conn->close();
}
?>