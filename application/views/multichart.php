<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {
            var datax = []
            var datay = []
            var dataz = []

            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Data Accelerometer"
                },
                axisX: {

                },
                axisY2: {
                    title: "Akselerasi",
                    prefix: "",
                    suffix: ""
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    dockInsidePlotArea: true,
                    itemclick: toogleDataSeries
                },
                data: [{
                        type: "line",
                        axisYType: "secondary",
                        name: "Sumbu X",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: datax
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "Sumbu Y",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: datay
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "Sumbu Z",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: dataz
                    },
                ]
            });


            function addData(data) {
                var dps = data.data_accelerometer;
                for (var i = 0; i < dps.length; i++) {
                    datax.push({
                        x: dps[i][0],
                        y: dps[i][2],
                    });
                    datay.push({
                        x: dps[i][0],
                        y: dps[i][1],
                    });
                    dataz.push({
                        x: dps[i][0],
                        y: dps[i][3]
                    })
                }
                chart.render();
            }

            $.getJSON("<?= base_url() ?>/assets/js/accelerometer/acc_x1.json", addData);

            function toogleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>