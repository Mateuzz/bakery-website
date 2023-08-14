<?php

require_once 'util.php';
require_once "db.php";

function getUser($email) {
    $email = strtolower($email);
    return selectOneDB('bakery', 'users', 'email', $email);
}

function userLogin($email, $password) {
    $email = strtolower($email);
    $userRow = getUser($email);

    if ($userRow && password_verify($password, $userRow['password']))
        return $userRow;

    return null;
}


// Sign up

const TELEPHONE_REGEX = "/^([0-9]{2}|\([0-9]{2}\))[\s]*([0-9]{4,5})[\s]*-?[\s]*([0-9]{4})$/";

function validateName($name, &$errors) {
    if (!$name)
        $errors[] = "Null user";
    $len = strlen($name);
    if ($len < 3 || $len > 60) {
        $errors[] = "Name must have between 3 and 60 characters";
    }
    if (preg_match("/[^\w\s]/", $name)) {
        $errors[] = "Name can't have special characters";
    }
}

function validateEmail($email, &$errors) {
    if (!$email)
        $errors[] = "Null email";
    if (strlen($email) > 60)
        $errors[] = "Email must have not more than 60 characters";
    if (!preg_match("/^[\w]+@[\w]+\.[\w]+$/", $email))
        $errors[] = "Email must be valid email";
}

function validateBirthDate($date, &$errors) {
    $time = strtotime($date);
    if (!$time)
        $errors[] = "Invalid date format";

    $newDate = date("Y-m-d", $time);
    if (!$date)
        $errors[] = "Null date";

    return $newDate;
}

function validateTelephone($tel, &$errors) {
    if (!$tel)
        $errors[] = "Null tel number";

    if (strlen($tel) > 40)
        $errors[] = "Telephone must have not more than 40 characters";
    if (!preg_match(TELEPHONE_REGEX, $tel, $matches)) 
        $errors[] = "Telephone must be a valid number";

    return [
        'ddd' => trim($matches[1], "()"),
        'n1' => $matches[1],
        'n2' => $matches[2],
    ];
}

function validatePassword($pass, &$errors) {
    if (!$pass)
        $errors[] = "Null password";

    if (strlen($pass) < 8)
        $errors[] = "Password must have at least 8 characters";
    
    if (!preg_match("/[a-z]/", $pass) || !preg_match("/[A-Z]/", $pass) || 
        !preg_match("/[0-9]/", $pass)) {
        $errors[] = "Password must have uppercase, lowercase, and numbers";
    }
}

function formatTelephoneNumber($telephoneFields) {
    $ddd = $telephoneFields['ddd'];
    $n1 = $telephoneFields['n1'];
    $n2 = $telephoneFields['n2'];
    return "($ddd) $n1-$n2";
}

function addUser($name, $email, $tel, $birth, $pass) {
    $email = strtolower($email);
    return insertIgnoreDB('bakery', 'users',
        ['name', 'email', 'telephone', 'birth', 'password'],
        [$name, $email, $tel, $birth, password_hash($pass, PASSWORD_DEFAULT)]
    );
}

function createAdmin($name, $email, $tel, $birth, $pass) {
    $email = strtolower($email);
    return insertIgnoreDB('bakery', 'users',
        ['name', 'email', 'telephone', 'birth', 'password', 'flag'],
        [$name, $email, $tel, $birth, password_hash($pass, PASSWORD_DEFAULT), 'admin']
    );
}

function userSignup($name, $email, $birth, $tel, $password) {
    $email = strtolower($email);
    $errors = [];

    validateName($name, $errors);
    validatePassword($password, $errors);
    $birth = validateBirthDate($birth, $errors);
    $telFields = validateTelephone($tel, $errors);
    validateEmail($email, $errors);

    $tel = formatTelephoneNumber($telFields);

    if (!count($errors)) {
        $result = addUser($name, $email, $tel, $birth, $password);

        if (!$result) {
            $errors[] = 'Email has already been taken';
        }
    }

    return $errors;
}

?>
