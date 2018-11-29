<?php
include 'connection.php';

$postData = file_get_contents("php://input");
$request = json_decode($postData);

$query = "SELECT Username FROM users WHERE username = '$request->user' and password = '$request->pass'";
$result = mysqli_query($con, $query)
			or die('Could not execute login query');

			$num = (mysqli_num_rows($result));
			if ($num > 0){
				while($row = mysqli_fetch_assoc($result)) {
					echo json_encode($row);
				};
			}
?>
