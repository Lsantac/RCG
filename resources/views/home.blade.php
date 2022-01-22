
@extends('master')

@section('content')

    <div class="container">
      
        <div class="row">
            
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h6 class="card-header header-oferta"><a style="text-decoration: none;" href="/ofertas_part/{{Session::get('id_logado')}}" class="texto-oferta bi-arrow-up-circle-fill"> Minhas Ofertas</a></h6>
                    <div class="card-body">

                      <a href="/cons_trans_ofertas_part/{{2}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                        <div class="row">
                          <div class="col-1">
                            <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                          </div>
                          <div class="col-11">
                            <p class="card-text" style="color:black;">
                              @if(($num_mens_anda_of_tr > 1) or ($num_mens_anda_of_tr == 0))
                                  Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_of_tr}}</b></span> transações em andamento. 
                              @else
                                  Existe <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_of_tr}}</b></span> transação em andamento. 
                              @endif
                            </p>
                          </div>
                        </div>
                      </a>

                      <a href="/cons_trans_ofertas_part/{{3}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-parc-finalizada"></h4>
                        </div>
                        <div class="col-11">
                          <p style="color:black;">
                            @if(($num_ofp_parc > 1) or ($num_ofp_parc == 0))
                                Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> transações confirmadas parcialmente. 
                            @else
                                Existe <span style="color:rgb(15, 135, 233);"><b>{{$num_ofp_parc}}</b></span> transação confirmada parcialmente. 
                            @endif
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="/cons_trans_ofertas_part/{{4}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-finalizada"></h4>
                        </div>
                        <div class="col-11">
                              @if(($num_ofp_final > 1) or ($num_ofp_final == 0))
                                <p style="color:black;">
                                Existem <span style="color:rgb(101, 12, 218);"><b>{{$num_ofp_final}}</b></span> transações já finalizadas. 
                                </p>
                              @else
                                <p style="color:black;">
                                Existe <span style="color:rgb(101, 12, 218);"><b>{{$num_ofp_final}}</b></span> transação já finalizada. 
                                </p>
                              @endif
                        </div>
                      </div>
                      </a>
                      
                    </div>
                  </div>
            </div>
            <div class="col">
                <div class="card" style="width: 100%;">
                    <h6 class="card-header header-necessidade"><a style="text-decoration: none;" href="/necessidades_part/{{Session::get('id_logado')}}" class="texto-necessidade bi-arrow-down-circle-fill"> Minhas Necessidades</a></h6>
                    <div class="card-body">

                      <a href="/cons_trans_necessidades_part/{{2}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-chat-left-dots-fill texto-em-andamento"></h4>
                        </div>
                        <div class="col-11">
                          <p class="card-text" style="color:black;">
                            @if($num_mens_anda_nec > 1 or $num_mens_anda_nec == 0)
                               Existem <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_nec}}</b></span> transações em andamento. 
                            @else
                               Existe <span style="color:rgb(197, 15, 233);"><b>{{$num_mens_anda_nec}}</b></span> transação em andamento. 
                            @endif
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="/cons_trans_necessidades_part/{{3}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-parc-finalizada"></h4>
                        </div>
                        <div class="col-11">
                          <p style="color:black;">
                            @if($num_nec_parc > 1 or $num_nec_parc == 0 )
                               Existem <span style="color:rgb(15, 135, 233);"><b>{{$num_nec_parc}}</b></span> transações confirmadas parcialmente. 
                            @else
                               Existe <span style="color:rgb(15, 135, 233);"><b>{{$num_nec_parc}}</b></span> transação confirmada parcialmente. 
                            @endif
                          </p>
                        </div>
                      </div>
                      </a>

                      <a href="/cons_trans_necessidades_part/{{4}}/{{Session::get('id_logado')}}" style="text-decoration: none;">
                      <div class="row">
                        <div class="col-1">
                          <h4 class="bi bi-check-circle-fill texto-finalizada"></h4>
                        </div>
                        <div class="col-11">
                              @if($num_nec_final > 1 or $num_nec_final == 0)
                                <p style="color:black;">
                                Existem <span style="color:rgb(101, 12, 218);"><b>{{$num_nec_final}}</b></span> transações já finalizadas. 
                                </p>
                              @else
                                <p style="color:black;">
                                Existe <span style="color:rgb(101, 12, 218);"><b>{{$num_nec_final}}</b></span> transação já finalizada. 
                                </p>
                              @endif
                        </div>
                      </div>
                      </a>  
           
                    </div>
                  </div>
            </div>
          </div>

          <br>

          
          <div class="row">
            <div class="col">
              <div class="card" >
                <div style="height:30rem;" class="card-body" id="map_of">
                  
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card" >
                <div style="height:30rem;" class="card-body" id="map_nec">
                  
                </div>
              </div>
            </div>
          </div>

        
      
    </div>

    <script>
      function initialize() {
        initMap_of();
        initMap_nec();
      }
    </script>

    <script>

    var customLabel = {
    restaurant: {
      label: 'R'
    },
    bar: {
      label: 'B'
    },

    };

    function initMap_nec() {

    var lati = <?php echo Session::get('latitude'); ?>;   
    var longi = <?php echo Session::get('longitude'); ?>;   

    var map_nec = new google.maps.Map(document.getElementById('map_nec'), {
      center: new google.maps.LatLng(lati, longi),
      zoom: 5
    });

    var infoWindow = new google.maps.InfoWindow;

    // Change this depending on the name of your PHP or XML file
    downloadUrl('/mapas/resultado_nec.php', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
      var color = markerElem.getAttribute('color'); 
      var name = markerElem.getAttribute('name');
      var address = markerElem.getAttribute('address');
      var type = markerElem.getAttribute('type');

      //pega posição pelo endereço
      var geocoder = new google.maps.Geocoder();
      
      geocoder.geocode( { address: address}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {
          var latitude = results[0].geometry.location.lat();
          var longitude = results[0].geometry.location.lng();
          //var latlng = results[0].geometry.location.LatLng();
          //alert('Latitude : ' + latitude);
        
          } 
      }); 
      //===================================================================================

      var point = new google.maps.LatLng(
          parseFloat(markerElem.getAttribute('lat')),
          parseFloat(markerElem.getAttribute('lng')));

      //var point = '('+latitude+','+longitude+')';
      //  alert(point);

      var infowincontent = document.createElement('div');
      var strong = document.createElement('strong');
      strong.textContent = name
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement('br'));

      var text = document.createElement('text');
      text.textContent = address
      infowincontent.appendChild(text);
      var icon = customLabel[type] || {};

      var marker = new google.maps.Marker({
          map: map_nec,
          position: point,
          
          label: icon.label,
          icon: {url: color}
      });

      marker.addListener('click', function() {
              infoWindow.setContent(infowincontent);
              infoWindow.open(map_nec, marker);
              
      });
      
    });
    });
    }  
     
    function initMap_of() {

      var lati = <?php echo Session::get('latitude'); ?>;   
      var longi = <?php echo Session::get('longitude'); ?>;   
      
      var map_of = new google.maps.Map(document.getElementById('map_of'), {
          center: new google.maps.LatLng(lati, longi),
          zoom: 5
      });
      
      var infoWindow = new google.maps.InfoWindow;
      
      // Change this depending on the name of your PHP or XML file
      downloadUrl('/mapas/resultado_of.php', function(data) {
      var xml = data.responseXML;
      var markers = xml.documentElement.getElementsByTagName('marker');
      Array.prototype.forEach.call(markers, function(markerElem) {
          var color = markerElem.getAttribute('color'); 
          var name = markerElem.getAttribute('name');
          var address = markerElem.getAttribute('address');
          var type = markerElem.getAttribute('type');
      
          //pega posição pelo endereço
          var geocoder = new google.maps.Geocoder();
          
          geocoder.geocode( { address: address}, function(results, status) {
      
          if (status == google.maps.GeocoderStatus.OK) {
              var latitude = results[0].geometry.location.lat();
              var longitude = results[0].geometry.location.lng();
              //var latlng = results[0].geometry.location.LatLng();
              //alert('Latitude : ' + latitude);
             
              } 
          }); 
          //===================================================================================
      
          var point = new google.maps.LatLng(
              parseFloat(markerElem.getAttribute('lat')),
              parseFloat(markerElem.getAttribute('lng')));
      
          //var point = '('+latitude+','+longitude+')';
          //  alert(point);
      
          var infowincontent = document.createElement('div');
          var strong = document.createElement('strong');
          strong.textContent = name
          infowincontent.appendChild(strong);
          infowincontent.appendChild(document.createElement('br'));
      
          var text = document.createElement('text');
          text.textContent = address
          infowincontent.appendChild(text);
          var icon = customLabel[type] || {};
      
          var marker = new google.maps.Marker({
              map: map_of,
              position: point,
              
              label: icon.label,
              icon: {url: color}
          });
      
          marker.addListener('click', function() {
                  infoWindow.setContent(infowincontent);
                  infoWindow.open(map_of, marker);
                  
          });
          
      });
      });
      }
           
      function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

      
      request.onreadystatechange = function() {
      if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
      }
      };
      
      request.open('GET', url, true);
      request.send(null);
      }
      
      function doNothing() {}
      </script>
      
      
      <script    
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw&callback=initialize&libraries=&v=weekly"
      async
      ></script>

      

@endsection