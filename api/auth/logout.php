<?php
require_once __DIR__ . "/../../misc/functions.php";
if (!isset($_SESSION))
    session_start();

session_destroy();

echo ok("logged out successfully");