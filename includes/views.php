<?php
  function hiddenFields($key, $array){
    foreach( $array as $value ) {
      echo "<input type='hidden' name='", $key,"[]' value='", $value, "' />";
    }
  }

  function errors($errors){
    if(count($errors) > 0){
      echo '<p class="error">';
      foreach( $errors as $value ) {
        echo $value, '<br />';
      }
      echo '</p>';
    }
  }

  function santaItems($names, $emails){
    foreach( $names as $key => $value ) {
      echo "<li>", $value," (", $emails[$key], ")</li>";
    }
  }
?>
