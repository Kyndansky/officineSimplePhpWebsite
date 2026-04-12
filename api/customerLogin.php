<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";
if (!isset($_SESSION))
      session_start();
$username = isset($_POST["username"]) ? $_POST["username"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;

if ($username === null || $password === null) {
      echo error("both username and password are required to log in");
      exit;
}

if (AuthManager::loginCustomer($username, $password)) {
      $data = AuthManager::getCustomerData($username);
      $_SESSION["authData"]=$data;
      echo ok("login successful", $data);
      exit;
}
else{
      echo error("Wrong password");
}
