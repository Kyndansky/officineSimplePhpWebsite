<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../../misc/functions.php";
require_once __DIR__ . "/../../../classes/OfficineManager.php";

$officinaId = isset($_POST["officinaId"]) ? $_POST["officinaId"] : null;

if ($officinaId === null) {
    echo error("an officinaId must be given!");
}

$manager = new OfficineManager();

$accesori = $manager->getAllAccessoriOfOfficina($officinaId);
if ($accesori) {
    echo ok("successfully retrieved all accesori di ricambio from officina with id: " . $officinaId, $accesori);
} else {
    echo error("error while retrieving accesori for the given officina");
}