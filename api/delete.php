<?php

require 'dbConnect.php';
require 'utils.php';

if(has_all_post_vars('id')){
  $miId = mysqli_real_escape_string($conn, $_POST['id']);

  $miQuery  = "DELETE FROM elementos WHERE id = $miId";

  if ($conn->query($miQuery) === TRUE) {

      // En la respuesta además del estado y el mensaje, incluimos el id del último insertado
      $arrayMensaje = array(
        "status" =>  "success",
        "message" => "Deleted sucessfully",
        "withId" => $miId
      );

  }else{  // Error en la query

      $arrayMensaje = array(
        "status" =>  "error",
        "message" => "Delete query failed"
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
