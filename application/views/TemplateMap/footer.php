<!-- Bootstrap core JavaScript-->
<script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>



<!-- LOADER LEAFLET PLUGIN -->
<!-- MARKERCLUSTER -->
<script src="<?= base_url(); ?>/assets/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster-src.js"></script>
<!-- ROUTING MACHINE -->
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<!-- EASY BUTTON -->
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
<!-- VARIABEL GLOBAL -->
<script src="<?= base_url(); ?>/assets/js/LeafletClass.js"></script>
<script src="<?= base_url(); ?>/assets/js/MarkerclusterClass.js"></script>
<script src="<?= base_url(); ?>/assets/js/UphillClass.js"></script>

<!-- INISIASI LEAFLET-->
<script type="text/javascript">
    const main_url = "<?= base_url(); ?>";
    var object_leaflet = new LeafletClass(main_url);
    // const map = object_leaflet.map;


    // global variabel
    var id, target, featureGroup, options, markerUser, circle, latdevice, longdevice, latcurrentdevice, longcurrentdevice, accuracy;
    var controlRouting;

    // perulangan untuk membuat outline masing-masing kecamatan
    for (let i = 0; i < object_leaflet.data_kecamatan.length; i++) {
        //mengambil geojson dari assets
        $.getJSON(main_url + "/assets/GeoJSON/" + object_leaflet.data_kecamatan[i] + ".geojson", function(data) {
            geoLayer = L.geoJson(data, {
                style: function(feature) {
                    return {
                        color: object_leaflet.data_warna[i],
                    }
                }
            }).addTo(object_leaflet.map);
        });
    }


    // durasi alert
    var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);
</script>