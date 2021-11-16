<!DOCTYPE html>
<html>
  <head>
    <title>Geocoding Service</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
    <script src="/js/index.js"></script>
  </head>
  <body>
    <div id="floating-panel">
      <input id="address" type="textbox" value="Rio de Janeiro, Brasil" />
      <input id="submit" type="button" value="Geocode" />
    </div>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  </body>
</html>
