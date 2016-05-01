<?php
include 'connection.php';


$result = mysqli_query($con, "SELECT * FROM Category");

header('Content-Type: application/json');
$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
	$rows[] = $row;;
}
echo json_encode($rows);
?>