<?php
require_once __DIR__ . '/../API.php';
try {

  if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $API = new API;
    header('Content-Type: application/json');
    $result = $API->Wall($member_id);
    echo $result;
  } else {
    throw new Exception("give me member_id");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
