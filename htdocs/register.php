<html>
    <head>
    <title>CT Designs - Register</title>
    </head>
    <body>
        <h2>CT Designs - Registration Page</h2>
        <a href="index.php">Click here to go home</a>
        <form action="register.php" method="POST">
        <p>All fields are required!</p>
            Username: <input type="text" name="username" required="required" />
            <br/>
            Password: <input type="password" name="password" required="required" />
            <br/>
            Email Address: <input type="text" name="email_address" required="required" />
            <br/>
            <input type="submit" value="Register" />
        </form>
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