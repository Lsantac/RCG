const { defaultsDeep } = require("lodash");

function initMap() {

    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 8,
      center: { lat: -22.93114471992559,  lng: -43.20841097665146 },
    });

    const geocoder = new google.maps.Geocoder();

    document.getElementById("submit").addEventListener("click", () => {
      geocodeAddress(geocoder, map);
    });
  }
  
  function geocodeAddress(geocoder, resultsMap) {
    const address = document.getElementById("address").value;

    geocoder.geocode({ address: address }, (results, status) => {
      if (status === "OK") {
        resultsMap.setCenter(results[0].geometry.location);
        new google.maps.Marker({
          map: resultsMap,
          position: results[0].geometry.location,
        });
        
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }

    });
  }