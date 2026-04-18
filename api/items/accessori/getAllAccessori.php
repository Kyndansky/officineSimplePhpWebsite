<?php
Header("Content-Type: application/json");
require_once __DIR__ . "/../../../misc/functions.php";
require_once __DIR__ . "/../../../classes/OfficineManager.php";

$manager = new OfficineManager();
echo ok("successfully retrieved all accessori", $manager->getAll("accessori"));