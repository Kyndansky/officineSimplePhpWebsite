<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../../misc/functions.php";
require_once __DIR__ . "/../../../classes/OfficineManager.php";

$officinaId = isset($_POST["officinaId"]) ? $_POST["officinaId"] : null;

if ($officinaId === null) {
    echo error("an officinaId must be given!");
}

$manager = new OfficineManager();

$pezzi = $manager->getAllPezziOfOfficina($officinaId);
if ($pezzi) {
    echo ok("successfully retrieved all pezzi di ricambio from officina with id: " . $officinaId, $pezzi);
} else {
    echo error("error while retrieving pezzi for the given officina");
}