<?php

require 'dbConnect.php';

$arrayJugadores = array();

$query = "SELECT * FROM elementos";
$result = $conn->query($query);

if(isset($result) && $result){
  if ($result->num_rows > 0) {

    $contador = 0;
    while($row = $result->fetch_assoc()) {
        array_push($arrayJugadores, $row);
        $contador++;
    }

  } else { // La tabla está vacía
      $arrayMensaje = array(
        "status" =>  "fail",
        "message" => "No results"
    );
  }

  $arrayMensaje = array(
    "status" => "success",
    "numJugadores" => $contador,
    "jugadores" => $arrayJugadores
  );

}else{  // Si hay algún problema con la query o con la conexión
  $arrayMensaje = array(
    "status" =>  "error",
    "message" => $conn->error
);
}

// cierre de conexión con la BBDD
 $conn->close();

// Codificamos el array del mensaje para escribirlo
$mensajeFinalJSON = json_encode($arrayMensaje,JSON_PRETTY_PRINT);
echo $mensajeFinalJSON;
?>
