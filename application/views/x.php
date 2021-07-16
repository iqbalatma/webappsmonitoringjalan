<body id="page-top">



    <?php if (!empty($this->session->flashdata('msg'))) {
        echo $this->session->flashdata('msg');
    }; ?>

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

                <form action="<?= base_url(); ?>/Maps/edit" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="idlocation" id="idlocation" />
                        <input type="hidden" name="token" id="token" value="<?= $token; ?>" />
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Verifikasi Status Jalan</label>
                            <select class="form-control" id="status" name="status">
                                <option>Rusak</option>
                                <option>Tidak Rusak</option>
                                <option>Diperbaiki</option>
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


</body>





<?php require_once("TemplateMap/footer.php"); ?>



<!-- INISIASI DATA -->

<script>
    const main_url = "<?= base_url(); ?>";
</script>

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
        // shadowSize:   [50, 64], // size of the shadow
        // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        // shadowAnchor: [4, 62],  // the same for the shadow
        // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
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
        console.log(map.getZoom());
        if (map.getZoom() == maxZoom) {
            for (var i = 0; i < a.layer._markers.length; i++) {
                console.log(a.layer._markers[i].options.locationid);
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
            // navigator.geolocation.getCurrentPosition(getPosition);
            navigator.geolocation.watchPosition(getPosition, error, options);
        }, 3000);
    }


    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }

    var markerUser, circle, latdevice, longdevice, controlRouting;

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



    controlRouting = L.Routing.control({
        waypoints: [

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






    // That's where Open Source Routing Machine -- or OSRM -- comes in. OSRM is a route planning system that runs on OpenStreetMap, a free crowdsourced mapping service. And, yes, it too is open source, meaning anyone can use and modify it for free.
</script>
<!-- TUTUP MARKER CLUSTER -->





</html>