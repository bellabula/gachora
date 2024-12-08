<?php
require_once __DIR__ . '/../API.php';
try {

  if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    $page = isset($_POST['page']) && !empty($_POST['page']) ? $_POST['page'] : 1;

    $API = new API;
    header('Content-Type: application/json');
    $result = $API->ThemeSort($theme, $page);
    echo $result;
  } else {
    throw new Exception("1. One parameter required: 'theme', please post one of the strings value generate by /Fetch/EggTheme.php). 2. One optional parameter: 'page', it returns page 1 by default if posting null)");
  }
} catch (Exception $e) {
  echo json_encode(["error" => "Connection_fail: " . $e->getMessage()]);
}
