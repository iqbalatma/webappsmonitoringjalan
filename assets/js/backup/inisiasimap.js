
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



    const map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 9);
    const url = 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=YuJOaTSiwRyG08KX8Bj9';
    const attr = '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors' +
    ', Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>'
    service = new L.TileLayer(url, {subdomains:"1234",attribution: attr});
    const displayGroup = new L.LayerGroup()
    displayGroup.addTo(map)
    
    L.tileLayer(url, {
        attribution: attr,
        maxZoom: 18
    }).addTo(map);



    if(!navigator.geolocation.getCurrentPosition){
        console.log("Browser tidak support");
    }else{
        navigator.geolocation.getCurrentPosition(getPosition);
    }


    function getPosition(position){
        console.log(position)
    }


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

                //bid untuk memanggil nama kecamatan ketika diklik
                geoLayer.eachLayer(function(layer) {
                    layer.bindPopup(dataKecamatan[i])
                })

            });
        }

   
        // function onLocationFound(e) {
        //     var radius = e.accuracy / 2;
        //     L.marker(e.latlng).addTo(map)
        //       .bindPopup("You are within " + radius + " meters from this point").openPopup();
        //     L.circle(e.latlng, radius).addTo(map);
        //   }
          
        //   map.on('locationfound', onLocationFound);
        //   map.locate({setView: true, watch: true, maxZoom: 8});