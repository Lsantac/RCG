@extends('master')

@section('content')
 
<div class="container">

    @if($_SESSION['of_nec'] == 'Oferta')
        @if($_SESSION['part_selecionado'] <> '0')
            <h5><?php echo "Localização dos Participantes que tem Necessidades compativeis com a Oferta de : "; ?></h5>
        @else
            <h5><?php echo "Localização dos Participantes com as Ofertas consultadas : "; ?></h5>
        @endif
    @else
        @if($_SESSION['of_nec'] == 'Necessidade')
            @if($_SESSION['part_selecionado'] <> '0')
                <h5><?php echo "Localização dos Participantes que tem Ofertas compativeis com a necessidade de : "; ?></h5>
            @else
                <h5><?php echo "Localização dos Participantes com as Necessidades consultadas : "; ?></h5>
            @endif                
        @endif
    @endif
    @if($_SESSION['part_selecionado'] <> '0')
       <h4><?php echo $_SESSION['part_selecionado']; ?></h4>
    @endif
    <br>

</div>

<div class="container" id="map"></div>

<script>
    var customLabel = {
    restaurant: {
        label: 'R'
    },
    bar: {
        label: 'B'
    },
    
    };

function initMap() {
var lati = <?php echo $_SESSION['lati']; ?>;   
var longi = <?php echo $_SESSION['longi']; ?>;   

var map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(lati, longi),
    zoom: 5
});

var infoWindow = new google.maps.InfoWindow;

// Change this depending on the name of your PHP or XML file
downloadUrl('/mapas/resultado.php', function(data) {
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
        map: map,
        position: point,
        
        label: icon.label,
        icon: {url: color}
    });

    marker.addListener('click', function() {
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
            
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
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw&callback=initMap&libraries=&v=weekly"
async
></script>

@endsection