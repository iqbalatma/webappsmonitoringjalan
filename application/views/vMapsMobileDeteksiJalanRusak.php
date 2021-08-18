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
    // inisiasi variabel global
    var titikJalanRusakFinal = [];
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
        object_devicelocation.circle = L.circle([object_devicelocation.latdevice, object_devicelocation.longdevice], {
            radius: 20
        });

        featureGroup = L.featureGroup([markerUser, circle]).addTo(map);

        // console.log("ho")
        if (titikJalanRusakFinal.length == 0) {
            // ketika user belum menentukan titik rute maka titik jalan rusak yang dilalui akan kosong
            console.log("Titik jalan rusak tidak ada")
        } else {
            // Ketika rute ditemukan dan terdapat jalan rusak pada rute tersebut
            //cari dulu jarak terpendek dari titik user baru tampilkan alert
            var index;
            for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                jarak = object_devicelocation.distance(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1], latdevice, longdevice, "M");
                if (object_devicelocation.jarak_terpendek == false) { //berarti jarak terpendek belum di set
                    object_devicelocation.jarak_terpendek = jarak
                    index = i;
                } else { //kalau jarak terpendek sudah diset, maka selanjutnya adalah membandingkan jarak di variabel dengan di looping
                    if (object_devicelocation.jarak_terpendek > jarak) { //jika jarak terpendek lebih besar dari jarak, berarti jarak terbaru tersebut merupakan jarak lebih pendek, simpan ke variabel
                        object_devicelocation.jarak_terpendek = jarak
                        index = i;
                    }
                }
            }


            console.log(object_devicelocation.jarak_terpendek);


            if (object_devicelocation.jarak_terpendek < 100) {
                $("#alert-jarak").html("Hati-hati ! " + parseFloat(object_devicelocation.jarak_terpendek).toFixed(2) + " m ada jalan berlubang");
                $("#alert-jarak").show();
                if (object_devicelocation.jarak_terpendek < 5) {
                    console.log("pemotongan tereksekusi");
                    titikJalanRusakFinal.splice(index, 1)
                }
            }
            object_devicelocation.jarak_terpendek = false;
        }

    }
</script>


<!-- ROUTING MACHINE -->
<script>
    controlRouting = L.Routing.control({
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
    }).addTo(map);

    map.on('click', function(e) {

        var container = L.DomUtil.create('div'),
            startBtn = createButton('Mulai dari lokasi ini', container),
            destBtn = createButton('Menuju lokasi ini', container);


        L.DomEvent.on(destBtn, 'click', function() {
            controlRouting.spliceWaypoints(controlRouting.getWaypoints().length - 1, 1, e.latlng);
            controlRouting.spliceWaypoints(0, 1, [latdevice, longdevice]);
            map.closePopup();
            console.log(controlRouting.getWaypoints());
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
    ajax.open("OPEN", object_leaflet.main_url + "assets/AjaxServer/Serv.php", true);
    ajax.send();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            koordinatejalanrusak = this.responseText
            console.log(koordinatejalanrusak);
        }
    };

    x = [{
        "latitude": "1.06320954",
        "longitude": "108.97321338"
    }, {
        "latitude": "1.0632212",
        "longitude": "108.97307615"
    }, {
        "latitude": "1.06321072",
        "longitude": "108.97322186"
    }, {
        "latitude": "1.06319638",
        "longitude": "108.97322468"
    }, {
        "latitude": "1.1762523",
        "longitude": "108.97452799999999"
    }];

    var object_routingmachine = new RoutingmachineClass(x);






    var demo = [];






    titikJalanRusakFinal = jalanRusakYangDilaluiFilteredSecondStep;
    map.removeLayer(markers);




    for (let i = 0; i < titikJalanRusakFinal.length; i++) {
        demo[i] = L.Routing.control({
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
        demo[i].addTo(map);
        demo[i].hide();
    }








    object_leaflet.map.on('click', function(e) {

                map.addLayer(markers);
                for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                    demo[i].setWaypoints([]);

                    var container = L.DomUtil.create('div');

                    var startBtn = object_leaflet.create_button('Mulai dari lokasi ini', container);
                    var destBtn = object_leaflet.create_button('Menuju lokasi ini', container);


                    L.DomEvent.on(destBtn, 'click', function() {
                        object_routingmachine.control_routing.spliceWaypoints(object_routingmachine.control_routing.getWaypoints().length - 1, 1, e.latlng);
                        object_routingmachine.control_routing.spliceWaypoints(0, 1, [object_devicelocation.latdevice, object_devicelocation.longdevice]);
                        object_leaflet.map.closePopup();
                        console.log(object_routingmachine.control_routing.getWaypoints());
                    });

                    L.DomEvent.on(startBtn, 'click', function() {
                        object_routingmachine.control_routing.spliceWaypoints(0, 1, e.latlng);
                        object_leaflet.map.closePopup();
                    });

                    L.popup()
                        .setContent(container)
                        .setLatLng(e.latlng)
                        .openOn(object_leaflet.map);

                });
</script>



<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    var addressPoints = <?php echo json_encode($data_jalan_rusak); ?>;
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/markercluster.js"></script>
<!-- TUTUP MARKER CLUSTER -->



</html>