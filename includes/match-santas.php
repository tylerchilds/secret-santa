<?php
  function matchSantas($names, $emails){
    $original = original($names, $emails);

    do {
      $matches = match($names, $emails);
    } while (notUnique($original, $matches));

    return $matches;
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

    foreach ($emails as $key => $e) {
      $matches[$e] = $names[array_pop($numbers)];
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
