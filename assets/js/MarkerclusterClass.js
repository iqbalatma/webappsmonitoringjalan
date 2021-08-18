class MarkerclusterClass {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    constructor(titik_koordinat, jenis = ""){
=======
    constructor(titik_koordinat){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    constructor(titik_koordinat){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    constructor(titik_koordinat){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    constructor(titik_koordinat, edit = false){
>>>>>>> parent of 16469ab (progress deteksi jalan)
        this.titik_koordinat = titik_koordinat;

        this.markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });

<<<<<<< HEAD
<<<<<<< HEAD
        this.set_cluster_click(jenis);

        this.set_cluster_data(jenis);
=======
        this.markers2 = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });

<<<<<<< HEAD
<<<<<<< HEAD
        this.set_cluster_click();
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
        this.markers2 = L.markerClusterGroup({
            spiderfyOnMaxZoom: false
        });
=======
        this.set_cluster_click(edit);

        this.set_cluster_data(edit);
>>>>>>> parent of 16469ab (progress deteksi jalan)

        this.set_cluster_click();
<<<<<<< HEAD
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)

        this.set_cluster_data();       
        
        this.add_layer();
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    set_cluster_click(jenis){
=======
    set_cluster_click(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_click(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_click(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_click(edit = false){
>>>>>>> parent of 16469ab (progress deteksi jalan)
        return this.markers.on('clusterclick', function(a) {
            var locationIdMarkers = new Array();
    
            if (object_leaflet.map.getZoom() == object_leaflet.max_zoom) {
                for (var i = 0; i < a.layer._markers.length; i++) {
                    locationIdMarkers.push(a.layer._markers[i].options.locationid);
                }
                // //untuk membuka popup menampilkan data
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                if(jenis == "edit"){
=======
                if(edit == true){
>>>>>>> parent of 16469ab (progress deteksi jalan)
                    $('#myModal').modal('show');
                    document.getElementById('idlocation').value = locationIdMarkers;
                }else{
                    $('#myModal').modal('show');
                    document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
                    document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
                    document.getElementById('img').src = object_leaflet.main_url + a.sourceTarget._markers[0].options.img_path;
                }
=======
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
                $('#myModal').modal('show');
                document.getElementById('status').value = a.sourceTarget._markers[0].options.status;
                document.getElementById('verifikasi').value = a.sourceTarget._markers[0].options.verifikasi;
                document.getElementById('img').src = object_leaflet.main_url + a.sourceTarget._markers[0].options.img_path;
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
            }
            console.log("ini cluster");
        });
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    set_cluster_data(jenis){
=======
    set_cluster_data(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_data(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_data(){
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
    set_cluster_data(edit){
>>>>>>> parent of 16469ab (progress deteksi jalan)
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
<<<<<<< HEAD
<<<<<<< HEAD


            marker.on("click", function(a) {
                $('#myModal').modal('show');
                if(edit==true){
                    document.getElementById('idlocation').value = a.target.options.locationid;
                }else{
                    document.getElementById('status').value = status;
                    document.getElementById('verifikasi').value = verifikasi;
                    document.getElementById('img').src = object_leaflet.main_url + img_path;
                }
            })
   
            this.markers.addLayer(marker);
        }
    }
<<<<<<< HEAD


=======
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
    
            marker.on("click", function(a) {
                $('#myModal').modal('show');
                document.getElementById('status').value = status;
                document.getElementById('verifikasi').value = verifikasi;
                document.getElementById('img').src = object_leaflet.main_url + img_path;
            })
            this.markers.addLayer(marker);
        }
    }
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
>>>>>>> parent of 02e7be9 (marker cluster edit dan peta digital done)
=======
   
>>>>>>> parent of 16469ab (progress deteksi jalan)

    add_layer(){
        object_leaflet.map.addLayer(this.markers);
    }
}