<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Demo</title>

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

    <!-- Data tables -->
    <link href="<?= base_url(); ?>/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">



    <!-- LOAD LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- MARKER CLUSTER Load-->
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css" />

    <!-- ROUTING MACHINE -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />



</head>

<body id="page-top">



    <?php if (!empty($this->session->flashdata('msg'))) {
        echo $this->session->flashdata('msg');
    }; ?>

    <div class="alert alert-primary" role="alert" id="alert-jarak">
        A simple primary alert—check it out!
    </div>


    <!-- <h1 id="demo">tes a</h1> -->
    <div id="map">

    </div>
    <!-- <a href="#" onClick="javascript:getSelectedRow('1')>getValues">haha</a> -->
    <div class=" modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url(); ?>/Maps/edit" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="idlocation" id="idlocation" />
                        <input type="hidden" name="token" id="token" value="<?= $token; ?>" />
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Verifikasi Status Jalan</label>
                            <select class="form-control" id="status" name="status">
                                <option>Rusak</option>
                                <option>Tidak Rusak</option>
                                <option></option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Gambar</label>
                            <input type="file" class="form-control-file" id="image_upload" name="image_upload">
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












    <!-- INISIASI DATA -->

    <script>
        const main_url = "<?= base_url(); ?>";
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- <script type="module" src="<?= base_url(); ?>/assets/heightgraph/src/L.Control.Heightgraph.js"></script> -->
    <script src="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>

    <!-- ROUTING MACHINE -->
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>


</body>

<script>
    var timeout = 3000; // in miliseconds (3*1000)

    $('.alert').delay(timeout).fadeOut(300);
</script>



<script type="text/javascript">
    // GLOBAL VARIABAL
    var maxZoom = 16;
    var userDeviceLocationIcon = L.icon({
        iconUrl: main_url + 'assets/js/userDeviceLocation.png',

        iconSize: [30, 30], // size of the icon
    });


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
</script>



<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var data_jalan_rusak = <?php echo json_encode($data_jalan_rusak); ?>;
    var addressPoints = data_jalan_rusak;
</script>
<script type="text/javascript">
    //sampel data, coba ambil dari database
    //contoh titik alamat, ambil dari database

    var markers = L.markerClusterGroup({

        spiderfyOnMaxZoom: false
    });

    //ini adalah on click ketika marker cluster di klik
    markers.on('clusterclick', function(a) {
        // a.layer is actually a cluster
        var locationIdMarkers = new Array();
        if (map.getZoom() == maxZoom) {
            for (var i = 0; i < a.layer._markers.length; i++) {

                locationIdMarkers.push(a.layer._markers[i].options.locationid);
            }

            var popup = L.popup()
                .setLatLng(a.layer.getLatLng())
                .setContent(locationIdMarkers + "")
                .openOn(map);

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
            // getCurent untuk dapat sekali, watch untuk berulang kali
            // navigator.geolocation.getCurrentPosition(getPosition);
            navigator.geolocation.watchPosition(getPosition, error, options);
            // console.log(titikJalanRusakFinal)

        }, 3000);
    }


    //warning ketika lokasi tidak ditemukan
    function error(err) {
        // console.warn('ERROR(' + err.code + '): ' + err.message);
    }

    // inisiasi variabel lokal
    var markerUser, circle, latdevice, longdevice, controlRouting;
    var jarakTerpendek = false;
    // melakukan set pada marker ketik lokasi ditemukan
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

        markerUser = L.marker([latdevice, longdevice], {
            icon: userDeviceLocationIcon
        });
        circle = L.circle([latdevice, longdevice], {
            radius: 20
        });

        $("#alert-jarak").hide(); //debug
        var featureGroup = L.featureGroup([markerUser, circle]).addTo(map);
        // map.fitBounds(featureGroup.getBounds()); //untuk melakukan map bound





        if (titikJalanRusakFinal.length == 0) {
            // console.log(titikJalanRusakFinal)
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
                // console.log(jarak)
            }

            if (jarakTerpendek < 100) {
                $("#alert-jarak").html("Hati-hati ! " + jarakTerpendek + " km ada jalan berlubang");
                $("#alert-jarak").show();
                jarakTerpendek = false;
            }
            // console.log("ini adalah jarak device ke titik jalan" + jarak + "km")


        }

    }



    //inisiasi control untuk routing
    controlRouting = L.Routing.control({
        waypoints: [1.3089668626257436, 109.25733187377519]
    }).addTo(map);


    // membuat button 
    function createButton(label, container) {
        var btn = L.DomUtil.create('button', '', container);
        btn.setAttribute('type', 'button');
        btn.innerHTML = label;
        return btn;
    }


    // ketika map diklik, untuk menitik titik start dan titik destination
    map.on('click', function(e) {
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
        // console.log(titikJalanRusakFinal)

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

    // console.log(distance(1.1305301817391997, 108.96972258086723, 1.0628221785367589, 108.97246916271122, "M"))




    // That's where Open Source Routing Machine -- or OSRM -- comes in. OSRM is a route planning system that runs on OpenStreetMap, a free crowdsourced mapping service. And, yes, it too is open source, meaning anyone can use and modify it for free.
</script>
<!-- TUTUP MARKER CLUSTER -->


<!-- UPHILL ROAD -->
<script>
    var dataJalanMenanjak = <?php echo json_encode($data_jalan_menanjak); ?>;
    // console.log(dataJalanMenanjak);


    for (let i = 0; i < dataJalanMenanjak.length; i++) {
        var polylinePoints = [
            [dataJalanMenanjak[i][1], dataJalanMenanjak[i][2]],
            [dataJalanMenanjak[i][3], dataJalanMenanjak[i][4]],
        ];


        var iqbal = L.Routing.control({
            waypoints: polylinePoints,
            lineOptions: {
                styles: [{
                    color: 'red',
                    opacity: 2,
                    weight: 5
                }]
            }
        });




        iqbal.addTo(map);
        iqbal.hide();


    }
    console.log(iqbal)
</script>





</html>