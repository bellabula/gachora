<?php
require_once __DIR__ . '/../API.php';
try {

  if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    $page = isset($_POST['page']) && !empty($_POST['page']) ? $_POST['page'] : 1;

    $API = new API;
    header('Content-Type: application/json');
    $result = $API->IchibanThemeSort($theme, $page);
    echo $result;
  } else {
    throw new Exception("give me theme");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
