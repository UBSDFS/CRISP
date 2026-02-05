<?php
//Simple controller
class AuthController
{
    private $userModel; // User model instance

    public function __construct($db)
    {
        require_once __DIR__ . '/../model/userModel.php';
        $this->userModel = new UserModel($db);
    }

    public function showLogin()
    {
        //Initialize variables
        $email = '';
        $password = '';


        $errors = [
            'email_error' => '',
            'password_error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = (string)$_POST['email'];
            $password = (string)$_POST['password'];

            //Validation
            $emailError = $this->emailValidation($email);
            if ($emailError != '') {
                $errors['email_error'] = $emailError;
            }
            $passwordError = $this->passwordValidation($password);
            if ($passwordError != '') {
                $errors['password_error'] = $passwordError;
            }

            if ($errors['email_error'] === '' && $errors['password_error'] === '') {
                // Check database for user
                $user = $this->getUserByEmail((string)$email);
                if (!$user) {
                    $errors['email_error'] = 'Invalid email.';
                } elseif (!password_verify($password, $user['password_hash'])) {
                    $errors['password_error'] = 'Invalid password.';
                } else {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                    // Redirect to dashboard
                    header('Location: index.php?action=dashboard');
                    exit;
                }
            }
        }



        //After preparing variables show view
        require __DIR__ . '/../views/auth/login.php';
    }

    public function emailValidation($email)
    {
        if (empty($email)) {
            return 'E-Mail is required.';
        }
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? '' : 'Invalid email format.';
    }
    public function passwordValidation($password)
    {
        if (empty($password)) {
            return 'Password is required.';
        }
        // Regex pattern: at least 6 characters, at least one uppercase letter, at least one special character
        $pattern = '/^(?=.{6,})(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]).*$/';
        if (!preg_match($pattern, $password)) {
            return 'Password must be at least 6 characters long, contain at least one uppercase letter, and at least one special character.';
        }
        return '';
    }

    public function getUserByEmail(string $email)
    {
        return $this->userModel->getUserByEmail($email);
    }
}
