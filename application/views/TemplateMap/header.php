<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <style>
        .leaflet-control-container .leaflet-routing-container-hide {
            display: none;
        }

        .alerts {
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100%;
            z-index: 9999;
            border-radius: 0px
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }



        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
        }

        #selectoption {
            margin-top: 10px;
            margin-left: 50px;
            width: 300px;

        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- untuk favicon -->
    <link rel="icon" href="<?= base_url() ?>/assets/img/sambas.png" type="image/gif">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- LOAD LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>


    <!-- MARKER CLUSTER CSS Load-->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css" />

    <!-- ROUTING MACHINE CSS Load-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <!-- EASY BUTTON CSS Load -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">

</head>