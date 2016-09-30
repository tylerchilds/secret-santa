<?php
  function hiddenFields($key, $array){
    foreach( $array as $value ) {
      echo "<input type='hidden' name='", $key,"[]' value='", $value, "' />";
    }
  }

  function errors($errors){
    if(count($errors) > 0){
      foreach( $errors as $value ) {
        echo '<p class="error">', $value, '</p>';
      }
    }
  }

  function santaItems($names, $emails){
    foreach( $names as $key => $value ) {
      echo "<li>", $value," (", $emails[$key], ")</li>";
    }
  }
?>
