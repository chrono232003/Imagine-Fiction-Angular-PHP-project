<?php
include 'connection.php';

$login = $_GET['User'];
$pass = $_GET['Pass'];

$query = "SELECT username FROM siteusers WHERE username = '$login' and password = '$pass'";
$result = mysqli_query($con, $query)
			or die('Could not execute login query');
			
			$num = (mysqli_num_rows($result));
			if ($num > 0){
				while($row = mysqli_fetch_array($result)) {
					$rows[] = $row;
					$user = $row['username'];
				};
				echo json_encode($rows);
			}
?>