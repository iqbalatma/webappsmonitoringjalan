<body id="page-top">
    <div class="alert alert-primary fixed-top" role="alert" id="alert-jarak">

    </div>
    <div id="map"></div>

</body>

<!-- FOOTER UNTUK LOAD JAVASCRIPT -->
<?php require("TemplateMap/footer.php"); ?>


<!-- CORE TEMPAT OPERASI DAN METHOD -->
<script type="text/javascript">
    var titikJalanRusakFinal = [];
    L.easyButton('fa fa-map-marker', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
    }).addTo(object_leaflet.map);
</script>



<!-- LIVE DEVICE LOCATION -->
<script type="text/javascript">
    var counter_suara = 0;


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

    function geoerror(e) {

    }

    function playSound(url) {
        const audio = new Audio(url);
        audio.play();
    }

    $("#alert-jarak").hide();

    function getPosition(position) {
        latdevice = position.coords.latitude
        longdevice = position.coords.longitude
        accuracy = position.coords.accuracy
        if (markerUser) {
            object_leaflet.map.removeLayer(markerUser)
        }
        if (circle) {
            object_leaflet.map.removeLayer(circle)
        }
        $("#alert-jarak").hide();

        markerUser = L.marker([latdevice, longdevice], {
            icon: object_leaflet.user_device_location
        });
        circle = L.circle([latdevice, longdevice], {
            radius: 20
        });

        featureGroup = L.featureGroup([markerUser, circle]).addTo(object_leaflet.map);

        // console.log("ho")
        if (titikJalanRusakFinal.length == 0) {
            // ketika user belum menentukan titik rute maka titik jalan rusak yang dilalui akan kosong
            console.log("Titik jalan rusak tidak ada");

            // playSound('https://monitoringjalansambas.my.id/assets/sound_notif.mp3');


        } else {
            // Ketika rute ditemukan dan terdapat jalan rusak pada rute tersebut
            //cari dulu jarak terpendek dari titik user baru tampilkan alert
            var index;
            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                jarak = object_leaflet.distance(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1], latdevice, longdevice, "M");
                if (jarakTerpendek == false) { //berarti jarak terpendek belum di set
                    jarakTerpendek = jarak
                    index = i;
                } else { //kalau jarak terpendek sudah diset, maka selanjutnya adalah membandingkan jarak di variabel dengan di looping
                    if (jarakTerpendek > jarak) { //jika jarak terpendek lebih besar dari jarak, berarti jarak terbaru tersebut merupakan jarak lebih pendek, simpan ke variabel
                        jarakTerpendek = jarak
                        index = i;
                        // console.log(titikJalanRusakFinal[i])
                    }
                }
            }


            if (counter_suara == 0) {
                var audio = new Audio('https://monitoringjalansambas.my.id/assets/sound_notif.mp3');
                audio.play();
                if (counter_suara == 7) {
                    counter_suara = 0;
                }
                counter_suara = counter_suara + 1;
            } else {
                counter_suara = counter_suara + 1;
            }




            if (jarakTerpendek < 100) {

                if (jarakTerpendek <= 10) {
                    if (counter_suara == 0) {
                        var audio = new Audio('https://monitoringjalansambas.my.id/assets/sound_notif.mp3');
                        audio.play();
                        if (counter_suara == 7) {
                            counter_suara = 0;
                        }
                        counter_suara = counter_suara + 1;
                    } else {
                        counter_suara = counter_suara + 1;
                    }
                }
                console.log(jarakTerpendek);
                $("#alert-jarak").html("Hati-hati ! " + parseFloat(jarakTerpendek).toFixed(2) + " m ada jalan berlubang");
                $("#alert-jarak").show();
                if (jarakTerpendek < 5) {
                    console.log("pemotongan tereksekusi");
                    titikJalanRusakFinal.splice(index, 1)
                }

            }
            jarakTerpendek = false;


        }
    }
</script>
<!-- TUTUP LIVE DEVICE LOCATION -->


<!-- ROUTING MACHINE -->
<script>
    // pk.eyJ1IjoiaXFiYWxhdG1hIiwiYSI6ImNrc2lwaDM3ejFtb3gzMG9mdzNtcHJycDAifQ.6jjNDuM8gItHG7j68Py7CA
    controlRouting = L.Routing.control({
        router: L.Routing.mapbox('pk.eyJ1IjoiaXFiYWxhdG1hIiwiYSI6ImNrc2lwaDM3ejFtb3gzMG9mdzNtcHJycDAifQ.6jjNDuM8gItHG7j68Py7CA'),
        // fitSelectedRoutes: false,
        useZoomParameter: false,
        waypoints: [
            // L.latLng(lat, long),
        ],
        lineOptions: {
            styles: [{
                color: 'blue',
                opacity: 1,
                weight: 3
            }]
        },
        // autoRoute: true
    }).addTo(object_leaflet.map);

    object_leaflet.map.on('click', function(e) {

        var container = L.DomUtil.create('div'),
            startBtn = object_leaflet.create_button('Mulai dari lokasi ini', container),
            destBtn = object_leaflet.create_button('Menuju lokasi ini', container);


        L.DomEvent.on(destBtn, 'click', function() {
            controlRouting.spliceWaypoints(controlRouting.getWaypoints().length - 1, 1, e.latlng);
            controlRouting.spliceWaypoints(0, 1, [latdevice, longdevice]);
            object_leaflet.map.closePopup();
        });

        L.DomEvent.on(startBtn, 'click', function() {
            controlRouting.spliceWaypoints(0, 1, e.latlng);
            object_leaflet.map.closePopup();
        });

        L.popup()
            .setContent(container)
            .setLatLng(e.latlng)
            .openOn(object_leaflet.map);
    });




    // mengambil data jalan rusak dari database dengan ajax
    var koordinatejalanrusak;
    var ajax = new XMLHttpRequest();
    ajax.open("OPEN", object_leaflet.main_url + "assets/AjaxServer/Serv.php", true);
    ajax.send();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            koordinatejalanrusakjson = this.responseText
        }
    };


    controlRouting.on('routingerror', function(e) {
        console.log(e);
    });

    var demo = [];
    controlRouting.on('routesfound', function(e) {
        var jalanRusakYangDilalui = [];
        koordinatejalanrusak = JSON.parse(koordinatejalanrusakjson) //dari db
        coordinateFromRoute = e.routes[0].coordinates; //dari rute
        console.log(koordinatejalanrusak);

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
                jarak = object_leaflet.distance(lat1, long1, lat2, long2, "M");
                // mengecek apakah jaraknya kurang dari 5 meter antara rute dan titik jalan rusak, jika ya kemungkinan rute melalui jalan rusak tersebut
                if (jarak < 50) {
                    // console.log("haha jaraknya " + jarak)
                    jalanRusakYangDilalui.push([lat1, long1])
                }
            }
        }



        if (jalanRusakYangDilalui.length > 0) {
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
                        jarak = object_leaflet.distance(lat1, long1, lat2, long2, "M");
                        // apabila jaraknya lebih dari 100 meter maka titik tersebut akan dianggap sebagai titik lainnya dan akan dipisahkan untuk memberikan notif
                        if (jarak > 100) {
                            jalanRusakYangDilaluiFilteredSecondStep.push(jalanRusakYangDilaluiFilteredFirstStep[i]);
                            break
                        }
                    }
                }

            }


            titikJalanRusakFinal = jalanRusakYangDilaluiFilteredSecondStep;
            object_leaflet.map.removeLayer(object_markercluster.markers);




            // UNTUK MENAMBAHKAN TITIK JALAN RUSAK JADI RUTE MERAH
            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                demo[i] = L.Routing.control({
                    router: L.Routing.mapbox('pk.eyJ1IjoiaXFiYWxhdG1hIiwiYSI6ImNrc2lwaDM3ejFtb3gzMG9mdzNtcHJycDAifQ.6jjNDuM8gItHG7j68Py7CA'),
                    fitSelectedRoutes: false,
                    useZoomParameter: false,
                    waypoints: [
                        L.latLng(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1]),
                        L.latLng(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1]),
                    ],
                    lineOptions: {
                        styles: [{
                            color: 'red',
                            opacity: 10,
                            weight: 10
                        }]
                    },
                    createMarker: function() {
                        return null;
                    }
                })
                demo[i].addTo(object_leaflet.map);
                demo[i].hide();

            }


        } else {
            //untuk menghapus rute merah dan memasukkan marker
            object_leaflet.map.addLayer(object_markercluster.markers);
            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                demo[i].setWaypoints([

                ]);
            }


        }



    });
</script>
<!-- TUTUP ROUTING MACHINE -->


<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var addressPoints = <?= json_encode($data_jalan_rusak); ?>;
    var object_markercluster = new MarkerclusterClass(addressPoints);
</script>
<!-- TUTUP MARKER CLUSTER -->



</html>