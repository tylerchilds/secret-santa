<?php
  require 'aws/aws-autoloader.php';
  use Aws\Ses\SesClient;

  function sendEmail($to, $body){
    // Replace sender@example.com with your "From" address.
    // This address must be verified with Amazon SES.
    define('SENDER', 'example@bamzap.pw');

    // Replace recipient@example.com with a "To" address. If your account
    // is still in the sandbox, this address must be verified.
    define('RECIPIENT', $to);

    // Replace us-west-2 with the AWS region you're using for Amazon SES.
    define('REGION','us-west-2');

    define('SUBJECT','Secret Santa');
    define('BODY','Your Secret Santa: ' . $body);

    $client = SesClient::factory(array(
      'version'=> 'latest',
      'region' => REGION
    ));

    $request = array();
    $request['Source'] = SENDER;
    $request['Destination']['ToAddresses'] = array(RECIPIENT);
    $request['Message']['Subject']['Data'] = SUBJECT;
    $request['Message']['Body']['Text']['Data'] = BODY;

    try {
      $result = $client->sendEmail($request);
      $messageId = $result->get('MessageId');
      echo("Email sent! Message ID: $messageId"."\n");

    } catch (Exception $e) {
      echo("The email was not sent. Error message: ");
      echo($e->getMessage()."\n");
    }
  }

?>
