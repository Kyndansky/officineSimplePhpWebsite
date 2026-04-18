<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../misc/functions.php";
require_once __DIR__ . "/../../classes/AuthManager.php";
if (!isset($_SESSION))
      session_start();
$email = isset($_POST["email"]) ? $_POST["email"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;

if ($email === null || $password === null) {
      echo error("both email and password are required to log in");
      exit;
}

if (!AuthManager::isCustomerEmailVerified($email)) {
      echo error("verify your email address first to be able to use your account");
}

if (AuthManager::loginCustomer($email, $password)) {
      $data = AuthManager::getCustomerData($email);
      $_SESSION["authData"] = $data;
      echo ok("login successful", $data);
      exit;
} else {
      echo error("Wrong password");
}
