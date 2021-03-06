<!DOCTYPE html>
<!--suppress JSUnresolvedLibraryURL -->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Height Graph Example</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style>
        html,
        body,
        #map {
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js"></script>


    <link rel="stylesheet" href="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.css" />
    <script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/example/data.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/example/mappings.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.js"></script>

</head>

<body>
    <h1>Leaflet</h1>
    <div id="map"></div>
</body>
<script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/example/example.js">
</script>

</html>