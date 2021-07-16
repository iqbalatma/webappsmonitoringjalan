<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- BODY HTML -->

<body id="page-top">
    <?php if (!empty($this->session->flashdata('msg'))) {
        echo $this->session->flashdata('msg');
    }; ?>
    <?php if (!empty($this->session->flashdata('msgUphill'))) {
        echo $this->session->flashdata('msgUphill');
    }; ?>
    <div id="map"></div>

    <!-- Modal untuk mengubah status jalan -->
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk menambah titik jalan rusak oleh surveyor -->
    <div class="modal" tabindex="-1" id="modalTambahTitik">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Titik Jalan Rusak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url(); ?>/Maps/add" method="POST" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="token" id="token" value="<?= $token; ?>" />
                        <input type="hidden" name="latitude" id="latitude" value="" />
                        <input type="hidden" name="longitude" id="longitude" value="" />
                        <input type="hidden" name="kecamatan" id="kecamatan" value="" />
                        <div class="form-group">
                            <label for="exampleFormControlSelect1"> Status Jalan</label>
                            <select class="form-control" id="status" name="status">
                                <option>Rusak</option>
                                <option>Diperbaiki</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Gambar</label>
                            <input type="file" class="form-control-file" id="image_upload" name="image_upload">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal konfirmasi up -->
    <div class="modal" tabindex="-1" id="modalKonfirmasiUp">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Titik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?= base_url(); ?>/Maps/titikmenanjak" method="POST" enctype='multipart/form-data'>
                    <input type="hidden" name="lat" id="lat" value="">
                    <input type="hidden" name="lng" id="lng" value="">
                    <input type="hidden" name="posisi" id="posisi" value="">
                    <input type="hidden" name="token" id="token" value="<?= $token; ?>" />
                    <div class="modal-body">
                        <p>Apakah anda yakin ini adalah titik tertinggi/terendah jalan menanjak ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->

<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- FOOTER UNTUK LOAD JAVASCRIPT -->
<?php require("TemplateMap/footer.php"); ?>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->



<!-- VARIABEL GLOBAL -->
<script>
    // MENAMBAHKAN BUTTON
    L.easyButton('fa fa-caret-up', function(btn, map) {
        $('#modalKonfirmasiUp').modal('show');
        document.getElementById('lat').value = latdevice;
        document.getElementById('lng').value = longdevice;
        document.getElementById('posisi').value = "tertinggi";
    }).addTo(map);
    L.easyButton('fa fa-caret-down', function(btn, map) {
        $('#modalKonfirmasiUp').modal('show');
        document.getElementById('lat').value = latdevice;
        document.getElementById('lng').value = longdevice;
        document.getElementById('posisi').value = "terendah";
    }).addTo(map);
    L.easyButton('fa fa-map-marker', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
    }).addTo(map);
    L.easyButton('fa fa-camera', function(btn, map) {
        map.fitBounds(featureGroup.getBounds());
        $('#modalTambahTitik').modal('show');
        // console.log(latdevice + " - " + longdevice);
        document.getElementById('latitude').value = latdevice;
        document.getElementById('longitude').value = longdevice;


        var xmlhttp = new XMLHttpRequest();
        var url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=pjson&featureTypes=&location=" + longdevice + "%2C" + latdevice;


        var kecamatan;
        var ajax = new XMLHttpRequest();
        ajax.open("GET", url, true);
        ajax.send();
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                kecamatan = this.response;
                kecamatan = JSON.parse(kecamatan);
                kecamatan = kecamatan.address.City;
                document.getElementById('kecamatan').value = kecamatan;
            }
        };







        // https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/reverseGeocode?f=pjson&featureTypes=&location=108.97321338%2C1.06320954
    }).addTo(map);
</script>




<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    //NOTE :  ADA PERBEDAAN antara marker dan markers, markers pada markercluster 

    // address point didapat dari db
    var addressPoints = <?php echo json_encode($data_jalan_rusak); ?>;;
    // markers untuk cluster
    var markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: false
    });

    //ini adalah on click ketika marker cluster di klik
    markers.on('clusterclick', function(a) {
        var locationIdMarkers = new Array();
        if (map.getZoom() == maxZoom) {
            for (var i = 0; i < a.layer._markers.length; i++) {
                locationIdMarkers.push(a.layer._markers[i].options.locationid);
            }
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

        marker.on("click", function(a) {
            $('#myModal').modal('show');
            document.getElementById('idlocation').value = locationid;
        })

        markers.addLayer(marker);
    }
    map.addLayer(markers);
</script>
<!-- TUTUP MARKER CLUSTER -->


<!-- LOCATION DEVICE -->
<script type="text/javascript">
    // Option geolocation
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
            // navigator.geolocation.getCurrentPosition(getPosition); //untuk get current 
            navigator.geolocation.watchPosition(getPosition, geoerror, options);
        }, 1000);
    }



    function getCurrentPosition(position) {
        latcurrentdevice = position.coords.latitude
        longcurrentdevice = position.coords.longitude
    }

    // set marker on response position
    function getPosition(position) { //fungsinya dipanggil sebagai parameter watchposition
        // menyimpan latitude dan longitude kedalam variabel
        latdevice = position.coords.latitude
        longdevice = position.coords.longitude
        accuracy = position.coords.accuracy

        // untuk membuang marker sebelum menambahkan marker lainnya
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
        featureGroup = L.featureGroup([markerUser, circle]).addTo(map);
    }
</script>
<!-- TUTUP LOCATION DEVICE -->



<!-- ROUTING MACHINE -->
<script type="text/javascript">
    controlRouting = L.Routing.control({
        waypoints: [
            L.latLng(latcurrentdevice, longcurrentdevice),
        ]
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
</script>
<!-- TUTUP ROUTING MACHINE -->


</html>