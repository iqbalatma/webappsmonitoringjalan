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

<!-- GLOBAL INISIASI -->
<script type="text/javascript">
    // main url untuk pemanggilan lintas bahasa
    const main_url = "<?= base_url(); ?>";

    // global variabel
    var id, target, featureGroup, options, markerUser, circle, latdevice, longdevice, latcurrentdevice, longcurrentdevice, accuracy;
    var controlRouting;

    // durasi alert
    var timeout = 3000; // in miliseconds (3*1000)
    $('.alert').delay(timeout).fadeOut(300);

    //maxzoom pada peta, dibatasi sampai 16
    var maxZoom = 17;

    // untuk mengcustom marker device location
    var userDeviceLocationIcon = L.icon({
        iconUrl: main_url + 'assets/js/userDeviceLocation.png',
        iconSize: [30, 30], // size of the icon
    });
    //untuk memanggil geosjon kecamatan
    var dataKecamatan = [
        "selakau", "salatiga", "sambas", "pemangkat", "tebas", "galing", "subah", "telukkeramat", "selakautimur", "tekarang", "jawai", "jawaiselatan", "semparuk", "sebawi", "paloh", "sajad", "sejangkung", "tangaran", "sajinganbesar"
    ];
    //untuk memisahkan area outline dengan masing-masing warna
    var dataWarna = [
        "#8ec07c",
        "#fb4934",
        "#0ff1ce",
        "#003366",
        "#b5b4e5",

        "#99cccc",
        "#fe8019",
        "#f9dada",
        "#693a7c",
        "#a9dcd6",

        "#abeeaa",
        "#420420",
        "#5ac18e",
        "#fabd2f",
        "#83a598",
        "#0072e0",
    ]
    //untuk memanggil geosjon kecamatan
    var dataKecamatan = [
        "selakau", "salatiga", "sambas", "pemangkat", "tebas", "galing", "subah", "telukkeramat", "selakautimur", "tekarang", "jawai", "jawaiselatan", "semparuk", "sebawi", "paloh", "sajad", "sejangkung", "tangaran", "sajinganbesar"
    ];
    //untuk memisahkan area outline dengan masing-masing warna
    var dataWarna = [
        "#8ec07c", "#fb4934", "#0ff1ce", "#003366", "#b5b4e5", "#99cccc", "#fe8019", "#f9dada", "#693a7c", "#a9dcd6", "#abeeaa", "#420420", "#5ac18e", "#fabd2f", "#83a598", "#0072e0",
    ]
    //inisiasi map
    const map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 9);
    const url = 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=YuJOaTSiwRyG08KX8Bj9';
    const attr = '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors' +
        ', Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>'
    service = new L.TileLayer(url, {
        subdomains: "1234",
        attribution: attr
    });
    const displayGroup = new L.LayerGroup();
    displayGroup.addTo(map);
    L.tileLayer(url, {
        attribution: attr,
        maxZoom: maxZoom
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