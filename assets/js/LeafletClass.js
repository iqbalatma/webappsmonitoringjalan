class LeafletClass{
    constructor(main_url){
        this.main_url = main_url;
        this.data_kecamatan = [
            "selakau", "salatiga", "sambas", "pemangkat", "tebas", "galing", "subah", "telukkeramat", "selakautimur", "tekarang", "jawai", "jawaiselatan", "semparuk", "sebawi", "paloh", "sajad", "sejangkung", "tangaran", "sajinganbesar"
        ];
        this.max_zoom = 16;
        this.data_warna = [
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
        ];
        this.user_device_location = L.icon({
            iconUrl: this.main_url + 'assets/img/userDeviceLocation.png',
            iconSize: [30, 30], // size of the icon
        });
        this.jalan_tertinggi = L.icon({
            iconUrl: this.main_url + 'assets/img/up.png',
            iconSize: [30, 30]
        });
        this.jalan_terendah = L.icon({
            iconUrl: this.main_url + 'assets/img/down.png',
            iconSize: [30, 30]
        });
        this.map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 9);

        this.map_tiler = 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=YuJOaTSiwRyG08KX8Bj9';

        this.map_atribut = '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors' +
        ', Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>';

        this.display_group = new L.LayerGroup();
        
    }

    

    get_map() {
        return this.map;
    }

    get_atribut(){
        return this.map_atribut;
    }

    get_tiler(){
        return this.map_tiler;
    }

    get_max_zoom(){
        return this.max_zoom;
    }

    get_service(){
        return new L.TileLayer(this.get_tiler(), {
            subdomains: "1234",
            attribution: this.get_atribut()
        });
    }

    get_display_group(){
        return display_group.addTo(this.get_map);
    }

    get_outer_line(){
        for (let i = 0; i < this.data_kecamatan.length; i++) {
            //mengambil geojson dari assets
            $.getJSON(this.main_url + "/assets/GeoJSON/" + this.data_kecamatan[i] + ".geojson", function(data) {
                // L.geoJson function is used to parse geojson file and load on to map
                geoLayer = L.geoJson(data, {
                    style: function(feature) {
                        return {
                            color: this.data_warna[i],
                        }
                    }
                }).addTo(this.get_map());
            });
        }
    }

    create_button(){
        var btn = L.DomUtil.create('button', '', container);
        btn.setAttribute('type', 'button');
        btn.innerHTML = label;
        return btn;
    }

    distance(lat1, lon1, lat2, lon2, unit){
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

    geoerror(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }
}
