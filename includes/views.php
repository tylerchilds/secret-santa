<?php
  function hiddenFields($key ,$array){
    foreach( $array as $value ) {
      echo "<input type='hidden' name='", $key,"[]' value='", $value, "' />";
    }
  }

  function santaItems($names, $emails){
    foreach( $names as $key => $value ) {
      echo "<li>", $value," (", $emails[$key], ")</li>";
    }
  }
?>
