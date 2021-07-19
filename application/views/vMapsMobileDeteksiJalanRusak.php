<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- BODY HTML -->

<body id="page-top">
    <div class="alert alert-primary fixed-top" role="alert" id="alert-jarak">

    </div>
    <div id="map"></div>
</body>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->


<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- FOOTER UNTUK LOAD JAVASCRIPT -->
<?php require("TemplateMap/footer.php"); ?>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->





<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- CORE TEMPAT OPERASI DAN METHOD -->
<script type="text/javascript">
    // membuat button untuk recenter
    L.easyButton('fa fa-map-marker', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
    }).addTo(map);
</script>



<!-- LIVE DEVICE LOCATION -->
<script type="text/javascript">
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
            navigator.geolocation.watchPosition(getPosition, geoerror, options);
        }, 1000);
    }



    $("#alert-jarak").hide();

    function getPosition(position) {
        latdevice = position.coords.latitude
        longdevice = position.coords.longitude
        accuracy = position.coords.accuracy
        if (markerUser) {
            map.removeLayer(markerUser)
        }
        if (circle) {
            map.removeLayer(circle)
        }
        $("#alert-jarak").hide();

        markerUser = L.marker([latdevice, longdevice], {
            icon: userDeviceLocationIcon
        });
        circle = L.circle([latdevice, longdevice], {
            radius: 20
        });

        featureGroup = L.featureGroup([markerUser, circle]).addTo(map);


        if (titikJalanRusakFinal.length == 0) {
            // ketika user belum menentukan titik rute maka titik jalan rusak yang dilalui akan kosong
            console.log("Titik jalan rusak tidak ada")
        } else {
            // Ketika rute ditemukan dan terdapat jalan rusak pada rute tersebut
            //cari dulu jarak terpendek dari titik user baru tampilkan alert
            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                jarak = distance(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1], latdevice, longdevice, "M");
                if (jarakTerpendek == false) { //berarti jarak terpendek belum di set
                    jarakTerpendek = jarak
                } else { //kalau jarak terpendek sudah diset, maka selanjutnya adalah membandingkan jarak di variabel dengan di looping
                    if (jarakTerpendek > jarak) { //jika jarak terpendek lebih besar dari jarak, berarti jarak terbaru tersebut merupakan jarak lebih pendek, simpan ke variabel
                        jarakTerpendek = jarak
                    }
                }
                // console.log(jarak) // untuk debug
            }

            // $("#alert-jarak").html("Hati-hati ! " + jarakTerpendek + " km ada jalan berlubang");
            // $("#alert-jarak").show();
            // jarakTerpendek = false; //untuk mengosongkan jarak terpendek
            // console.log("jarak aktif")
            $("#alert-jarak").html("Hati-hati ! " + parseFloat(jarakTerpendek).toFixed(2) + " m ada jalan berlubang");
            $("#alert-jarak").show();
            jarakTerpendek = false;

            if (jarakTerpendek < 100) {

            }
        }
    }
</script>


<!-- ROUTING MACHINE -->
<script>
    controlRouting = L.Routing.control({
        waypoints: [
            // L.latLng(lat, long),
        ],
        lineOptions: {
            styles: [{
                color: 'blue',
                opacity: 10,
                weight: 5
            }]
        }
    }).addTo(map);

    map.on('click', function(e) {

        var container = L.DomUtil.create('div'),
            startBtn = createButton('Mulai dari lokasi ini', container),
            destBtn = createButton('Menuju lokasi ini', container);


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
            koordinatejalanrusak = this.responseText
        }
    };


    // inisiasi variabel global
    var jalanRusakYangDilalui = [];
    var titikJalanRusakFinal = [];

    // event ketika rute ditemukan
    controlRouting.on('routesfound', function(e) {

        koordinatejalanrusak = JSON.parse(koordinatejalanrusak) //dari db
        coordinateFromRoute = e.routes[0].coordinates; //dari rute
        // console.log(koordinatejalanrusak)
        // console.log(coordinateFromRoute)


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


    });
</script>



<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var data_jalan_rusak = <?php echo json_encode($data_jalan_rusak); ?>;
    var addressPoints = data_jalan_rusak

    // var demo = L.Routing.control({
    //     waypoints: [
    //         L.latLng(addressPoints[0][0], addressPoints[0][1]),
    //         L.latLng(addressPoints[1][0], addressPoints[1][1]),
    //     ],
    //     lineOptions: {
    //         styles: [{
    //             color: 'red',
    //             opacity: 10,
    //             weight: 5
    //         }]
    //     }
    // }).addTo(map);
    // console.log(addressPoints)
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/markercluster.js"></script>
<!-- TUTUP MARKER CLUSTER -->



</html>