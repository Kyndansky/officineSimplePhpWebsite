<?php
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";
$username = isset($_GET["username"])?$_GET["username"]:null;
$password = isset($_GET["password"])?$_GET["password"]:null;
$role = isset($_GET["role"])?$_GET["role"]:null;


if ($username == null || $password == null || $role == null) {
    echo error("some fields are missing");
    exit;
}

if (AuthManager::registerDipendente($username, $password, $role) === true) {
    $data = AuthManager::getDipendenteData($username);
    $_SESSION["authData"] = $data;
    echo ok("registration successful", $data);
    exit;
} else {
    echo error("registration not successful, try changing username");
    exit;
}
