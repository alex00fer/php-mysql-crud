<?php

// Función que comprueba si los datos que recibimos existen
function has_all_post_vars(...$list){
  foreach ($list as $val) {
    if (!isset($_POST[$val])) return false;
  }
  return true;
}

?>
