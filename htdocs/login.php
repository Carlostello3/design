<html>
    <head>
        <title>CT Designs - Welcome Back</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="login">
        
        
        <form action="checklogin.php" method="POST">
            <div class="imgContainer">
                <a href="index.php"><img src="images/ctLogo.png" width="350px"/></a>
            </div>

            <div class="formContainer">
                <label for="fname">Username:</label>
                <input id="fname" type="text" name="username" required="required" placeholder="your@email.com"/>
                <br/>
                <label for="fpass">Password:</label>
                <input id="fpass" type="password" name="password" required="required" placeholder="**********"/>
                <br/>
            </div> 

            <div class="submitButton">
                <input type="submit" value="Login" />
            </div>
        </form>

        <div class="bottomLinks">
            New User? <a href="register.php">Register Here</a>
        </div>

        <footer>
                CT Designs © - 2020
        </footer>
        
    </body>
</html>