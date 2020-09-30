<?php
session_start();
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "dbPassword";
$dbName = "design_items";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if($conn -> connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `users` WHERE username = '$username'";

    $result = $conn -> query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $table_users = $row["username"];
            $table_password = $row["password"];
        }

        if(($username ==  $table_users) && ($password == $table_password)){
            if($password == $table_password){
                $_SESSION['username'] = $username;
                header("location: home.php");
            }
        } 
        else {
            Print '<script>alert("Incorrect Password!");</script>';
			Print '<script>window.location.assign("login.php");</script>';
        }
    }else {
            Print '<script>alert("Incorrect Username!");</script>';
            Print '<script>window.location.assign("login.php");</script>';
    }
    $conn->close();
}
?>