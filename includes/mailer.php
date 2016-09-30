<?php
  require("sendgrid-php/sendgrid-php.php");

  function sendEmail($email, $subject, $body){
    $from = new SendGrid\Email("Secret Santa", "secret.santa@bamzap.pw");
    $subject = $subject;
    $to = new SendGrid\Email(null, $email);
    $content = new SendGrid\Content("text/html", $body);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);

    return $response->statusCode();
  }

  function template($host, $group, $name){
    return <<<EOF
      <h2>Secret Santa Invitiation</h2>
      <p>
        <strong>$host</strong> has invited you to join: <strong>$group</strong></p>
      <p>
        Should you choose to participate, you will buy a gift for <strong>$name</strong>. Dont forget to be discreet!
      </p>
EOF;
  }

?>
