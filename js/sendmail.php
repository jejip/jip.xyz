<?php
// Who you want to recieve the emails from the form.
$sendto = 'jipeilbracht@gmail.com';

// The subject you'll see in your inbox
$subject = 'A message from wopij website';

// Message for the user when he/she doesn't fill in the form correctly.
$errormessage = 'Both fields are required, is it too much to ask?';

//Message for the user when he/she fills in the form correctly.
$thanks = "Message sent, I'll get back to you when I can.";

// Message for the bot when it fills in in at all.
$honeypot = "";

// Various messages displayed when the fields are empty.
$emptyname =  'Entering your name?';
$emptyemail = 'Provide an email address, so I can send something back';
$emptymessage = 'It would be nice if you crafted a message just for me';

// Various messages displayed when the fields are incorrectly formatted.
$alertname =  'Entering your name using only the standard alphabet?';
$alertemail = 'Entering your email in this format: <i>name@example.com</i>?';
$alertmessage = "Making sure you aren't using any parenthesis or other escaping characters in the message? Most URLS are fine though!";

$alert = '';
$pass = 0;

function clean_var($variable) {
	$variable = strip_tags(stripslashes(trim(rtrim($variable))));
  return $variable;
}

if ( empty($_REQUEST['last']) ) {

  if ( empty($_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptyemail . "</li>";
	$alert .= "<script>jQuery(\"#email\").addClass(\"error\");</script>";
  } elseif ( !eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$", $_REQUEST['email']) ) {
	$pass = 1;
	$alert .= "<li>" . $alertemail . "</li>";
  }
  if ( empty($_REQUEST['message']) ) {
	$pass = 1;
	$alert .= "<li>" . $emptymessage . "</li>";
	$alert .= "<script>jQuery(\"#message\").addClass(\"error\");</script>";
  } elseif ( ereg( "[][{}()*+\\^$|]", $_REQUEST['message'] ) ) {
	$pass = 1;
	$alert .= "<li>" . $alertmessage . "</li>";
  }

  if ( $pass==1 ) {

  echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\"); </script>";
  echo "<script>$(\".alert\").addClass('alert-block alert-error').removeClass('alert-success'); </script>";
  echo $errormessage;
  echo $alert;

  } elseif (isset($_REQUEST['message'])) {

	$message = "From: " . clean_var($_REQUEST['name']) . "\n";
	$message .= "Email: " . clean_var($_REQUEST['email']) . "\n";
	$message .= "Message: \n" . clean_var($_REQUEST['message']);
	$header = 'From:'. clean_var($_REQUEST['email']);

	mail($sendto, $subject, $message, $header);
	echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\");$('#contactForm')[0].reset();</script>";
	echo "<script>$(\".alert\").addClass('alert-block alert-success').removeClass('alert-error'); </script>";
	echo $thanks;
	echo "<script>jQuery(\"#name\").removeClass(\"error\");jQuery(\"#email\").removeClass(\"error\");jQuery(\"#message\").removeClass(\"error\");</script>";
	die();

	echo "<br/><br/>" . $message;

	}

} else {
  echo "<script>$(\".message\").toggle();$(\".message\").toggle().hide(\"slow\").show(\"slow\"); </script>";
  echo $honeypot;
}
?>