<?php
require_once('query.php');
$query = new Query();

$postData = file_get_contents("php://input");
$request = json_decode($postData);

echo $query->getStoriesByCategory($request->category);

//$catID = $_GET["CatID"];
//$result = mysqli_query($con, "SELECT * FROM user_stories as S LEFT JOIN storypictures P ON S.StoryID = P.PicStoryID WHERE S.CID = " . $request->category);
// header('Content-Type: application/json');
// $rows = array();
// while ($row = mysqli_fetch_assoc($result)) {
// 	$rows[] = $row;
// }
// echo json_encode($rows);
?>
