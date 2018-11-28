<?php
include 'connection.php';

$result = mysqli_query($con, "SELECT * FROM user_stories as S INNER JOIN categories C ON S.CID = C.ID INNER JOIN users as U ON S.UID = U.ID");

header('Content-Type: application/json');
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
	$rows[] = $row;
}
echo json_encode($rows);
?>
