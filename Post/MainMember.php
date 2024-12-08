<?php 
require_once __DIR__ . '/../API.php';
if(isset($_POST['member_id'])){
  $member_id = $_POST['member_id'];
  $API = new API;
  header('Content-Type: application/json');
  $result = $API->Member($member_id);
  $API = null;
}else{
  $result = 'give me member_id, or head to login page';
}
echo $result;
?>