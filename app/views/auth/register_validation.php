<?php
// class for handling input validation for the registration form

class InputValidation {

    private static function isNotEmpty($input) {
        return !empty(trim($input));
    }

    public static function validateName($name) {
        if (!self::isNotEmpty($name)){
            return 'Required';
        }
        if (strlen($name) > 50) {
            return 'Must be less than 50 Characters';
        } else {
            return '';
        }
    }

    public static function validateAddress($address) {
        if (!self::isNotEmpty($address)){
            return 'Required';
        }
        if (strlen($address) > 100) {
            return 'Must be less than 100 Characters';
        } else {
            return '';
        }
    }

    public static function validateCity($city) {
        if (!self::isNotEmpty($city)) {
            return 'Required';
        }

        if (strlen($city) > 50) {
            return 'Must be less than 50 characters';
        }

        if (!preg_match("/^[a-zA-Z\s\-']+$/", $city)) {
            return 'Contains invalid characters';
        }

        return '';
    }

    public static function validateState($state) {
        if (!self::isNotEmpty($state)) {
            return 'Required';
        }

        if (!preg_match("/^[A-Z]{2}$/", strtoupper($state))) {
            return 'State must be a valid 2-letter code (e.g., TX)';
        }

        return '';
    }

    public static function validateZipCode($zipCode) {
        if (!self::isNotEmpty($zipCode)) {
            return 'Required';
        }

        if (!preg_match("/^\d{5}(-\d{4})?$/", $zipCode)) {
            return 'Invalid Zip Code format';
        }

        return '';
    }

    public static function validateEmail($email) {
        if (!self::isNotEmpty($email)) {
            return 'Email is required';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format';
        }

        return '';
    }

    public static function validatePhoneNumber($phoneNumber) {
        if (!self::isNotEmpty($phoneNumber)) {
            return 'Phone Number is required';
        }

        if (!preg_match("/^\d{10}$/", preg_replace('/\D/', '', $phoneNumber))) {
            return 'Phone Number must contain 10 digits';
        }

        return '';
    }

    public static function validatePassword($password) {
        if (!self::isNotEmpty($password)) {
            return 'Password is required';
        }

        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters';
        }

        if (!preg_match("/[A-Z]/", $password)) {
            return 'Password must contain at least one uppercase letter, one lowercase letter, and one number.';
        }

        if (!preg_match("/[a-z]/", $password)) {
            return 'Password must contain at least one uppercase letter, one lowercase letter, and one number.';
        }

        if (!preg_match("/[0-9]/", $password)) {
            return 'Password must contain at least one uppercase letter, one lowercase letter, and one number.';
        }

        return '';
    }

    public static function validatePasswordConfirmation($password, $passwordConfirmation) {
        if (!self::isNotEmpty($passwordConfirmation)) {
            return 'Password confirmation is required';
        }

        if ($password !== $passwordConfirmation) {
            return 'Passwords do not match';
        }

        return '';
    }
}