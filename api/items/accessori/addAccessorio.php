<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../../misc/functions.php";
require_once __DIR__ . "/../../../classes/AuthManager.php";
require_once __DIR__ . "/../../../classes/OfficineManager.php";

$name = isset($_POST["name"]) ? $_POST["name"] : null;
$price = isset($_POST["price"]) ? $_POST["price"] : null;
$description = isset($_POST["description"]) ? $_POST["description"] : null;

if ($name === null || $price === null || $description === null) {
      echo error("you probably forgot to send either the name, price or description of the accessorio");
      exit;
}

if (!isset($_SESSION))
      session_start();

$authData = isset($_SESSION["authData"]) ? $_SESSION["authData"] : null;
if ($authData === null) {
      echo error("You must be authenticated to do add a accessorio!");
      exit;
}

if ($authData["ruolo"] === "magazziniere" || $authData["ruolo"] === "admin") {
      $manager = new OfficineManager();
      $manager->addAccessorio($name, $price, $description);
      echo ok("accessorio with name" . $name . " successfully added to all accessori");
} else {
      echo error("You must be an admin or a magazziniere to be able to do this");
}