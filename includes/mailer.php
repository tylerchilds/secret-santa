<?php
  require("sendgrid-php/sendgrid-php.php");

  function sendEmail($to, $subject, $body){
    $from = new SendGrid\Email(null, "secret.santa@bamzap.pw");
    $subject = $subject;
    $to = new SendGrid\Email(null, "test@bamzap.pw");
    $content = new SendGrid\Content("text/plain", $body);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    echo $response->statusCode();
    echo $response->headers();
    echo $response->body();
  }

?>
