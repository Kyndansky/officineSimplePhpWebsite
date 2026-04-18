<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../../misc/functions.php";
require_once __DIR__ . "/../../../classes/OfficineManager.php";

$officinaId = isset($_POST["officinaId"]) ? $_POST["officinaId"] : null;

if ($officinaId === null) {
    echo error("an officinaId must be given!");
}

$manager = new OfficineManager();

$servizi = $manager->getAllServiziOfOfficina($officinaId);
if ($servizi) {
    echo ok("successfully retrieved all servizi di ricambio from officina with id: " . $officinaId, $servizi);
} else {
    echo error("error while retrieving servizi for the given officina");
}