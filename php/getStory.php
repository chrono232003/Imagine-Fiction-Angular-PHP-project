<?php
require_once('query.php');
$query = new Query();

$postData = file_get_contents("php://input");
$request = json_decode($postData);
echo $query->getStory($request->storyID);
?>
