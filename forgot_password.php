<?php

	require_once('phpmailer/PHPMailerAutoload.php');
	require_once('connect.php');

	if(isset($_POST["command"]) && $_POST["command"] == "Send Email")
	{
		$emailAddress = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$query = "SELECT * FROM user WHERE email = '$emailAddress' LIMIT 1";
        $statement = $db->prepare($query);
        $statement->execute();
	    if ($statement->rowCount()> 0)
	    {
	    	$row=$statement->fetch();
	        //Create a new PHPMailer instance
			$mail = new PHPMailer;

			//Tell PHPMailer to use SMTP
			$mail->isSMTP();

			//Set the hostname of the mail server
			$mail->Host = 'smtp.gmail.com';

			//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			$mail->Port = 587;

			//Set the encryption system to use - ssl (deprecated) or tls
			$mail->SMTPSecure = 'tls';

			//Whether to use SMTP authentication
			$mail->SMTPAuth = true;

			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username = "qichen.z123@gmail.com";

			//Password to use for SMTP authentication
			$mail->Password = "Qichen1219";

			//Set who the message is to be sent from
			$mail->setFrom('setFrom@gmail.com', 'Fitness Association');

			//Set an alternative reply-to address
			$mail->addReplyTo('replyto@example.com', 'First Last');

			//Set who the message is to be sent to
			$mail->addAddress($row['email'], $row['firstname'] . ' ' . $row['lastname']);

			//Set the subject line
			$mail->Subject = 'Password Reset';

			//todo: change URL for production
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			$mail->Body	=  $row['firstname'] . ' ' . $row['lastname'] . ", Please reset your pass: <a href='" . "http://localhost" . "' target= '_blank'>" .  "http://localhost" . "</a>";
			//Replace the plain text body with one created manually
			$mail->AltBody = 'This is a plain-text message body';

			if(!$mail->Send()) {
			    echo "Mailer Error: " . $mail->ErrorInfo;
			 } else {
			    echo "Message has been sent";
			 }
		}
		else
		{
			echo "wrong email";
		}
		
	}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset="utf-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link href="../../public/css/bootstrap.min.css" rel="stylesheet" type = "text/css" />

	<link rel = "stylesheet" type = "text/css" href = "../../public/css/site.css" />

	<script src = "../../public/js/site.js" type = "text/javascript"></script>

	<title>Forget Pass</title>
</head>

	<body>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../../public/js/bootstrap.min.js"></script>

		<div class = "jumbotron">
            <fieldset id = "jumboForm">

                <legend>Recover Password</legend>

                <form method = "post" action = "forgot_password.php">

                    <input name = "email" type = "text" placeholder="email address" />

                    <input type = "submit" name = "command" value = "Send Email" />

					<a href="index.php">Back To Login Page</a>

                </form>

            </fieldset>
        </div>
	</body>
</html>
