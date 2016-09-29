<?php
  require 'includes/mailer.php';
  require 'includes/match-santas.php';

  require 'includes/views.php';

  $json = json_decode(file_get_contents('php://input'), true);

  $errors = [];
  $names = $_POST["names"] ?: $json["names"] ?: [];
  $emails = $_POST["emails"] ?: $json["emails"] ?: [];

  if ($_POST["send"] == "true" || !! $json) {
    if(count($emails) < 2){
      $tooFewSantas = "Add more Santas";
    } else {
      $matches = matchSantas($names, $emails);
      $names = [];
      $emails = [];
      $success = "Santas have been emailed their Secret Santa";
    }
  } else {
    if(count($names) !== count(array_unique($names))){
      $errors["duplicate_name"] = "Name must be unique";
    }

    if(count($emails) !== count(array_unique($emails))){
      $errors["duplicate_email"] = "Email must be unique";
    }

    if(count($errors) > 0){
      $name = array_pop($names);
      $email = array_pop($emails);
    }
  }

  if(!! $json){

    $response = array();
    $response["matches"] = $matches;
    $response["errors"] = $tooFewSantas;
    $response["status"] = ! $response["errors"] ? true : false;

    header('Content-Type: application/json');
    header('Status: '. $response["status"] ? '200 OK' : 'Unprocessable Entity');
    echo json_encode($response);
  } else {
?>

<!DOCTYPE html>
<html lang="en">
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
            <div class="error" id="add-errors">
              <?php errors($errors); ?>
            </div>
            <?php
              hiddenFields('emails', $emails);
              hiddenFields('names', $names);
            ?>

            <div class="field">
              <input type="text" name="names[]" id="add-name" value="<?php echo $name ?>" required />
              <label for="add-name">
                Name:
              </label>
            </div>

            <div class="field">
              <input type="email" name="emails[]" id="add-email" value="<?php echo $email ?>"  required />
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
          <div class="error" id="send-errors">
            <?php
              if(!! $tooFewSantas){
                echo '<p>', $tooFewSantas, '</p>';
              }
            ?>
          </div>
          <div class="success" id="send-success">
            <?php
              if(!! $success){
                echo '<p>', $success, '</p>';
              }
            ?>
          </div>
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

<?php
  }
?>
