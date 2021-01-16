<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.0.1/css/ol.css" type="text/css">
	<style>
	.map {height: 400px; width: 100%;}
	.ol-attribution.ol-logo-only,
	.ol-attribution.ol-uncollapsible {
		max-width: calc(100% - 3em) !important;
		height: 1.5em !important;
	}

	.ol-control button,
	.ol-attribution,
	.ol-scale-line-inner {
		font-family: 'Lucida Grande', Verdana, Geneva, Lucida, Arial, Helvetica, sans-serif !important;
	}

	.ol-popup {
		font-family: 'Lucida Grande', Verdana, Geneva, Lucida, Arial, Helvetica, sans-serif !important;
		font-size: 12px;
		position: absolute;
		background-color: white;
		-webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
		filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
		padding: 15px;
		border-radius: 10px;
		border: 1px solid #cccccc;
		bottom: 12px;
		left: -50px;
		min-width: 100px;
	}

	.ol-popup:after,
	.ol-popup:before {
		top: 100%;
		border: solid transparent;
		content: " ";
		height: 0;
		width: 0;
		position: absolute;
		pointer-events: none;
	}

	.ol-popup:after {
		border-top-color: white;
		border-width: 10px;
		left: 48px;
		margin-left: -10px;
	}

	.ol-popup-closer:after {
        content: "✖";
				position: absolute;
			 top: 3px;
			 right: 2px;
			 font-size: 100%;
			 color: #0088cc;
			 text-decoration: none;
      }

	.ol-popup:before {
		border-top-color: #cccccc;
		border-width: 11px;
		left: 48px;
		margin-left: -11px;
		</style>
		<script
		src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.0.1/build/ol.js"></script>
		<title>Smart Local Bank Office</title>
		</head>
		<body>
		<div id="map" class="map"></div>
		<div id="popup" class="ol-popup">
		<a href="#" id="popup-closer" class="ol-popup-closer"></a>
		<div id="popup-content"></div>
		</div>
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js"></script>


		<script type="text/javascript">

		//https://openstreetmap.be/en/projects/howto/openlayers.html
		var stroke = new ol.style.Stroke({color: 'yellow', width: 4});
		var fill = new ol.style.Fill({color: 'red'});
		var styles = {'square': new ol.style.Style({ image: new ol.style.RegularShape({ fill: fill, stroke: stroke,
			points: 4,radius: 10,angle: Math.PI / 4})}),
			'triangle': new ol.style.Style({ image: new ol.style.RegularShape({
				fill: fill,stroke: stroke, points: 3, radius: 10, rotation: Math.PI / 4, angle: 0 }) }),
				'star': new ol.style.Style({image: new ol.style.RegularShape({ fill: fill, stroke: stroke,
					points: 5, radius: 10, radius2: 4, angle: 0 }) }),
					'cross': new ol.style.Style({ image: new ol.style.RegularShape({ fill: fill, stroke: stroke, points: 4, radius: 10,
						radius2: 0, angle: 0 }) }),
						'x': new ol.style.Style({ image: new ol.style.RegularShape({ fill: fill, stroke: stroke, points: 4, radius: 10,
							radius2: 0, angle: Math.PI / 4 }) }) };
							var vectorSource = new ol.source.Vector();
							var map = new ol.Map({ target: 'map', layers: [ new ol.layer.Tile({ source: new ol.source.OSM() }) ,
							new ol.layer.Vector({source : vectorSource})],
							view: new ol.View({ center: ol.proj.fromLonLat([<?php
								$file = 'myLastLocation.txt';
								$lines = file($file);
								echo end($lines);
								?>]), zoom: 15 }) });



									jQuery(document).ready(function($){
										resp = $("#response");
										$.ajax({
											type: "POST", // Method type GET/POST
											url: "data1.php", //Ajax Action url
											dataType:"json",

											// Before call ajax you can do activity like please wait message
											beforeSend: function(xhr){
												resp.html("Please wait...");
												},

												//Will call if method not exists or any error inside php file
												error: function(qXHR, textStatus, errorThrow){
													resp.html("There are an error");
													},

													success: function(data, textStatus, jqXHR){
														// resp.html(data);
														var i;

														var Feature=[];

														for(i=0;i<data.length;i++){
															Feature[i]=new ol.Feature({timestamp:data[i].Time,geometry: new ol.geom.Point(ol.proj.fromLonLat([data[i].Longitude,data[i].Latitude]))});

															Feature[i].setStyle(styles["star"]);
															vectorSource.addFeature(Feature[i]);


														}
														var container = document.getElementById('popup');
														var content = document.getElementById('popup-content');
														var closer = document.getElementById('popup-closer');

														var overlay = new ol.Overlay({
															element: container,
															autoPan: true,
															autoPanAnimation: {
																duration: 250
															}
															});

															map.addOverlay(overlay);

															closer.onclick = function() {
																overlay.setPosition(undefined);
																closer.blur();
																return false;
															};



																	map.on('singleclick', function (event) {

																		if (map.hasFeatureAtPixel(event.pixel) === true) {
																			var coordinate = event.coordinate;
																			var feature = map.getFeaturesAtPixel(event.pixel)[0];

																			var t=feature.get('timestamp');

																			content.innerHTML = '<b>Car ID 1</b><br/><code>'+t+'</code>';
																			overlay.setPosition(coordinate);
																			} else {
																				closer.blur();
																			}
																			});


																}
																});
																});

																	</script>
																	</body>
</html>
