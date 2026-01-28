<?php
//Declare and clear variables
$username = '';
$password = '';

//Declare and  clear variables for error messages
$username_error = '';
$password_error = '';

//Retrieve values from query string and store in local variable after page load
if (isset($_POST['username']) && isset($_POST['password'])){
$username = $_POST['username'];
$password = $_POST['password'];
}


?>










<html>
    <head>
        <title>SDC342L Project Login Page</title>
    </head>

    <body>
        <form method='POST'>
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username)?>"><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password"><br><br>

            <input type="submit" value="Login"><br><br>
            <a href="register.php">Register</a>
        </form>
    </body>
</html>