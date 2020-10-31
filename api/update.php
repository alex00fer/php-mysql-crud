<?php

require 'dbConnect.php';
require 'utils.php';

if(has_all_post_vars('id')){
       $miQuery  = "UPDATE elementos SET ";
       $hasContent = false;
       if (isset($_POST['nombre'])) {
              if ($hasContent) $miQuery.=", ";
              $value=mysqli_real_escape_string( $conn, $_POST['nombre']);
              $miQuery  .= "nombre='$value' ";
              $hasContent = true;
       }
       if (isset($_POST['descripcion'])) {
              if ($hasContent) $miQuery.=", ";
              $value=mysqli_real_escape_string( $conn, $_POST['descripcion']);
              $miQuery  .= "descripcion='$value' ";
              $hasContent = true;
       }
       if (isset($_POST['caracteristica'])) {
              if ($hasContent) $miQuery.=", ";
              $value=mysqli_real_escape_string( $conn, $_POST['caracteristica']);
              $miQuery  .= "caracteristica='$value' ";
              $hasContent = true;
       }
       if (isset($_POST['edad'])) {
              if ($hasContent) $miQuery.=", ";
              $value=mysqli_real_escape_string( $conn, $_POST['edad']);
              $miQuery  .= "edad='$value' ";
              $hasContent = true;
       }

       $miId=mysqli_real_escape_string( $conn, $_POST['id']);
       $miQuery .= " WHERE id=$miId";
       
       if ($hasContent && $conn->query($miQuery) === TRUE) {

              $arrayMensaje = array(
                     "status" =>  "success",
                     "message" => "Updated sucessfully",
                     "withId" => $miId
              );

       }else{  // Error en la query

              $arrayMensaje = array(
                     "status" =>  "error",
                     "message" => "Update query failed"
              );
       }

       }else{  // Información recibida invalida o insuficiente
              $arrayMensaje = array(
                     "status" =>  "fail",
                     "message" => "Bad data sent"
              );
       }

$mensajeJSON = json_encode($arrayMensaje,JSON_PRETTY_PRINT);
echo $mensajeJSON;

 ?>
