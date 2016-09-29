<?php
  function matchSantas($names, $emails){
    $original = original($names, $emails);

    do {
      $matches = match($names, $emails);
    } while (notUnique($original, $matches));

    return $original;
  }

  function original($names, $emails){
    $originals = array();

    foreach ($emails as $key => $value) {
      $originals[$value] = $names[$key];
    }

    return $originals;
  }

  function match($names, $emails){
    $matches = array();
    $numbers = range(0, count($names) - 1);

    shuffle($numbers);

    foreach ($numbers as $i) {
      echo $i;
      foreach ($emails as $e) {
        $matches[$e] = $names[$key];
      }
    }

    return $matches;
  }

  function notUnique($original, $matches){
    foreach ($original as $key => $value) {
      if($original[$key] == $matches[$key]){
        return true;
      }
    }

    return false;
  }
?>
