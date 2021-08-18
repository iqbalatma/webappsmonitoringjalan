class MarkerclusterClass {
<<<<<<< HEAD
    constructor(titik_koordinat, jenis = ""){
=======
    constructor(titik_koordinat){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
        this.titik_koordinat = titik_koordinat;

        if(jenis == "deteksi"){
            this.markers = L.markerClusterGroup({
                spiderfyShapePositions: function(count, centerPt) {
                    var distanceFromCenter = 35,
                        markerDistance = 45,
                        lineLength = markerDistance * (count - 1),
                        lineStart = centerPt.y - lineLength / 2,
                        res = [],
                        i;
        
                    res.length = count;
        
                    for (i = count - 1; i >= 0; i--) {
                        res[i] = new Point(centerPt.x + distanceFromCenter, lineStart + markerDistance * i);
                    }
                    return res;
                }
            });
        }else{
            this.markers = L.markerClusterGroup({
                spiderfyOnMaxZoom: false
            });
        }


<<<<<<< HEAD
        this.set_cluster_click(jenis);

        this.set_cluster_data(jenis);
=======
        this.markers2 = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });

        this.set_cluster_click();
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)

        this.set_cluster_data();       
        
        this.add_layer();
    }

<<<<<<< HEAD
    set_cluster_click(jenis){
=======
    set_cluster_click(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
        return this.markers.on('clusterclick', function(a) {
            var locationIdMarkers = new Array();
    
            if (object_leaflet.map.getZoom() == object_leaflet.max_zoom) {
                for (var i = 0; i < a.layer._markers.length; i++) {
                    locationIdMarkers.push(a.layer._markers[i].options.locationid);
                }
                // //untuk membuka popup menampilkan data
<<<<<<< HEAD
                if(jenis == "edit"){
                    $('#myModal').modal('show');
                    document.getElementById('idlocation').value = locationIdMarkers;
                    console.log("ini cluster edit"); //warning
                }else{
                    console.log("ini cluster peta"); //warning
                    $('#myModal').modal('show');
                    document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
                    document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
                    document.getElementById('img').src = object_leaflet.main_url + a.sourceTarget._markers[0].options.img_path;
                }
=======
                $('#myModal').modal('show');
                document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
                document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
                document.getElementById('img').src = object_leaflet.main_url + a.sourceTarget._markers[0].options.img_path;
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
            }
        });
    }

<<<<<<< HEAD
    set_cluster_data(jenis){
=======
    set_cluster_data(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
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
<<<<<<< HEAD

            if(jenis == "deteksi"){
                marker.bindPopup(status);
            }else{
                marker.on("click", function(a) {
                    $('#myModal').modal('show');
                    if(jenis=="edit"){
                        document.getElementById('idlocation').value = a.target.options.locationid;
                    }else if(jenis == "deteksi"){
                        
                    }else{
                        document.getElementById('status').value = status;
                        document.getElementById('verifikasi').value = verifikasi;
                        document.getElementById('img').src = object_leaflet.main_url + img_path;
                    }
                })
            }

            
            this.markers.addLayer(marker);
        }
    }


=======
    
            marker.on("click", function(a) {
                $('#myModal').modal('show');
                document.getElementById('status').value = status;
                document.getElementById('verifikasi').value = verifikasi;
                document.getElementById('img').src = object_leaflet.main_url + img_path;
            })
            this.markers.addLayer(marker);
        }
    }
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)

    add_layer(){
        object_leaflet.map.addLayer(this.markers);
    }

}