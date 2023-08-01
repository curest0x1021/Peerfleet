$.fn.simulateClick = function () {
  return this.each(function () {
    var doc, evt;
    if ("createEvent" in document) {
      doc = this.ownerDocument;
      evt = doc.createEvent("MouseEvents");
      evt.initMouseEvent("click", true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
      this.dispatchEvent(evt);
    } else {
      this.click();
    }
  });
};

function initMap () {
  var center,
    clickLinkElement,
    dataIds,
    f,
    geoDataCleaned,
    geoFeatures,
    geoLayers,
    geojson,
    highlightFeature,
    k,
    map,
    mapOptions,
    onEachFeature,
    resetHighlight,
    style,
    geoDataCleaned = {
      type: "FeatureCollection",
      features: [],
    };
  dataIds = [];
  $("a[data-id]").each(function () {
    return dataIds.push($(this).attr("data-id"));
  });

  for (k in geoData.features) {
    f = geoData.features[k];
    if (dataIds.indexOf(f.id) > -1) {
      geoDataCleaned.features.push(f);
    }
  }

  center = [20, 0];
  geojson = null;
  geoFeatures = [];
  geoLayers = [];

  $("a[data-id]").hover(
    function () {
      if (geoLayers[$(this).attr("data-id")]) {
        highlightFeature(null, geoLayers[$(this).attr("data-id")]);
      }
    },
    function () {
      if (geoLayers[$(this).attr("data-id")]) {
        resetHighlight(null, geoLayers[$(this).attr("data-id")]);
      }
    }
  );
  highlightFeature = function (e, layer) {
    var dataId;
    if (e && e.target) {
      layer = e.target;
      dataId = e.target.feature.id;
      if ($('a[data-id="' + dataId + '"]').length <= 0) {
        return;
      }
    }
    layer.setStyle({
      weight: 5,
      color: "#ffffff",
      opacity: 1,
      dashArray: "",
      fillOpacity: 0.7,
    });
    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
      layer.bringToFront();
    }
  };
  resetHighlight = function (e, layer) {
    if (e && e.target) {
      layer = e.target;
    }
    geojson.resetStyle(layer);
  };
  clickLinkElement = function (e) {
    var dataId;
    dataId = e.target.feature.id;
    $('a[data-id="' + dataId + '"]').simulateClick();
  };
  onEachFeature = function (feature, layer) {
    geoFeatures[feature.id] = feature;
    geoLayers[feature.id] = layer;
    layer.on({
      mouseover: highlightFeature,
      mouseout: resetHighlight,
      click: clickLinkElement,
    });
  };
  mapOptions = {
    maxBounds: L.latLngBounds(L.latLng(-70, -180), L.latLng(75, 180)),
    gestureHandling: true
  };
  map = L.map("map", mapOptions).setView(center, 2);
  L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
    maxZoom: 17,
    minZoom: 2,
    // id: "mapbox/streets-v11",
    id: "mapbox/navigation-night-v1",
    tileSize: 512,
    zoomOffset: -1,
    accessToken: "pk.eyJ1IjoibWFyYzkyNyIsImEiOiJjbGtzMWJlZ2cwdnJlM2dwbnFia3M4bnRoIn0.Y_b3jtNbkzSLTjZUIczd8g"
      // "pk.eyJ1IjoiY2hlbi1tYXJpdGltZWRhdGFzeXN0ZW1zLWNvbSIsImEiOiJjajNlNjduMzkwMHBhMzFzMjJnMGlpZmhvIn0.buGEUU37tesHnaWbKZET1A",
  }).addTo(map);
  style = {
    fillColor: "#ffffff",
    weight: 2,
    opacity: 0.5,
    color: "#ffffff",
    dashArray: "5",
    fillOpacity: 0,
  };

  geojson = L.geoJson(geoDataCleaned, {
    style: style,
    onEachFeature: onEachFeature,
  }).addTo(map);
};
