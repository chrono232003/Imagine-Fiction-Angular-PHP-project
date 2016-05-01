<?php
include 'connection.php';

$catID = $_GET["CatID"];
$result = mysqli_query($con, "SELECT * FROM user_stories as S LEFT JOIN storypictures P ON S.StoryID = P.PicStoryID WHERE S.CID = " . $catID);

header('Content-Type: application/json');
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
	$rows[] = $row;
}
echo json_encode($rows);
?>