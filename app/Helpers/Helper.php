<?php

namespace App\Helpers;

Class Helper{

        public  static function calcula_distancia($lat1, $lon1, $lat2, $lon2){

         /*dd($lat2) ;*/
         $R = 6371; // km
         $dLat = toRad($lat2-$lat1);
         $dLon = toRad($lon2-$lon1);
         $lat1 = toRad($lat1);
         $lat2 = toRad($lat2);
                     
         $a = sin($dLat/2) * sin($dLat/2) +sin($dLon/2) * sin($dLon/2) * cos($lat1) * cos($lat2); 
         $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
         $d = $R * $c;
         return $d;

         }

        public static function GetGeoCode($endereco) {

        $geo= array();
        
        $addr = str_replace(" ", "+", $endereco); // Substitui os espaços por + conforme padrão 'maps.google.com'
        $address = utf8_encode($addr); // Codifica para UTF-8 para não dar 'pau' no envio do parâmetro
        
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw');
        
        /*dd($geocode);*/

        $output = json_decode($geocode);
        /*dd($output->status);*/

        if($output->status <> "ZERO_RESULTS") {
           $lat = $output->results[0]->geometry->location->lat;
           $long = $output->results[0]->geometry->location->lng;
        }
        else{
            $lat = 0;
            $long = 0;
        }

        $geo['lat']=$lat;
        $geo['long']=$long;

        /*dd($geo);*/

        return $geo;
        }   
        
        public static function converte_data($date){

             $date_conv = date_format($date,'d-m-y');

             return $date_conv;

        }

        public static function getTimezone($lat,$lng)
        {
        
        // get the API response for the timezone
        $timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&timestamp=1331161200&key=AIzaSyBQZKTit2ice6KDwHxAc5iQVZQhoBwimjw";

        //$timezoneAPI = "http://api.geonames.org/timezoneJSON?lat={$lat}&lng={$lng}&username=demo";

        $response = file_get_contents($timezoneAPI);
        

        if(!$response)
                return false;

        $response = json_decode($response);

        if(!is_object($response))
                return false;

        if(isset($response->timezoneId) && !is_string($response->timezoneId)) // If google api, use timeZoneId
                return false;

        return $response->timezoneId;

        }



} 
       

        /*Converts numeric degrees to radians*/
        function toRad($Value) 
        {
        return $Value * pi() / 180;
        }


        
?>