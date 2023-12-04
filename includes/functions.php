<?php

// validation Name, Role..etc

function isValidName($value, $minLength, $maxLength)
{
    // Check if the field is not empty
    if (empty($value)) {
        return false;
    }

    // Check the length of the field
    $length = strlen($value);
    if ($length < $minLength || $length > $maxLength) {
        return false;
    }

    // Check if the field contains only alphabetic characters and spaces
    if (!preg_match('/^[A-Za-z ]+$/', $value)) {
        return false;
    }

    return true;
}

// validation Email

function isValidEmail($email)
{
    // Check if the field is not empty
    if (empty($email)) {
        return false;
    }

    // Check if the email is valid using FILTER_VALIDATE_EMAIL
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

// validation Password

function isValidPassword($password, $minLength, $maxLength)
{
    // Check if the field is not empty
    if (empty($password)) {
        return false;
    }

    // Check the length of the password
    $length = strlen($password);
    if ($length < $minLength || $length > $maxLength) {
        return false;
    }

    // Add other password complexity criteria here if needed.

    return true;
}

// Check if the admin is connected else Redirect to the login page if he is not 
function checkAdminSession() {
    // Check if the admin is connected
    $isAdminConnected = isset($_SESSION['admin']);

    // Redirect to the login page if the admin is not connected
    if (!$isAdminConnected) {
        header("Location: login.php");
        exit();
    }
}