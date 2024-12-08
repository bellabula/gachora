s<?php
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
    throw new Exception("give me type(all, new, rare, hot) and page");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
