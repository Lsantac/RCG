<?php

require("conexao.php");

function parseToXML($htmlStr){
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}

// Select all the rows in the markers table

    $result_markers = "SELECT * FROM markers_of";
    $resultado_markers = mysqli_query($conn, $result_markers);

    header("Content-type: text/xml");

    // Start XML file, echo parent node
    echo '<markers>';

    // Iterate through the rows, printing XML nodes for each

    while ($row_markers = mysqli_fetch_assoc($resultado_markers)){
      // Add to XML document node
      echo '<marker ';
      //echo 'color= "http://maps.google.com/mapfiles/kml/pal3/icon48.png" ';

      if($row_markers['status']==2){
        echo 'color= "/icons/marcador_andamento.png" ';
     }else{
       if($row_markers['status']==3){
          echo 'color= "/icons/marcador_parcial.png" ';
       }else{
         if($row_markers['status']==4){
           echo 'color= "/icons/marcador_finalizado.png" ';
         }else{
            echo 'color= "/icons/marcador_verde.png" ';
         }
       }  

     };

      echo 'name="' . parseToXML($row_markers['nome_part']) . '" ';
      echo 'address="' . parseToXML($row_markers['endereco']) . '" ';
      echo 'lat="' . $row_markers['latitude'] . '" ';
      echo 'lng="' . $row_markers['longitude'] . '" ';
      echo 'type="' . $row_markers['type'] . '" ';
      echo '/>';
    }

    // End XML file
    echo '</markers>';





