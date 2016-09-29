<?php
  require 'mailer.php';
  require 'match-santas.php';

  require 'includes/views.php';

  $names = $_POST["names"] ?: [];
  $emails = $_POST["emails"] ?: [];

  if ($_POST["send"] == "true") {
    $matches = matchSantas($names, $emails);

    foreach ($matches as $key => $value) {
      echo $key . ': ' . $value;
      //sendEmail($key, $value);
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Secret Santa</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta name="apple-touch-fullscreen" content="yes">
    <link href="css/main.css" rel="stylesheet" />
  </head>
  <body>
    <header>
      <h1>Secret Santa</h1>
      <p>
        Create a Secret Santa Gift Exchange
      </p>
    </header>
    <div class="grid">
      <div class="col-6">
        <div class="scroll">
          <h2>Add Santa</h2>
          <p>
            Enter the names and emails of each Santa in your gift exchange.
          </p>
          <form action="index.php" method="post" id="add-form">
            <?php
              hiddenFields('emails', $emails);
              hiddenFields('names', $names);
            ?>

            <div class="field">
              <input type="text" name="names[]" id="add-name"/>
              <label for="add-name">
                Name:
              </label>
            </div>

            <div class="field">
              <input type="text" name="emails[]" id="add-email" />
              <label for="add-email">
                Email:
              </label>
            </div>

            <button type="submit">
              Add Person
            </button>
          </form>
        </div>
      </div>

      <div class="col-6">
        <div class="scroll">
          <h2>All Santas</h2>
          <ol id="santa-list" aria-live="polite">
            <?php
              santaItems($names, $emails)
            ?>
          </ol>

          <form action="index.php" method="post" id="send-form">
            <input type="hidden" name="send" value="true"/>
            <?php
              hiddenFields('emails', $emails);
              hiddenFields('names', $names);
            ?>
            <button type="submit">
              Match Santas
            </button>
          </form>

          <p class="info">
            When you match santas, an email will be sent to each one with the name
            of their randomly selected santa.
          </p>
        </div>
      </div>
    </div>
  <script type="text/javascript" src="js/main.js"></script>
  </body>
</html>
