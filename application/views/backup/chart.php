<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {
            var dataPoints = [];

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: "Percobaan Mencari Threshold"

                },
                axisY: {
                    title: "Sumbu Vertikal",
                    titleFontSize: 24,
                    prefix: ""
                },
                data: [{
                    type: "line",
                    dataPoints: dataPoints
                }]
            });

            function addData(data) {
                var dps = data.data_accelerometer;
                for (var i = 0; i < dps.length; i++) {
                    dataPoints.push({
                        x: dps[i][0],
                        y: dps[i][2],

                    });
                }
                chart.render();
            }

            $.getJSON("<?= base_url() ?>/assets/js/datachart.json", addData);

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>

</html>