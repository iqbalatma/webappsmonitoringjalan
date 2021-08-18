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

        this.service = new L.TileLayer(this.map_tiler, {
            subdomains: "1234",
            attribution: this.map_atribut
        });
    


        this.inisiasi_map();
        
    }

    inisiasi_map(){
        this.service;
        this.display_group;
        

        return L.tileLayer(this.map_tiler, {
            attribution: this.map_atribut,
            maxZoom: this.max_zoom
        }).addTo(this.map);
    }

  

    get_data_warna(index){
        return this.data_warna[index];
    }

    create_button(label, container){
        var btn = L.DomUtil.create('button', '', container);
        btn.setAttribute('type', 'button');
        btn.innerHTML = label;
        return btn;
    }

    

    geoerror() {
        // console.warn('ERROR(' + err.code + '): ' + err.message);
    }
}






