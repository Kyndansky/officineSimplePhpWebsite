<?php
require_once __DIR__ . "/../misc/functions.php";
require_once __DIR__ . "/../classes/AuthManager.php";

$email = isset($_GET["email"]) ? $_GET["email"] : null;
$uuid = isset($_GET["uuid"]) ? $_GET["uuid"] : null;

if (AuthManager::verifyCustomerEmailAddress($email, $uuid)) {
    echo "Email address verified successfully";
} else {
    echo "error while verifying email";
}