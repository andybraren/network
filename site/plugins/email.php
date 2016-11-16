<?php

/* Mail Plugin
   Because the default one doesn't allow the use of HTML in email bodies
   This is also simpler because I don't need the key to be everywhere
   Mailgun adapter here: https://github.com/getkirby/toolkit/blob/master/lib/email.php
   Adaptation inspired from this: https://forum.getkirby.com/t/is-there-a-way-to-send-html-emails/504
*/

email::$services['html_email'] = function($email) {
  
  $mailgunKey = c::get('mailgunKey');
  $mailgunKey = c::get('mailgunDomain');
  
  if(empty($mailgunKey))    throw new Error('Missing Mailgun API key');
  if(empty($mailgunDomain)) throw new Error('Missing Mailgun API domain');
  $url  = 'https://api.mailgun.net/v2/' . $mailgunDomain . '/messages';
  $auth = base64_encode('api:' . $mailgunKey);
  
  $headers = array(
    'Accept: application/json',
    'Authorization: Basic ' . $auth,
  );
  
  $data = array(
    'from'       => 'Tufts Maker Network <happyrobot@maker.tufts.edu>',
    'to'         => $email->to,
    'subject'    => $email->subject,
    'html'       => $email->body,
    'h:Reply-To' => $email->replyTo,
  );

  $email->response = remote::post($url, array(
    'headers' => $headers,
    'data'    => $data,
  ));
  
  if($email->response->code() != 200) {
    throw new Error('The mail could not be sent!');
  }
};

?>