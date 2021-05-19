<?php
	
	namespace App;
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	use App\Config;
	//use Mailgun\Mailgun;
	//Load Composer's autoloader
	//require 'vendor/autoload.php';
	
	/**
		* Mail
		*
		* PHP version 7.0
	*/
	class Mail
	{
		
		/**
			* Send a message
			*
			* @param string $to Recipient
			* @param string $subject Subject
			* @param string $text Text-only content of the message
			* @param string $html HTML content of the message
			*
			* @return mixed
		*/
		public static function send($to, $subject, $text, $html)
		{
			
			$mail = new PHPMailer(true);
			
			try {
				//Server settings
				//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host  = 'mail.benchalubinski.pl';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = '_mainaccount@benchalubinski.pl';                     //SMTP username
				$mail->Password   = 'T@uru$1418';                               //SMTP password
				//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
				
				//Recipients
				$mail->setFrom('benchalu@benchalubinski.pl', 'Mailer');
				$mail->addAddress($to, 'User');     //Add a recipient
			    //$mail->addAddress('benchalu@cl11.netmark.pl');     //Add a recipient
				$mail->addAddress('ben.chalubinski@gmail.com');               //Name is optional
				//$mail->addReplyTo('benchalu@cl11.netmark.pl', 'Information');
				//$mail->addCC('cc@example.com');
				// $mail->addBCC('bcc@example.com');
				
				//Attachments
				#$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
				#  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
				
				//Content
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $html;
				$mail->AltBody = $text;
				
				$mail->send();
				echo 'Message has been sent';
				} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
	}
