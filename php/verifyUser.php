<?php
  require_once('queryClasses/query.php');
  $query = new Query();

  $postData = file_get_contents("php://input");
  $request = json_decode($postData);

  echo $query->queryUserKeyVerify($request->key);
?>
