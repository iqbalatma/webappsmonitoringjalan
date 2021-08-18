<?php

if (ENVIRONMENT == "production") {
    $conn = mysqli_connect("localhost", "monq1134_admin", "iqbal123atma", "monq1134_monitoringjalan"); //production
} else {
    $conn = mysqli_connect("localhost", "root", "", "monitoring_jalan"); //dev
}

$result = mysqli_query($conn, "SELECT latitude, longitude FROM location WHERE verifikasi = 1 AND status = 'Rusak'");

$data = array();
while ($row = mysqli_fetch_object($result)) {
    array_push($data, $row);
}
echo json_encode($data);
