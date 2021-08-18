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
</script>


<!-- ROUTING MACHINE -->
<script>
    // mengambil data jalan rusak dari database dengan ajax
    var koordinatejalanrusak;
    var ajax = new XMLHttpRequest();
    ajax.open("OPEN", main_url + "assets/AjaxServer/Serv.php", true);
    ajax.send();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            koordinatejalanrusakjson = this.responseText
        }
    };







    var demo = [];

    var object_routingmachine = new RoutingmachineClass();


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