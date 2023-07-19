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
    repair_icon,
    newbuilding_icon,
    recycling_icon,
    repair_newbuilding_icon,
    repair_recycling_icon,
    newbuilding_recycling_icon,
    triple_icon,
    companyMarkers,
    group,
    item,
    map,
    mapOptions,
    markersClusterGroup,
    numeric_array,
    updateCompanyList,
    center = [20, 0];

  repair_icon = L.icon({
    iconUrl: "/assets/images/repair.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  newbuilding_icon = L.icon({
    iconUrl: "/assets/images/newbuilding.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  recycling_icon = L.icon({
    iconUrl: "/assets/images/recycling.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  repair_newbuilding_icon = L.icon({
    iconUrl: "/assets/images/repair_newbuilding.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  repair_recycling_icon = L.icon({
    iconUrl: "/assets/images/repair_recycling.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  newbuilding_recycling_icon = L.icon({
    iconUrl: "/assets/images/newbuilding_recycling.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });
  triple_icon = L.icon({
    iconUrl: "/assets/images/repair_newbuilding_recycling.png",
    iconSize: [32, 32],
    iconAnchor: [32, 32],
    popupAnchor: [-16, -32],
  });

  companyMarkers = [];
  markersClusterGroup = null;

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
      if (companyMarkers[i]) {
        map.removeLayer(companyMarkers[i]);
      }
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
        popupContent = `
          <div class="marker-popup-content">
            <strong>${company.name}</strong>
            <hr>
            <div class="row">
              <strong class="col-4">Country</strong>
              <div class="col-8 d-flex align-items-center"><span class="flag flag-icon-background fi-${flagIcon}"></span> ${countryName}</div>
            </div>
            <div class="row">
              <strong class="col-4">Services</strong>
              <div class="col-8">`;
        if (company.services.includes("service-2")) {
          popupContent += '<img src="/assets/images/repair.png" alt="Repairs" />';
        }
        if (company.services.includes("service-1")) {
          popupContent += '<img src="/assets/images/newbuilding.png" alt="New Buildings" />';
        }
        if (company.services.includes("service-3")) {
          popupContent += '<img src="/assets/images/recycling.png" alt="Recycling" />';
        }

        popupContent += `</div></div>
            <div class="row">
              <strong class="col-4">Max Length</strong>
              <span class="col-8">${company.maxLength ? company.maxLength + " m" : "---"}</span>
            </div>
          </div>`;

        if (company.services.includes("service-1") && company.services.includes("service-2") && company.services.includes("service-3")) {
          icon = triple_icon;
        } else if (company.services.includes("service-1") && company.services.includes("service-2")) {
          icon = repair_newbuilding_icon;
        } else if (company.services.includes("service-1") && company.services.includes("service-3")) {
          icon = newbuilding_recycling_icon;
        } else if (company.services.includes("service-2") && company.services.includes("service-3")) {
          icon = repair_recycling_icon;
        } else if (company.services.includes("service-1")) {
          icon = newbuilding_icon;
        } else if (company.services.includes("service-2")) {
          icon = repair_icon;
        } else {
          icon = recycling_icon;
        }

        zIndexOffset = 0;
        companyMarker = L.marker([company.lat, company.lon], {
          icon: icon,
          zIndexOffset: zIndexOffset,
        });
        companyMarker.properties = {
          id: company.id,
        };
        companyMarker.bindPopup(popupContent);
        companyMarker.on("mouseover", function (e) {
          this.openPopup();
        });
        companyMarker.on("mouseout", function (e) {
          this.closePopup();
        });
        companyMarker.on("click", function (e) {
          clickLinkElement(this.properties.id);
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

  clickLinkElement = function (dataId) {
    $('a[data-id="' + dataId + '"]').simulateClick();
  };

  if ($("#map").length <= 0) {
    return;
  }
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
    accessToken:
      "pk.eyJ1IjoiY2hlbi1tYXJpdGltZWRhdGFzeXN0ZW1zLWNvbSIsImEiOiJjajNlNjduMzkwMHBhMzFzMjJnMGlpZmhvIn0.buGEUU37tesHnaWbKZET1A",
  }).addTo(map);

  markersClusterGroup = L.markerClusterGroup({
    maxClusterRadius: 10,
    spiderfyOnMaxZoom: false,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: false
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
