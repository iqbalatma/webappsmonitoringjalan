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
    var titikJalanRusakFinal = [];
    L.easyButton('fa fa-map-marker', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
    }).addTo(object_leaflet.map);
</script>



<!-- LIVE DEVICE LOCATION -->
<script type="text/javascript">
    $("#alert-jarak").hide();
    var object_devicelocation = new DevicelocationClass();


    function get_position(position) {
        object_devicelocation.latdevice = position.coords.longitude;
        object_devicelocation.longdevice = position.coords.longitude;
        object_devicelocation.accuracy = position.coords.accuracy;

        if (object_devicelocation.markerUser) {
            object_leaflet.map.removeLayer(object_devicelocation.marker_user)
        }
        if (object_devicelocation.circle) {
            object_leaflet.map.removeLayer(object_devicelocation.circle)
        }

        $("#alert-jarak").hide();

        object_devicelocation.marker_user = L.marker([object_devicelocation.latdevice, object_devicelocation.longdevice], {
            icon: object_leaflet.user_device_location
        });
        object_devicelocation.circle = L.circle([object_devicelocation.latdevice, object_devicelocation.longdevice], {
            radius: 20
        });

        object_devicelocation.feature_group = L.featureGroup([object_devicelocation.marker_user, object_devicelocation.circle]).addTo(object_leaflet.map);

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



















    object_leaflet.map.on('click', function(e) {

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
    var addressPoints = <?= json_encode($data_jalan_rusak); ?>;
    var object_markercluster = new MarkerclusterClass(addressPoints, "deteksi");
</script>






</html>