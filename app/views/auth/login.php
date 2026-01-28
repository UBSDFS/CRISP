<!DOCTYPE html>
<html>
    <head>
        <title>SDC342L Project Login Page</title>
    </head>

    <body>
        <form method='POST'>
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username)?>"><br>
            <?= htmlspecialchars($errors["username"])?><br>
            <br>

            <label for="password">Password:</label>
            <input type="password" name="password"><br>
            <?= htmlspecialchars($errors["password"])?><br>
            <br>

            <input type="submit" value="Login"><br><br>
            <a href="../app/views/auth/register.php">Register</a>
        </form>
    </body>
</html>