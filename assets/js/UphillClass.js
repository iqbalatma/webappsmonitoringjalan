class UphillClass{
    constructor(data_jalan_menanjak){
        this.data_jalan_menanjak = data_jalan_menanjak;
       
        
        this.uphill_road_control = L.Routing.control({
            fitSelectedRoutes: false,
            waypoints: polylinePoints,
            routeWhileDragging: true,
            lineOptions: {
                styles: [{
                    color: 'orange',
                    opacity: 10,
                    weight: 5
                }]
            },
            createMarker: function(i, wp, nWps) {
                if (i === 0) {
                    return L.marker(wp.latLng, {
                        icon: object_leaflet.jalan_tertinggi
                    });
                } else {
                    return L.marker(wp.latLng, {
                        icon: object_leaflet.jalan_terendah
                    });
                }
            }
        });


    }




}



