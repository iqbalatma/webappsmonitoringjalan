    //sampel data, coba ambil dari database
    //contoh titik alamat, ambil dari database
   




    
    var markers = L.markerClusterGroup({
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

    //ini adalah on click ketika marker cluster di klik
    markers.on('clusterclick', function(a) {
        // a.layer is actually a cluster
        console.log('cluster ' + a.layer.getAllChildMarkers().length);
    });

    // ini adalah marker cluster, datanya dari addres point
    for (var i = 0; i < addressPoints.length; i++) {
        var a = addressPoints[i];
        var title = a[2];
        var marker = L.marker(new L.LatLng(a[0], a[1]), {
            title: title
        });
        marker.bindPopup(title);
        markers.addLayer(marker);
    }
    map.addLayer(markers);
