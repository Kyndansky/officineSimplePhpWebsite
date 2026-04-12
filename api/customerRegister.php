<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";
if (!isset($_SESSION))
    session_start();
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$username = isset($_POST["username"]) ? $_POST["username"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;
$name = isset($_POST["name"]) ? $_POST["name"] : null;
$surname = isset($_POST["surname"]) ? $_POST["surname"] : null;
$phone = isset($_POST["phone"]) ? $_POST["phone"] : null;


if ($email == null || $password == null || $name == null || $surname == null || $phone == null || $username == null) {
    echo error("some fields are missing");
    exit;
}

if (AuthManager::registerCustomer($username, $password, $email, $name, $surname, $phone) === true) {
    $data = AuthManager::getCustomerData($username);
    $_SESSION["authData"] = $data;
    echo ok("registration successful", $data);
    exit;
} else {
    echo error("registration not successful, try changing username");
    exit;
}
