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

function initMap(companies) {
  var center,
    clickLinkElement,
    companyIcon,
    companyMarkers,
    geoFeatures,
    geoLayers,
    geojson,
    group,
    highlightFeature,
    item,
    map,
    mapOptions,
    markersClusterGroup,
    newBuild,
    numeric_array,
    onEachFeature,
    resetHighlight,
    style,
    updateCompanyList,
  center = [20, 0];
  companyIcon = L.icon({
    iconUrl: "/assets/images/dock_dark.png",
    iconSize: [24, 30],
    iconAnchor: [12, 15],
    popupAnchor: [0, 0],
  });
  newBuild = L.icon({
    iconUrl: "/assets/images/new_build_dark.png",
    iconSize: [25, 25],
    iconAnchor: [25, 25],
    popupAnchor: [0, 0],
  });
  companyMarkers = [];
  geojson = null;
  geoFeatures = [];
  geoLayers = [];
  markersClusterGroup = null;
  $("#catalogRanking").DataTable({
    pageLength: 10,
    bLengthChange: false,
    scrollCollapse: true,
    searching: false,
    bInfo: false,
    scrollX: true,
  });
  $("#catalogRankingNewBuild").DataTable({
    pageLength: 10,
    bLengthChange: false,
    scrollCollapse: true,
    searching: false,
    bInfo: false,
    scrollX: true,
  });
  $("#catalogRankingScrappingYards").DataTable({
    pageLength: 10,
    bLengthChange: false,
    scrollCollapse: true,
    searching: false,
    bInfo: false,
    scrollX: true,
  });
  updateCompanyList = function (data, services) {
    var city,
      company,
      companyMarker,
      countryName,
      flagIcon,
      found,
      i,
      icon,
      j,
      len,
      popupContent,
      ref,
      s,
      zIndexOffset;
    i = 0;
    while (i < companyMarkers.length) {
      map.removeLayer(companyMarkers[i]);
      i++;
    }
    if (markersClusterGroup) {
      markersClusterGroup.clearLayers();
    }
    if (data.length > 0) {
      for (i in data) {
        company = data[i];
        if (!company.lat || !company.lon) {
          continue;
        }
        found = false;
        ref = company.services.split(",");
        for (j = 0, len = ref.length; j < len; j++) {
          s = ref[j];
          if (services.indexOf(s) >= 0) {
            found = true;
          }
        }
        if (!found) {
          continue;
        }
        countryName = company.country ?? "";
        city = company.city ?? "";
        flagIcon = company.country_id ? company.country_id.toLowerCase() : "";
        popupContent = '<div>'
        popupContent += '<strong>' + company.name + "</strong>";
        popupContent += '<div class="d-flex align-items-center mt5">';
        popupContent += '<div class="flag flag-icon-background fi-' + flagIcon + '"></div>';
        popupContent += '<span>' + countryName + '</span>';
        popupContent += '</div></div>';

        if (company.only_new_build === "1") {
          icon = newBuild;
        } else {
          icon = companyIcon;
        }
        zIndexOffset = 0;
        companyMarker = L.marker([company.lat, company.lon], {
          icon: icon,
          zIndexOffset: zIndexOffset,
        });
        companyMarker.properties = {
          company: company,
        };
        companyMarker.bindPopup(popupContent);
        companyMarker.on("mouseover", function (e) {
          this.openPopup();
        });
        companyMarker.on("mouseout", function (e) {
          if (!this.options["clicked"]) {
            this.closePopup();
          }
        });
        companyMarker.on("click", function (e) {
          this.options["clicked"] = true;
          this.openPopup();
        });
        companyMarkers["_" + company.id] = companyMarker;
        markersClusterGroup.addLayer(companyMarker);
      }
      map.addLayer(markersClusterGroup);
    }
  };
  $("a[data-id]").hover(
    function () {
      if (companyMarkers[$(this).attr("data-id")]) {
        if (!companyMarkers[$(this).attr("data-id")]._icon) {
          companyMarkers[$(this).attr("data-id")].__parent.spiderfy();
        }
        companyMarkers[$(this).attr("data-id")].openPopup();
      }
    },
    function () {
      if (companyMarkers[$(this).attr("data-id")]) {
        companyMarkers[$(this).attr("data-id")].closePopup();
      }
    }
  );
  $("input[type=checkbox]").click(function (e) {
    var services;
    services = "";
    if ($("#service-1").prop("checked")) {
      services += "service-1;";
    }
    if ($("#service-2").prop("checked")) {
      services += "service-2;";
    }
    if ($("#service-3").prop("checked")) {
      services += "service-3;";
    }
    return updateCompanyList(companies, services);
  });
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
      color: "#0277bd",
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
  if ($("#map").length <= 0) {
    return;
  }
  mapOptions = {
    maxBounds: L.latLngBounds(L.latLng(-70, -180), L.latLng(75, 180)),
  };
  map = L.map("map", mapOptions).setView(center, 2);
  L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
    maxZoom: 17,
    minZoom: 2,
    id: "mapbox/streets-v11",
    tileSize: 512,
    zoomOffset: -1,
    accessToken:
      "pk.eyJ1IjoiY2hlbi1tYXJpdGltZWRhdGFzeXN0ZW1zLWNvbSIsImEiOiJjajNlNjduMzkwMHBhMzFzMjJnMGlpZmhvIn0.buGEUU37tesHnaWbKZET1A",
  }).addTo(map);
  style = {
    fillColor: "#0277bd",
    weight: 2,
    opacity: 0,
    color: "#0277bd",
    dashArray: "3",
    fillOpacity: 0,
  };
  markersClusterGroup = L.markerClusterGroup({
    maxClusterRadius: 10,
  });
  updateCompanyList(companies, "service-1;service-2;service-3");
  numeric_array = [];
  for (item in companyMarkers) {
    numeric_array.push(companyMarkers[item]);
  }
  if (numeric_array.length > 0) {
    group = new L.featureGroup(numeric_array);
    map.setView(group.getBounds().getCenter(), map.getBoundsZoom(group.getBounds()));
  }
};
