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

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            width: 600px;
            height: 400px;
        }
    </style>

    <style>
        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
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


    <!-- MARKER CLUSTER Load-->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css" />




    <!-- Heightograph Load -->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.css">
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/js/mapping.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/assets/heightgraph/dist/L.Control.Heightgraph.min.js"></script>


</head>

<body id="page-top">

    <div id="map"></div>

    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url(); ?>/Maps/edit" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="idlocation" id="idlocation" />
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Verifikasi Status Jalan</label>
                            <select class="form-control" id="status" name="status">
                                <option>Rusak</option>
                                <option>Tidak Rusak</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Gambar</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>








    <!-- PEMANGGILAN JAVASCRIPT -->
    <script src="<?= base_url(); ?>/assets/js/globalinisiasi.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- LOADER -->
    <script type="module" src="<?= base_url(); ?>/assets/heightgraph/src/L.Control.Heightgraph.js"></script>
    <script src="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>


</body>


<!-- INISIASI MAP -->
<script type="text/javascript">
    const main_url = "<?= base_url(); ?>";
    const map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 9);
    const url = 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=YuJOaTSiwRyG08KX8Bj9';
    const attr = '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors' +
        ', Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>'
    service = new L.TileLayer(url, {
        subdomains: "1234",
        attribution: attr
    });
    const displayGroup = new L.LayerGroup()
    displayGroup.addTo(map)

    L.tileLayer(url, {
        attribution: attr,
        maxZoom: maxZoom
    }).addTo(map);


    // perulangan untuk membuat outline masing-masing kecamatan
    for (let i = 0; i < dataKecamatan.length; i++) {
        //mengambil geojson dari assets
        $.getJSON(main_url + "/assets/GeoJSON/" + dataKecamatan[i] + ".geojson", function(data) {
            // L.geoJson function is used to parse geojson file and load on to map
            geoLayer = L.geoJson(data, {
                style: function(feature) {
                    return {
                        color: dataWarna[i],
                    }
                }
            }).addTo(map);

            //bid untuk memanggil nama kecamatan ketika diklik
            geoLayer.eachLayer(function(layer) {
                layer.bindPopup(dataKecamatan[i])
            })

        });
    }


    var userDeviceLocationIcon = L.icon({
        iconUrl: main_url + 'assets/js/userDeviceLocation.png',
        iconSize: [30, 30], // size of the icon
    });
</script>




<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var data_jalan_rusak = <?php echo json_encode($data_jalan_rusak); ?>;
    var addressPoints = data_jalan_rusak
    console.log(addressPoints);
    var markers = L.markerClusterGroup({

        spiderfyOnMaxZoom: false
    });

    //ini adalah on click ketika marker cluster di klik
    markers.on('clusterclick', function(a) {
        // a.layer is actually a cluster
        var locationIdMarkers = new Array();

        if (map.getZoom() == maxZoom) {
            for (var i = 0; i < a.layer._markers.length; i++) {
                console.log(a.layer._markers[i].options.locationid);
                locationIdMarkers.push(a.layer._markers[i].options.locationid);
            }

            // //untuk membuka popup
            // var popup = L.popup()
            //     .setLatLng(a.layer.getLatLng())
            //     .setContent(locationIdMarkers + "")
            //     .openOn(map);

            $('#myModal').modal('show');
            document.getElementById('idlocation').value = locationIdMarkers;
        }
    });



    // ini adalah marker cluster, datanya dari addres point
    for (var i = 0; i < addressPoints.length; i++) {
        var a = addressPoints[i];
        var locationid = a[0];
        var marker = L.marker(new L.LatLng(a[1], a[2]), {
            locationid: locationid
        });
        marker.bindPopup(locationid);
        markers.addLayer(marker);
    }
    map.addLayer(markers);
    // ADA PERBEDAAN antara marker dan markers, markers pada markercluster 



    // LOCATION DEVICE
    var id, target, options;

    target = {
        latitude: 0,
        longitude: 0
    };

    options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };


    // realtime tracking
    if (!navigator.geolocation.getCurrentPosition) {
        console.log("Browser tidak support");
    } else {
        setInterval(() => {
            navigator.geolocation.watchPosition(getPosition, error, options);
        }, 3000);
    }


    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }

    var markerUser, circle, latdevice, longdevice;

    // set marker on response position
    function getPosition(position) {
        console.log(position)
        latdevice = position.coords.latitude
        longdevice = position.coords.longitude
        var accuracy = position.coords.accuracy
        if (markerUser) {
            map.removeLayer(markerUser)
        }
        if (circle) {
            map.removeLayer(circle)
        }

        // markerUser = L.marker([lat, long]);
        markerUser = L.marker([latdevice, longdevice], {
            icon: userDeviceLocationIcon
        });
        circle = L.circle([latdevice, longdevice], {
            radius: 20
        });


        var featureGroup = L.featureGroup([markerUser, circle]).addTo(map);
        // map.fitBounds(featureGroup.getBounds());
    }
</script>












</html>