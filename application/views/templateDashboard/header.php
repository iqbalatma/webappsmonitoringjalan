<!-- Ini adalah header untuk dashboard -->

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <!-- untuk favicon -->
    <link rel="icon" href="<?= base_url() ?>/assets/img/sambas.png" type="image/gif">


    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Data tables -->
    <link href="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">



    <!-- LOAD LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>


    <!-- MARKER CLUSTER Load-->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css" />


    <!-- elevation -->
    <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/elevation/elevation.css" />

    <!-- Heightograph Load -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.css">
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/mapping.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.js"></script>

</head>

<body id="page-top">
    <!-- Page Wrapper ditutup di footer.php-->
    <div id="wrapper">