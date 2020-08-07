<!DOCTYPE html>
<html>
<head>
<style type="text/css">
/*.container{
    display: inline-block;
}*/

#chart-container {
    width: 100%;
    height:auto;
}

#chart-container1 {
    width: 100%;
    height:auto;
}
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>


</head>
<body>
    <div class="container" id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <div class="container" id="chart-container1">
        <canvas id="graphCanvas1"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("chart_data.php",
                function (data)
                {
                    console.log(data);
                     var date = [];
                    var humidity = [];
                    //var temperature = [];

                    for (var i in data) {
                        date.push(data[i].date);
                        humidity.push(data[i].humidity);
                        //temperature.push(data[i].temperature);
                    }

                    var chartdata = {
                        labels: date,
                        datasets: [
                            {
                                label: 'Humidity',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: humidity
                            },
                            /*{
                                label: 'Temperature',
                                backgroundColor: '#ff0000',
                                borderColor: '#ff0000',
                                hoverBackgroundColor: '#ff0000',
                                hoverBorderColor: '#ff0000',
                                data: temperature
                            }*/
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>

        <script>
        $(document).ready(function () {
            showGraph1();
        });


        function showGraph1()
        {
            {
                $.post("data.php",
                function (data)
                {
                    console.log(data);
                     var date = [];
                    //var humidity = [];
                    var temperature = [];

                    for (var i in data) {
                        date.push(data[i].date);
                        //humidity.push(data[i].humidity);
                        temperature.push(data[i].temperature);
                    }

                    var chartdata = {
                        labels: date,
                        datasets: [
                            /*{
                                label: 'Humidity',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: humidity
                            },*/
                            {
                                label: 'Temperature',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: temperature
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas1");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>

</body>
</html>