class MarkerclusterClass {
    constructor(titik_koordinat){
        this.titik_koordinat = titik_koordinat;

        this.markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });

        this.markers2 = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });

        this.set_cluster_click();

        this.set_cluster_data();       
        
        this.add_layer();
    }

    set_cluster_click(){
        return this.markers.on('clusterclick', function(a) {
            var locationIdMarkers = new Array();
    
            if (object_leaflet.map.getZoom() == object_leaflet.max_zoom) {
                for (var i = 0; i < a.layer._markers.length; i++) {
                    locationIdMarkers.push(a.layer._markers[i].options.locationid);
                }
                // //untuk membuka popup menampilkan data
                $('#myModal').modal('show');
                document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
                document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
                document.getElementById('img').src = object_leaflet.main_url + a.sourceTarget._markers[0].options.img_path;
            }
        });
    }

    set_cluster_data(){
        for (var i = 0; i < this.titik_koordinat.length; i++) {
            var a = this.titik_koordinat[i];
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
                document.getElementById('img').src = object_leaflet.main_url + img_path;
            })
            this.markers.addLayer(marker);
        }
    }

    add_layer(){
        object_leaflet.map.addLayer(this.markers);
    }
}