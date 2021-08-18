class UphillClass{
    constructor(data_jalan_menanjak){
        this.data_jalan_menanjak = data_jalan_menanjak;
        this.set_uphill_marker();
    }

    set_uphill_marker(){
        for (let i = 0; i < this.data_jalan_menanjak.length; i++) {
            var polylinePoints = [
                [this.data_jalan_menanjak[i][1],this.data_jalan_menanjak[i][2]],
                [this.data_jalan_menanjak[i][3],this.data_jalan_menanjak[i][4]],
            ];
    
            var uphillRoadControl = L.Routing.control({
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
            uphillRoadControl.addTo(object_leaflet.map);
            uphillRoadControl.hide();
        }
    }



}



