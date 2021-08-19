

    var userDeviceLocationIcon = L.icon({
        iconUrl: main_url+'assets/js/userDeviceLocation.png',
    
        iconSize:     [30, 30], // size of the icon
        
    });



    const map = L.map('map').setView([1.3558759194062155, 109.30113044443895], 18);
    const url = 'https://api.maptiler.com/maps/streets/{z}/{x}/{y}@2x.png?key=YuJOaTSiwRyG08KX8Bj9';
    const attr = '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors' +
    ', Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>'
    service = new L.TileLayer(url, {subdomains:"1234",attribution: attr});
    const displayGroup = new L.LayerGroup()
    displayGroup.addTo(map)
    
    L.tileLayer(url, {
        attribution: attr,
        maxZoom: 15
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


    if (!navigator.geolocation.getCurrentPosition) {
        console.log("Browser tidak support");
    } else {
        setInterval(() => {
            // navigator.geolocation.getCurrentPosition(getPosition);
            navigator.geolocation.watchPosition(getPosition, error, options);
        }, 1000);
    }


    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    }

    var markerUser, circle, controlRouting;

    function getPosition(position) {
        console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy
        if (markerUser) {
            map.removeLayer(markerUser)
        }
        if (circle) {
            map.removeLayer(circle)
        }
        map.removeLayer(controlRouting)

        markerUser = L.marker([lat,long], {icon: userDeviceLocationIcon});
        circle = L.circle([lat, long], {
            radius: 20
        });

        var featureGroup = L.featureGroup([markerUser, circle]).addTo(map);
        map.fitBounds(featureGroup.getBounds());


        var latdevice2 = position.coords.latitude
        var longdevice2 = position.coords.longitude
        var accuracy = position.coords.accuracy
        controlRouting = L.Routing.control({
            waypoints: [
                L.latLng(latdevice2, longdevice2),
            ]
        }).addTo(map);
        
    }

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

    
