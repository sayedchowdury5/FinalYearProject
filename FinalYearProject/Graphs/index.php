<?php
# Loading config data from *.ini-file
$ini = parse_ini_file ('aac_db_config.ini');

# Assigning the ini-values to usable variables
$db_host = $ini['db_host'];
$db_name = $ini['db_name'];
$db_table = $ini['db_table'];
$db_user = $ini['db_user'];
$db_password = $ini['db_password'];

# Prepare a connection to the mySQL database
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($connection){
	//echo "Connected";
}

?>
<!-- start of the HTML part that Google Chart needs -->
<html>
<head>
	<style type="text/css">
	
body
{
    counter-reset: Serial;           /* Set the Serial counter to 0 */
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

th, td {
  padding: 5px;
  text-align: center;
}

tr td:first-child:before
{
  counter-increment: Serial;      /* Increment the Serial counter */
  content:counter(Serial); /* Display the counter */
}
	</style>



	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



	<!--**********************Line Graph for Temperature and Humidity**********-->

<!-- This loads the 'corechart' package. -->	
    <script type="text/javascript">
    	google.charts.load('current', {'packages':['corechart']});
     	google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
    		var data = google.visualization.arrayToDataTable([			
			['Time','Temperature','Humidity'],
<?php

# This query connects to the database and get the last 10 readings
$sql = "SELECT temperature, humidity, date FROM $db_table WHERE device=1 
		ORDER BY ID DESC LIMIT 10";

$result = $connection->query($sql);  

# This while - loop formats and put all the retrieved data into ['timestamp', 'temperature'] way.
	while ($row = $result->fetch_assoc()) {
		$timestamp_rest = substr($row["date"],-8);
		echo "['".$timestamp_rest."',".$row['temperature'].",".$row['humidity']."],";
		}
?>
]);

// Curved line
var temperature_options = {
		title: 'Temperature and Humidity',
		curveType: 'function',
		legend: { position: 'bottom' }
		};

var humidity_options = {
		title: 'Humidity',
		curveType: 'function',
		legend: { position: 'bottom' }
		};

// Curved chart
var chart = new google.visualization.LineChart(document.getElementById('temperature_humidity_curve_chart'));
chart.draw(data, temperature_options, humidity_options);

} // End bracket from drawChart
</script>






	<!--************************Line Graph for Temperature***************-->

<!-- This loads the 'corechart' package. -->	
    <script type="text/javascript">
    	google.charts.load('current', {'packages':['corechart']});
     	google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
    		var data = google.visualization.arrayToDataTable([			
			['Time', 'Temperature'],
<?php

# This query connects to the database and get the last 10 readings
$sql = "SELECT temperature, date FROM $db_table WHERE device=1 
		ORDER BY ID DESC LIMIT 10";

$result = $connection->query($sql);  

# This while - loop formats and put all the retrieved data into ['timestamp', 'temperature'] way.
	while ($row = $result->fetch_assoc()) {
		$timestamp_rest = substr($row["date"],-8);
		echo "['".$timestamp_rest."',".$row['temperature']."],";
		}
?>
]);

// Curved line
var temperature_options = {
		title: 'Temperature',
		curveType: 'function',
		legend: { position: 'bottom' }
		};

// Curved chart
var chart = new google.visualization.LineChart(document.getElementById('temperature_curve_chart'));
chart.draw(data, temperature_options);

} // End bracket from drawChart
</script>




<!--*****************************Bar Graph for Humidity*********************-->

<!-- The charts below is ony available in the 'bar' package -->
<script type="text/javascript">
    	google.charts.load('current', {'packages':['bar']});
     	google.charts.setOnLoadCallback(drawBar);

		function drawBar() {
    		var data = google.visualization.arrayToDataTable([			
			['Time', 'Humidity'],
<?php

# This query connects to the database and get the last 10 readings
$sql = "SELECT humidity, date FROM $db_table WHERE device=1 
		ORDER BY ID DESC LIMIT 10";

$result = $connection->query($sql);  

# This while - loop formats and put all the retrieved data into ['timestamp', 'temperature'] way.
	while ($row = $result->fetch_assoc()) {
		$timestamp_rest = substr($row["date"],-8);
		echo "['".$timestamp_rest."',".$row['humidity']."],";
		}
?>
]);

// Bar graph
var humidity_bar_options = {
		title: 'Humidity',
		bar: { groupWidth: '95%' },
		legend: { position: 'bottom' }
		};   

/*var column_options = {
		width: 800,
		legend: { position: 'none' },
		chart: {
			title: 'Temperature',
			subtitle: '' },
			axes: {
				x: {
					0: { side: 'top', label: 'Temperature'}
				}
			},
			bar: { groupWidth: "90%" }
		};*/

// Bar chart
var chart = new google.visualization.BarChart(document.getElementById('humidity_barchart'));
chart.draw(data, humidity_bar_options);

// Column chart
/*var chart = new google.charts.Bar(document.getElementById('top_x_div'));
chart.draw(data, google.charts.Bar.convertOptions(column_options));*/

} // End bracket from drawBar

</script>
</head>



<body>

<?php

# Prepare a connection to the mySQL database
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

# If there are any errors or the connection is not OK
if ($connection->connect_error) {
	die ("Connection error: ".$connection->connect_error);
}
else {
	//echo "<p>Connection is OK.</p>"; # For debugging purposes
}

//echo "<p>The Last Ten (10) Row Data that is Presented in the Different Graphs are:</p>";

# Prepare a query to the mySQL database and get a list of the last 10 readings.
# We select only what we need
$sql = "SELECT temperature, humidity, date FROM $db_table WHERE device=1 ORDER BY ID DESC LIMIT 10";
$result = $connection->query($sql);

# If we have at least one hit, we'll show it
# Timestamp is formated to only show the last 8 characters
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$timestamp_rest = substr($row["date"],-8);
		//echo "Time: ".$timestamp_rest." ";
		//echo "Humidity: ".$row['humidity']." ";
		//echo "Celsius: ".$row['temperature']."<br />";
	}
} else {
	echo "<p>0 result. The ".$db_table." must be empty.</p>";
}






//**********************Dynamic Table*****************************



//get results from database
/*$resultArray = mysqli_query($connection,"SELECT * FROM $db_table WHERE device=1 ORDER BY ID DESC LIMIT 10");
$all_property = array();  //declare an array for saving property

//showing property
echo '<table class="data-table" border=2>
        <tr class="data-heading">';  //initialize table tag
while ($property = mysqli_fetch_field($resultArray)) {
    echo '<td>' . $property->name . '</td>';  //get field name for header
    array_push($all_property, $property->name);  //save those to array
}
echo '</tr>'; //end tr tag

//showing all data
while ($row = mysqli_fetch_array($resultArray)) {
    echo "<tr>";
    foreach ($all_property as $item) {
        echo '<td>' . $row[$item] . '</td>'; //get items using property value
    }
    echo '</tr>';
}
echo "</table>";*/


//echo "<p>Last line in PHP</p>"; # For debugging purposes
?>



<!--**************************Display All Graphs and Tables**********-->

<div style="">
	<table style="width:100%">
  <caption>The Last Ten (10) Row Data that is Presented in the Different Graphs are:</caption>
  <tr>
    <th>No.</th>
    <th>Device</th>
    <th>Temperature</th>
    <th>Humidity</th>
    <th>Date</th>
  </tr>
  <?php
  $sql = "SELECT * FROM $db_table WHERE device=1 ORDER BY ID DESC LIMIT 10";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo "<tr><td></td><td>" . $row["device"] . "</td><td>"
. $row["temperature"]. "</td><td>" .$row["humidity"]. "</td><td>" .$row["date"]. "</td></tr>";
    }
    echo "</table>";
} else { echo "0 results"; }
  ?>
</table>
</div>


<div class="graph" id="temperature_humidity_curve_chart" style="width: 100%; height: 480px;"></div>

<div class="graph" id="temperature_curve_chart" style="width: 100%; height: 480px;"></div>

<div class="graph" id="humidity_barchart" style="width:100%; height: 480px;"></div>
<!--<div id="top_x_div" style="width: 900px; height: 480px;"></div>-->

</body>
</html>
