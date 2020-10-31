<?php

require 'dbConnect.php';
require 'utils.php';

if(has_all_post_vars('nombre', 'descripcion','caracteristica', 'edad')){
  $miNombre=mysqli_real_escape_string($conn, $_POST['nombre']);
  $miDescripcion =mysqli_real_escape_string($conn, $_POST['descripcion']);
  $miCaracteristica = mysqli_real_escape_string($conn, $_POST['caracteristica']);
  $miEdad = mysqli_real_escape_string($conn, $_POST['edad']);

  $miQuery  = "INSERT into elementos (nombre, descripcion, caracteristica, edad)";
  $miQuery .= " VALUES ('$miNombre','$miDescripcion','$miCaracteristica', $miEdad)";

  if ($conn->query($miQuery) === TRUE) {

      // Si se ha realizado correcamente la inserción nos quedamos con el útlimo id
      $idInsertado = $conn->insert_id;

      // En la respuesta además del estado y el mensaje, incluimos el id del último insertado
      $arrayMensaje = array(
        "status" =>  "success",
        "message" => "Inserted sucessfully",
        "withId" => $idInsertado
      );

  }else{  // Error en la query

      $arrayMensaje = array(
        "status" =>  "error",
        "message" => "Insert query failed"
      );
  }

}else{  // Me han enviado mal la información
  $arrayMensaje = array(
    "status" =>  "fail",
    "message" => "Bad data sent"
  );
}

$mensajeJSON = json_encode($arrayMensaje,JSON_PRETTY_PRINT);
echo $mensajeJSON;

 ?>
