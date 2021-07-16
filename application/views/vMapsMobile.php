<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- BODY HTML -->

<body id="page-top">
    <div class="container-sm">
        <select class="custom-select custom-select-sm fixed-top" name="selectoption" id="selectoption">
            <option selected>Pilih tampil data</option>
            <option value="1">Jalan Rusak Terverifikasi</option>
            <option value="2">Jalan Rusak Belum Terverifikasi</option>
            <option value="3">Jalan Tidak Rusak Terverifikasi</option>
            <option value="4">Jalan yang Diperbaiki</option>
        </select>
    </div>
    <div id="map"></div>

    <!-- Modal untuk mengubah status jalan -->
    <div class="modal" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kondisi Jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <input type="text" class="form-control" id="status" name="status" aria-describedby="emailHelp" value="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Verifikasi</label>
                        <input type="text" class="form-control" id="verifikasi" name="verifikasi" aria-describedby="emailHelp" value="" disabled>
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <img class="mx-auto d-block" src="" width="400px" id="img" alt="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

</body>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->




<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- FOOTER UNTUK LOAD JAVASCRIPT -->
<?php require('TemplateMap/footer.php'); ?>
<!-- -------------------------------------------------------------------------------------------------------------------------- -->





<!-- -------------------------------------------------------------------------------------------------------------------------- -->
<!-- CORE TEMPAT OPERASI DAN METHOD -->


<!-- GENERAL FUNCTION -->
<script type="text/javascript">
    //event untuk select option
    $('select').on('change', function() {
        // alert("haha");
        var id_select = this.value;
        window.location.replace(main_url + "maps/petadigital/" + id_select);
    });
</script>



<!-- MARKER CLUSTER DATA -->
<script type="text/javascript">
    // memanggil data jalan rusak dari database
    var addressPoints = <?php echo json_encode($data_jalan_rusak); ?>;
    //markers untuk marker cluster
    var markers = L.markerClusterGroup({
        spiderfyOnMaxZoom: false
    });
    var markers2 = L.markerClusterGroup({
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

            // //untuk membuka popup
            $('#myModal').modal('show');
            document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
            document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
            document.getElementById('img').src = main_url + a.sourceTarget._markers[0].options.img_path;
        }
    });

    // ini adalah marker cluster, datanya dari addres point
    for (var i = 0; i < addressPoints.length; i++) {
        var a = addressPoints[i];
        var locationid = a[0];
        var status = a[3];
        var img_path = a[4];
        var verifikasi = a[5];
        if (verifikasi == 1) {
            verifikasi = "Terverifikasi"
        } else {
            verifikasi = "Belum Terverifikasi"
        }
        var marker = L.marker(new L.LatLng(a[1], a[2]), {
            locationid: locationid,
            status: status,
            img_path: img_path,
            verifikasi: verifikasi
        });

        marker.on("click", function(a) {
            $('#myModal').modal('show');
            document.getElementById('status').value = status;
            document.getElementById('verifikasi').value = verifikasi;
            document.getElementById('img').src = main_url + img_path;
        })
        markers.addLayer(marker);
    }

    // ada perbedaan antara marker dan markers, markers pada markercluster 
    map.addLayer(markers);
</script>


<!-- HEIGHTGRAPH CODE -->
<script type="text/javascript">
    var data_altitude = <?php echo json_encode($data_altitude); ?>;
    var final_altitude = [];
    for (let i = 0; i < data_altitude.length; i++) {
        final_altitude.push([data_altitude[i][1], data_altitude[i][0], data_altitude[i][2]]);
    }

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
            "records": 1,
            "summary": "surface",
            "label": "Surface"
        }
    }];
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/heightgraph.js">
</script>




<!-- UPHILL ROAD -->
<script>
    var dataJalanMenanjak = <?php echo json_encode($data_jalan_menanjak); ?>;
    for (let i = 0; i < dataJalanMenanjak.length; i++) {
        var polylinePoints = [
            [dataJalanMenanjak[i][1], dataJalanMenanjak[i][2]],
            [dataJalanMenanjak[i][3], dataJalanMenanjak[i][4]],
        ];


        var iqbal = L.Routing.control({
            waypoints: polylinePoints,
            lineOptions: {
                styles: [{
                    color: 'orange',
                    opacity: 10,
                    weight: 5
                }]
            }
        });
        iqbal.addTo(map);
        iqbal.hide();
    }
</script>


</html>