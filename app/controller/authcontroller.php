<?php
//Simple controller
$username = '';
$password = '';

$errors = [
    'username' => '',
    'password'=> ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username =($_POST['username']);
    $password = $_POST['password'];

    //Basic Validation
    if ($username == ''){
        $errors['username'] = 'Username required';
        $errors['password'] = 'Password required';
    }

    //Later, if no errors, check DB, set session, redirect, etc
}

//After preparing variables show view
require __DIR__ . '/../views/auth/login.php'

?>