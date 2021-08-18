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
<script src="<?= base_url(); ?>/assets/js/globalinisiasi.js"></script>
<script src="<?= base_url(); ?>/assets/js/LeafletClass.js"></script>

<!-- GLOBAL INISIASI -->
<script type="text/javascript">
    const main_url = "<?= base_url(); ?>";
    var object_leaflet = new LeafletClass(main_url);
    const map = object_leaflet.get_map;
    object_leaflet.get_display_group

    // global variabel
    var id, target, featureGroup, options, markerUser, circle, latdevice, longdevice, latcurrentdevice, longcurrentdevice, accuracy;
    var controlRouting;

    // durasi alert
    var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);






    // membuat button untuk ketika map diklik
    function createButton(label, container) {
        var btn = L.DomUtil.create('button', '', container);
        btn.setAttribute('type', 'button');
        btn.innerHTML = label;
        return btn;
    }

    //fungsi ketika geolocation error
    function geoerror(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }

    // FUNGSI UNTUK MENGHITUNG JARAK DUA TITIK KOORDINATE, DENGAN UNIT M UNTUK SATUAN METER, unit M untuk satuan meter
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
</script>