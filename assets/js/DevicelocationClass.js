class DevicelocationClass{
    constructor(){
        this.jarak_terpendek = false;

        this.marker_user;

        this.circle;

        this.latdevice;

        this.longdevice;

        this.accuracy;

        this.feature_group;

        this.get_device_location();

    }

    get_options(){
        return options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };
    }
    
    get_device_location(){
        if (!navigator.geolocation.getCurrentPosition) {
            console.log("Browser tidak support");
        } else {
            setInterval(() => {
                navigator.geolocation.watchPosition(this.get_position(), this.geoerror(), this.get_options);
            }, 1000);
        }
    }

    get_position(position){
        console.log(position)
            // this.latdevice = position.coords.latitude
            // this.longdevice = position.coords.longitude
            // console.log(this.latdevice);
            // this.accuracy = position.coords.accuracy
            // if (this.markerUser) {
            //     object_leaflet.map.removeLayer(this.marker_user)
            // }
            // if (this.circle) {
            //     object_leaflet.map.removeLayer(this.circle)
            // }

            // $("#alert-jarak").hide();
    
            // this.marker_user = L.marker([this.latdevice, this.longdevice], {
            //     icon: object_leaflet.user_device_location
            // });
            // this.circle = L.circle([this.latdevice, this.longdevice], {
            //     radius: 20
            // });
    
            // this.feature_group = L.featureGroup([this.marker_user, this.circle]).addTo(object_leaflet.map);
    
            // // console.log("ho")
            // if (titikJalanRusakFinal.length == 0) {
            //     // ketika user belum menentukan titik rute maka titik jalan rusak yang dilalui akan kosong
            //     console.log("Titik jalan rusak tidak ada")
            // } else {
            //     // Ketika rute ditemukan dan terdapat jalan rusak pada rute tersebut
            //     //cari dulu jarak terpendek dari titik user baru tampilkan alert
            //     var index;
            //     for (let i = 0; i < titikJalanRusakFinal.length; i++) {
            //         jarak = this.distance(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1], latdevice, longdevice, "M");
            //         if (this.jarak_terpendek == false) { //berarti jarak terpendek belum di set
            //             this.jarak_terpendek = jarak
            //             index = i;
            //         } else { //kalau jarak terpendek sudah diset, maka selanjutnya adalah membandingkan jarak di variabel dengan di looping
            //             if (this.jarak_terpendek > jarak) { //jika jarak terpendek lebih besar dari jarak, berarti jarak terbaru tersebut merupakan jarak lebih pendek, simpan ke variabel
            //                 this.jarak_terpendek = jarak
            //                 index = i;
            //             }
            //         }
            //     }
    
    
            //     console.log(this.jarak_terpendek);
    
    
            //     if (this.jarak_terpendek < 100) {
            //         $("#alert-jarak").html("Hati-hati ! " + parseFloat(this.jarak_terpendek).toFixed(2) + " m ada jalan berlubang");
            //         $("#alert-jarak").show();
            //         if (this.jarak_terpendek < 5) {
            //             console.log("pemotongan tereksekusi");
            //             titikJalanRusakFinal.splice(index, 1)
            //         }
            //     }
            //     this.jarak_terpendek = false;
            // }
        
    }


    
    geoerror(){

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
}