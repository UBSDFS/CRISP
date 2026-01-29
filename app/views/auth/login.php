<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/customer-complaint-tracking-system/public/assets/css/login.css"> <!--updated path to css-->
    <title>SDC342L Project Login Page</title>
</head>

<body>
    <main class="login-page">
        <section class="login-card">
            <header class="login-header">
                <h1>Login</h1>
                <p>Sign in to continue.</p>
            </header>
            <form method='POST'>
                <div class="field">
                    <label for="email">E-Mail:</label>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>"><br>
                    <?= htmlspecialchars($errors["email"]) ?>
                    <br>
                </div>
                <div class="field">
                    <label for="password">Password:</label>
                    <div class="password-view">
                        <input type="password" name="password" id="password" required>
                        <button type="button" class="pw-toggle" data-toggle="password" aria-label="Show password">Show</button>
                        <?= htmlspecialchars($errors["password"]) ?><br>
                        <br>
                    </div>
                    <button type="submit" class="btn-primary">Login</button>

                    <p class="login-footer">
                        Don’t have an account?
                        <a href="/customer-complaint-tracking-system/public/index.php?action=register">Register</a> <!-- updated Link to registration page -->
                    </p>
            </form>
        </section>
    </main>
    <script src="/customer-complaint-tracking-system/public/assets/js/showpassword.js"></script> <!--link to js file to access show password functionality-->

</body>

</html>

<!--TODO:
- Add client-side validation for email format and password requirements
- Add error message displays for each field based on validation in controller
- Connect to backend to verify user credentials against database
-->