<html>
    <head>
    <title>CT Designs - Register</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go home</a>
        <form action="register.php" method="POST">
            Enter Username: <input type="text" name="username" required="required" />
            <br/>
            Enter Password: <input type="password" name="password" required="required" />
            <br/>
            Enter Email Address: <input type="text" name="email_address" required="required" />
            <br/>
            <input type="submit" value="Register" />
        </form>
    </body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
    $email_address = mysql_real_escape_string($_POST['email_address']);
    $bool = true;

    mysql_connect("localhost", "root" , "") or die(mysql_error());
    mysql_select_db("design_items") or die("Cannot connect to database");
    $query = mysql_query("Select * from users");
    while($row =  mysql_fetch_array($query)) {
        $table_users = $row['username'];
        if($username == $table_users){
            $bool = false;
            Print '<script>alert("Username unavailable");</script>';
            Print '<script>window.location.assign("register.php");</script>';
        }
    }

    if($bool){
        mysql_query("INSERT INTO users (username, password, email_address) VALUES ('$username', '$password', '$email_address')");
        Print '<script>alert("Account successfully created");</script>';
        Print '<script>window.location.assign("register.php");</script>';
    }
}
?>