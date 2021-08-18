class RoutingmachineClass{
    constructor(){
        this.control_routing =  L.Routing.control({
            // fitSelectedRoutes: false,
            useZoomParameter: false,
            waypoints: [
                // L.latLng(lat, long),
            ],
            lineOptions: {
                styles: [{
                    color: 'blue',
                    opacity: 1,
                    weight: 3
                }]
            },
            // autoRoute: true
        }).addTo(object_leaflet.map);


        this.set_on_routing_error();
        this.set_on_route_found();



    }


    set_on_routing_error(){
        this.control_routing.on('routingerror', function(e) {
            console.log(e);
        })
    }

    set_on_route_found(){
        this.control_routing.on('routesfound', function(e) {
            var jalanRusakYangDilalui = [];
            koordinatejalanrusak = JSON.parse(koordinatejalanrusakjson) //dari db
            coordinateFromRoute = e.routes[0].coordinates; //dari rute

    
    
            var lat1, lat2, long1, long2;
            // perulangan untuk mengecek data jalan rusak apda database, berarti perulangan paling luar adalah data pada database
            for (let i = 0; i < koordinatejalanrusak.length; i++) {
                // menyimpan data latitude dan longitude jalan rusak kedalam variabel
                lat1 = koordinatejalanrusak[i]["latitude"];
                long1 = koordinatejalanrusak[i]["longitude"];
                // perulangan terdalam adalah data rute jalan, data cukup banyak hingga ratusan
                for (let j = 0; j < coordinateFromRoute.length; j++) {
                    // menyimpan data latitude dan longitude rute kedalam variabel
                    lat2 = coordinateFromRoute[j]["lat"];
                    long2 = coordinateFromRoute[j]["lng"];
                    // menghitung jarak antar kedua titik
                    jarak = distance(lat1, long1, lat2, long2, "M");
                    // mengecek apakah jaraknya kurang dari 5 meter antara rute dan titik jalan rusak, jika ya kemungkinan rute melalui jalan rusak tersebut
                    if (jarak < 50) {
                        // console.log("haha jaraknya " + jarak)
                        jalanRusakYangDilalui.push([lat1, long1])
                    }
                }
            }
    
    
    
            if (jalanRusakYangDilalui.length > 0) {
                // data jalan rusak yang dilalui sudah didapat tapi masih terdapat data duplicate dan akan difilter dengan kode dibawah
                var jalanRusakYangDilaluiFilteredFirstStep = jalanRusakYangDilalui.filter((t = {}, a => !(t[a] = a in t)));
                //buat variabel untuk data sudah diperiksa jaraknya, jadi kita akan menghapus data titik jalan rusak yang berdekatan
                var jalanRusakYangDilaluiFilteredSecondStep = [];
                //lakukan perulangan pada semua data titik jalan rusak yang telah difilter
                for (let i = 0; i < jalanRusakYangDilaluiFilteredFirstStep.length; i++) {
                    // kalau array data yang jaraknya diperiksa ternyata masih kosong, lakukan push tanpa pengecekan
                    if (jalanRusakYangDilaluiFilteredSecondStep.length == 0) { //kalau arraynya masih kosong, masukkan saja
                        jalanRusakYangDilaluiFilteredSecondStep.push(jalanRusakYangDilaluiFilteredFirstStep[i]);
                    } else { //kalau arraynya tidak kosong, lakukan pengecekan jarak yang akan masuk (perulangan terluar) dan yang ada didalam array (perulangan terdalam)
                        // kalau array tidak kosong, maka data yang sedang dijalankan pada array filtered akan di cocokkan dengan data titik pada array yang jaraknya diperiksa, dengan melakukan perulangan pada array yang jaraknya diperiksa
                        for (let j = 0; j < jalanRusakYangDilaluiFilteredSecondStep.length; j++) {
                            lat1 = jalanRusakYangDilaluiFilteredFirstStep[i][0]; //lat
                            long1 = jalanRusakYangDilaluiFilteredFirstStep[i][1]; //long
                            lat2 = jalanRusakYangDilaluiFilteredSecondStep[j][0]; //lat
                            long2 = jalanRusakYangDilaluiFilteredSecondStep[j][1]; //long
                            jarak = distance(lat1, long1, lat2, long2, "M");
                            // apabila jaraknya lebih dari 100 meter maka titik tersebut akan dianggap sebagai titik lainnya dan akan dipisahkan untuk memberikan notif
                            if (jarak > 100) {
                                jalanRusakYangDilaluiFilteredSecondStep.push(jalanRusakYangDilaluiFilteredFirstStep[i]);
                                break
                            }
                        }
                    }
    
                }
    
    
                titikJalanRusakFinal = jalanRusakYangDilaluiFilteredSecondStep;
                object_leaflet.map.removeLayer(markers);
    
    
    
    
                // UNTUK MENAMBAHKAN TITIK JALAN RUSAK JADI RUTE MERAH
    
                for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                    demo[i] = L.Routing.control({
                        fitSelectedRoutes: false,
                        useZoomParameter: false,
                        waypoints: [
                            L.latLng(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1]),
                            L.latLng(titikJalanRusakFinal[i][0], titikJalanRusakFinal[i][1]),
                        ],
                        lineOptions: {
                            styles: [{
                                color: 'red',
                                opacity: 10,
                                weight: 10
                            }]
                        },
                        createMarker: function() {
                            return null;
                        }
                    })
                    demo[i].addTo(object_leaflet.map);
                    demo[i].hide();
                }
    
    
    
    
    
    
    
            } else {
                //untuk menghapus rute merah dan memasukkan marker
    
                object_leaflet.map.addLayer(markers);
                for (let i = 0; i < titikJalanRusakFinal.length; i++) {
                    demo[i].setWaypoints([
    
                    ]);
                }
    
    
            }
    
    
    
        });
    }
}