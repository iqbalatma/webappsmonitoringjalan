var el = L.control.elevation({
    position: "topright",
  theme: "steelblue-theme", //default: lime-theme
  width: 600,
  height: 125,
  margins: {
      top: 10,
      right: 20,
      bottom: 30,
      left: 50
  },
  useHeightIndicator: true, //if false a marker is drawn at map position
  interpolation: d3.curveLinear, //see https://github.com/d3/d3-shape/blob/master/README.md#area_curve
  hoverNumber: {
      decimalsX: 3, //decimals on distance (always in km)
      decimalsY: 0, //deciamls on hehttps://www.npmjs.com/package/leaflet.coordinatesight (always in m)
      formatter: undefined //custom formatter function may be injected
  },
  xTicks: undefined, //number of ticks in x axis, calculated by default according to width
  yTicks: undefined, //number of ticks on y axis, calculated by default according to height
  collapsed: false,  //collapsed mode, show chart on click or mouseover
  imperial: false    //display imperial units instead of metric
});
el.addTo(map);
L.geoJson(geojson,{
  onEachFeature: el.addData.bind(el) //working on a better solution
}).addTo(map);



var bounds = new L.LatLngBounds(new L.LatLng(1.3616249584528899, 109.29709640235558), new L.LatLng(0.9165615430242643, 108.98319511044375));


		var el = L.control.elevation();
		el.addTo(map);
		var gjl = L.geoJson(geojson,{
		    onEachFeature: el.addData.bind(el)
		}).addTo(map);

		map.addLayer(service).fitBounds(bounds);
