<?php
require_once __DIR__ . '/../API.php';
try {

  if (isset($_POST['type'])) {
    $type = $_POST['type'];
    $page = isset($_POST['page']) && !empty($_POST['page']) ? $_POST['page'] : 1;
    $API = new API;
    header('Content-Type: application/json');
    $result = $API->EggType($type, $page);
    echo $result;
  } else {
    throw new Exception("1. One parameter required: 'type' (post one of the following strings: 'all', 'new', 'rare', 'hot'), 2. One optional parameter: 'page' (it returns page 1 by default if posting null)");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
