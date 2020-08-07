<?php
header('Content-Type: application/json');

$conn = mysqli_connect("localhost","id14314173_fypsayed","#AbuSayed59395","id14314173_sayedfyp");

$sqlQuery = "SELECT * FROM sayed_IoT ORDER BY ID";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>