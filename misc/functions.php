<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function error($msg)
{
    return json_encode([
        "successful" => false,
        "message" => $msg,
    ]);
}

function ok($msg, $data=null)
{
    return json_encode([
        "successful" => true,
        "message" => $msg,
        "data"=> $data
    ]);
}