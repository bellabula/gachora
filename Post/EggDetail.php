<?php
require_once __DIR__ . '/../API.php';
try {

  if (isset($_POST['series_id'])) {
    $series_id = $_POST['series_id'];
    $API = new API;
    header('Content-Type: application/json');
    $result = $API->EggDetail($series_id);
    echo $result;
  } else {
    throw new Exception("give me series_id");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
