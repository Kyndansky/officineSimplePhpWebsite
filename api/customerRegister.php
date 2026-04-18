<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";
if (!isset($_SESSION))
    session_start();
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;
$name = isset($_POST["name"]) ? $_POST["name"] : null;
$surname = isset($_POST["surname"]) ? $_POST["surname"] : null;
$phone = isset($_POST["phone"]) ? $_POST["phone"] : null;


if ($email == null || $password == null || $name == null || $surname == null || $phone == null) {
    echo error("some fields are missing");
    exit;
}

if (AuthManager::customersEmailRegistered($email)) {
    echo error("email already registered");
    exit;
}

if (AuthManager::registerCustomer($password, $email, $name, $surname, $phone) === true) {
    echo ok("registration successful: verify your email before unlocking all features");
    exit;
} else {
    echo error("registration not successful, try again");
    exit;
}
