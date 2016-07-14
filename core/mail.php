<?php
	//
	//
	//
	//
	require 'config.php';
	$mail_config = new mail_config;





	require 'PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $main_config->host;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $main_config->username;                 // SMTP username
	$mail->Password = $main_config->password;                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587; 
	//
	//
	//

	//  clean up args //  nuked filename from argv
	unset($argv[0]);


	//  build, or explode "-" variables passed in command line
	$full_arg = array();
	$working_command = false;
	$working_array = array();
	foreach ( $argv as $arg ):
		
		if ( $working_command == false ):
			$working_arg = explode( '-', $arg);
			if ( in_array( "", $working_arg ) ):
				$working_command = $working_arg[1];
			endif;
		else:
			//print_r( $arg);
			$working_array[$working_command] = $arg;
			$working_command = false;
		endif;
	endforeach;

	
	$mail->setFrom( $main_config->from );
	$mail->addAddress( $working_array['to'] );
	$mail->Subject = $working_array['subject'];
	//$mail->Body = 
	
	$f = fopen( 'php://stdin', 'r' );
	$content = '';
	while( $line = fgets( $f ) ) {
		  $content .= $line;
	}

	fclose( $f );
	
	
	$mail->Body = $content;	
	

	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
	
	

?>
