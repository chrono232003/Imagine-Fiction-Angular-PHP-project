<?php
include 'connection.php';


$result = mysqli_query($con, "SELECT * FROM user_stories as S INNER JOIN category C ON S.CID = C.ID LEFT JOIN storypictures P ON S.StoryID = P.PicStoryID");

header('Content-Type: application/json');
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
	$rows[] = $row;
}
echo json_encode($rows);
?>
