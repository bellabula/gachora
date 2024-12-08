<?php 
require_once __DIR__ . '/../API.php';
$API = new API;
header('Content-Type: application/json');
$result = $API->IchibanBling();
$API = null;
echo $result;
?>