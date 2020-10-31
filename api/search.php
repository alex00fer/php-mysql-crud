<?php

require 'dbConnect.php';

$arrayJugadores = array();

$miQuery = "SELECT * FROM elementos WHERE ";
$hasContent = false;
if (isset($_POST['nombre'])) {
       if ($hasContent) $miQuery.=" AND ";
       $value=mysqli_real_escape_string($conn, $_POST['nombre']);
       $miQuery .= "nombre LIKE '%$value%'";
       $hasContent = true;
}
if (isset($_POST['descripcion'])) {
       if ($hasContent) $miQuery.=" AND ";
       $value=mysqli_real_escape_string($conn, $_POST['descripcion']);
       $miQuery .= "descripcion LIKE '%$value%'";
       $hasContent = true;
}
if (isset($_POST['caracteristica'])) {
       if ($hasContent) $miQuery.=" AND ";
       $value=mysqli_real_escape_string($conn, $_POST['caracteristica']);
       $miQuery .= "caracteristica LIKE '%$value%'";
       $hasContent = true;
}
if (isset($_POST['edad'])) {
       if ($hasContent) $miQuery.=" AND ";
       $value=mysqli_real_escape_string($conn, $_POST['edad']);
       $miQuery .= "edad LIKE '%$value%'";
       $hasContent = true;
}
if (isset($_POST['id'])) {
       if ($hasContent) $miQuery.=" AND ";
       $value=mysqli_real_escape_string($conn, $_POST['id']);
       $miQuery .= "id LIKE '%$value%'";
       $hasContent = true;
}

$contador = 0;
if ($hasContent) {
       $result = $conn->query($miQuery);

       if(isset($result) && $result){
       if ($result->num_rows > 0) {

       
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
}
else 
{
       $arrayMensaje = array(
              "status" =>  "error",
              "message" => "No data to search for sent"
       );
}

// cierre de conexión con la BBDD
 $conn->close();

// Codificamos el array del mensaje para escribirlo
$mensajeFinalJSON = json_encode($arrayMensaje,JSON_PRETTY_PRINT);
echo $mensajeFinalJSON;
?>
