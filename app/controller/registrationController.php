<?php
//Simple controller
class RegistrationController
{
    public function registration()
    {
        //Initialize variables

        $email = '';
        $firstName = '';
        $lastName = '';
        $streetAddress = '';
        $city = '';
        $state = '';
        $zipCode = '';
        $phoneNumber = '';
        $password = '';

        $errors = [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'streetAddress' => '',
            'city' => '',
            'state' => '',
            'zipCode' => '',
            'phoneNumber' => '',
            'password' => ''
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstName = ($_POST['firstName']);
            $lastName = ($_POST['lastName']);
            $email = ($_POST['email']);
            $streetAddress = ($_POST['streetAddress']);
            $city = ($_POST['city']);
            $state = ($_POST['state']);
            $zipCode = ($_POST['zipCode']);
            $phoneNumber = ($_POST['phoneNumber']);
            $password = $_POST['password'];

            //Basic Validation
            if ($firstName == '') {
                $errors['firstName'] = 'First Name required';
            }
            if ($lastName == '') {
                $errors['lastName'] = 'Last Name required';
            }
            if ($email == '') {
                $errors['email'] = 'Email required';
            }
            if ($streetAddress == '') {
                $errors['streetAddress'] = 'Street Address required';
            }
            if ($city == '') {
                $errors['city'] = 'City required';
            }
            if ($state == '') {
                $errors['state'] = 'State required';
            }
            if ($zipCode == '') {
                $errors['zipCode'] = 'Zip Code required';
            }
            if ($phoneNumber == '') {
                $errors['phoneNumber'] = 'Phone Number required';
            }
            if ($password == '') {
                $errors['password'] = 'Password required';
            }

            //Later, if no errors, check DB, set session, redirect, etc
        }


        //After preparing variables show view
        require __DIR__ . '/../views/auth/register.php';
    }
}
