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

    <!-- Data tables -->
    <link href="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">



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


    <!-- ROUTING MACHINE -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>

</head>

<body id="page-top">
    <div class="alert alert-primary" role="alert" id="alert-jarak">
        A simple primary alert—check it out!
    </div>
    <div id="map"></div>





    <!-- INISIASI DATA -->

    <script>
        const main_url = "<?= base_url(); ?>";
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>


    <!-- LOADER -->
    <script type="module" src="<?= base_url(); ?>/assets/heightgraph/src/L.Control.Heightgraph.js"></script>
    <script src="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>
    <script src="<?= base_url(); ?>/assets/js/globalinisiasi.js"></script>




</body>



<!-- INISIASI CODE UNTUK MEMANGGIL MAP -->
<script type="text/javascript">
    var markerUser, circle, controlRouting, featureGroup;
    var userDeviceLocationIcon = L.icon({
        iconUrl: main_url + 'assets/js/userDeviceLocation.png',

        iconSize: [30, 30], // size of the icon

    });



    const map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 18);
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


    var helloPopup = L.popup().setContent('Hello World!');

    L.easyButton('fa fa-map-marker', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
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
        });
    }






    var id, target, options;
    var jarakTerpendek = false;

    target = {
        latitude: 0,
        longitude: 0
    };

    options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };


    if (!navigator.geolocation.getCurrentPosition) {
        console.log("Browser tidak support");
    } else {
        setInterval(() => {
            // navigator.geolocation.getCurrentPosition(getPosition);
            navigator.geolocation.watchPosition(getPosition, error, options);
            // console.log(titikJalanRusakFinal)
            // console.log("haha")
        }, 1000);
    }


    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }


    var lat, long;

    function getPosition(position) {
        // console.log(position)
        latdevice = position.coords.latitude
        longdevice = position.coords.longitude
        var accuracy = position.coords.accuracy
        if (markerUser) {
            map.removeLayer(markerUser)
        }
        if (circle) {
            map.removeLayer(circle)
        }
        $("#alert-jarak").hide(); //debug

        markerUser = L.marker([latdevice, longdevice], {
            icon: userDeviceLocationIcon
        });
        circle = L.circle([latdevice, longdevice], {
            radius: 20
        });

        featureGroup = L.featureGroup([markerUser, circle]).addTo(map);


        if (titikJalanRusakFinal.length == 0) {
            console.log(titikJalanRusakFinal)
        } else {

            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                jarak = distance(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1], latdevice, longdevice, "M");
                if (jarakTerpendek == false) { //berarti jarak terpendek belum di set
                    jarakTerpendek = jarak
                } else {
                    if (jarakTerpendek > jarak) {
                        jarakTerpendek = jarak
                    }
                }
                console.log(jarak)
            }

            $("#alert-jarak").html("Hati-hati ! " + jarakTerpendek + " km ada jalan berlubang");
            $("#alert-jarak").show();
            jarakTerpendek = false;
            console.log("jarak aktif")
            // if (jarakTerpendek > 10) {
            //     $("#alert-jarak").html("Hati-hati ! " + jarakTerpendek + " km ada jalan berlubang");
            //     $("#alert-jarak").show();
            //     jarakTerpendek = false;
            //     console.log("jarak aktif")
            // }
            // console.log("ini adalah jarak device ke titik jalan" + jarak + "km")


        }


    }




    controlRouting = L.Routing.control({
        waypoints: [
            // L.latLng(lat, long),
        ]
    }).addTo(map);




    function createButton(label, container) {
        var btn = L.DomUtil.create('button', '', container);
        btn.setAttribute('type', 'button');
        btn.innerHTML = label;
        return btn;
    }


    map.on('click', function(e) {
        console.log(e);
        var container = L.DomUtil.create('div'),
            startBtn = createButton('Start from this location', container),
            destBtn = createButton('Go to this location', container);

        L.DomEvent.on(destBtn, 'click', function() {
            controlRouting.spliceWaypoints(controlRouting.getWaypoints().length - 1, 1, e.latlng);
            map.closePopup();
        });

        L.DomEvent.on(startBtn, 'click', function() {
            controlRouting.spliceWaypoints(0, 1, e.latlng);
            map.closePopup();
        });

        L.popup()
            .setContent(container)
            .setLatLng(e.latlng)
            .openOn(map);

    });


    // mengambil data jalan rusak dari database dengan ajax
    var koordinatejalanrusak;
    var ajax = new XMLHttpRequest();
    ajax.open("OPEN", main_url + "assets/AjaxServer/Serv.php", true);
    ajax.send();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            koordinatejalanrusak = this.responseText
        }

    };


    // inisiasi variabel global
    var jalanRusakYangDilalui = [];
    var titikJalanRusakFinal = [];

    // event ketika rute ditemukan
    controlRouting.on('routesfound', function(e) {
        koordinatejalanrusak = JSON.parse(koordinatejalanrusak)
        coordinateFromRoute = e.routes[0].coordinates;

        var lat1, lat2, long1, long2;
        // perulangan untuk mengecek data jalan rusak apda database, berarti perulangan paling luar adalah data pada database
        for (let i = 0; i < koordinatejalanrusak.length; i++) {
            // menyimpan data latitude dan longitude jalan rusak kedalam variabel
            lat1 = koordinatejalanrusak[i]["latitude"];
            long1 = koordinatejalanrusak[i]["longitude"];
            // perulangan terdalam adalah data rute jalan, data cukup banyak hingga ratusan
            for (let j = 0; j < coordinateFromRoute.length; j++) {
                // menyimpan data latitude dan longitude rute kedalam variabel
                lat2 = coordinateFromRoute[j]["lat"];
                long2 = coordinateFromRoute[j]["lng"];
                // menghitung jarak antar kedua titik
                jarak = distance(lat1, long1, lat2, long2, "M");

                // mengecek apakah jaraknya kurang dari 5 meter antara rute dan titik jalan rusak, jika ya kemungkinan rute melalui jalan rusak tersebut

                if (jarak < 50) {
                    // console.log("haha jaraknya " + jarak)
                    jalanRusakYangDilalui.push([lat1, long1])
                }
            }
        }
        // data jalan rusak yang dilalui sudah didapat tapi masih terdapat data duplicate dan akan difilter dengan kode dibawah
        var jalanRusakYangDilaluiFilteredFirstStep = jalanRusakYangDilalui.filter((t = {}, a => !(t[a] = a in t)));


        //buat variabel untuk data sudah diperiksa jaraknya, jadi kita akan menghapus data titik jalan rusak yang berdekatan
        var jalanRusakYangDilaluiFilteredSecondStep = [];
        //lakukan perulangan pada semua data titik jalan rusak yang telah difilter
        for (let i = 0; i < jalanRusakYangDilaluiFilteredFirstStep.length; i++) {
            // kalau array data yang jaraknya diperiksa ternyata masih kosong, lakukan push tanpa pengecekan
            if (jalanRusakYangDilaluiFilteredSecondStep.length == 0) { //kalau arraynya masih kosong, masukkan saja
                jalanRusakYangDilaluiFilteredSecondStep.push(jalanRusakYangDilaluiFilteredFirstStep[i]);
            } else { //kalau arraynya tidak kosong, lakukan pengecekan jarak yang akan masuk (perulangan terluar) dan yang ada didalam array (perulangan terdalam)
                // kalau array tidak kosong, maka data yang sedang dijalankan pada array filtered akan di cocokkan dengan data titik pada array yang jaraknya diperiksa, dengan melakukan perulangan pada array yang jaraknya diperiksa
                for (let j = 0; j < jalanRusakYangDilaluiFilteredSecondStep.length; j++) {
                    lat1 = jalanRusakYangDilaluiFilteredFirstStep[i][0]; //lat
                    long1 = jalanRusakYangDilaluiFilteredFirstStep[i][1]; //long
                    lat2 = jalanRusakYangDilaluiFilteredSecondStep[j][0]; //lat
                    long2 = jalanRusakYangDilaluiFilteredSecondStep[j][1]; //long
                    jarak = distance(lat1, long1, lat2, long2, "M");
                    // apabila jaraknya lebih dari 100 meter maka titik tersebut akan dianggap sebagai titik lainnya dan akan dipisahkan untuk memberikan notif
                    if (jarak > 100) {
                        jalanRusakYangDilaluiFilteredSecondStep.push(jalanRusakYangDilaluiFilteredFirstStep[i]);
                        break
                    }
                }
            }

        }

        titikJalanRusakFinal = jalanRusakYangDilaluiFilteredSecondStep;
        console.log(titikJalanRusakFinal)
        console.log(koordinatejalanrusak)
        // console.log("haha")

    });

    // FUNGSI UNTUK MENGHITUNG JARAK DUA TITIK KOORDINATE, DENGAN UNIT M UNTUK SATUAN METER
    function distance(lat1, lon1, lat2, lon2, unit) {
        if ((lat1 == lat2) && (lon1 == lon2)) {
            return 0;
        } else {
            var radlat1 = Math.PI * lat1 / 180;
            var radlat2 = Math.PI * lat2 / 180;
            var theta = lon1 - lon2;
            var radtheta = Math.PI * theta / 180;
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist);
            dist = dist * 180 / Math.PI;
            dist = dist * 60 * 1.1515;
            if (unit == "M") {
                dist = dist * 1.609344 * 1000
            }
            if (unit == "N") {
                dist = dist * 0.8684
            }
            return dist;
        }
    }
</script>
<!-- TUTUP INISASI MAP -->







<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var data_jalan_rusak = <?php echo json_encode($data_jalan_rusak); ?>;
    var addressPoints = data_jalan_rusak
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/markercluster.js"></script>
<!-- TUTUP MARKER CLUSTER -->



















<!-- HEIGHTGRAPH CODE-->
<script type="text/javascript">
    var data_altitude = <?php echo json_encode($data_altitude); ?>;
    var final_altitude = [];
    for (let i = 0; i < data_altitude.length; i++) {
        final_altitude.push([data_altitude[i][1], data_altitude[i][0], data_altitude[i][2]]);
    }
</script>

<script type="text/javascript">
    const geojson1 = [{
        "type": "FeatureCollection",
        "features": [{
            "type": "Feature",
            "geometry": {
                "type": "LineString",
                "coordinates": final_altitude
            },
            "properties": {
                "attributeType": 0
            }
        }, ],
        "properties": {
            "Creator": "OpenRouteService.org",
            "records": 10,
            "summary": "surface",
            "label": "Surface"
        }
    }];
</script>

<script type="text/javascript" src="<?= base_url(); ?>/assets/js/heightgraph.js"></script>
<!-- TUTUP HEIGHTGRAPH -->

</html>