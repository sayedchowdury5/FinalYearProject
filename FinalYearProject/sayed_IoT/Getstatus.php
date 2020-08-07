<?php
$actuator = $_GET['actuator'];
$device = $_GET['device'];
$server 	= "localhost";	// Change this to correspond with your database port
$username 	= "id14314173_fypsayed";			// Change if use webhost online
$password 	= "#AbuSayed59395";
$DB 		= "id14314173_sayedfyp";			// database name


$conn = new mysqli($server, $username, $password,$DB);		// Check database connection
	if ($conn->connect_error) 
	{
		//die("Connection failed: " . $conn->connect_error);
	} 
	
	$query ="SELECT * from status WHERE deviceID='$device' and sensorID='$actuator'";					// Select all data in table "status"
	$result = $conn->query($query);
	
		while($row = $result->fetch_assoc()) 
		{				
			echo $row["status"];					// Echo data , equivalent with send data to esp
		}

?>