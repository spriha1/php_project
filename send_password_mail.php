<?php
	$msg = "";
	if(isset($_POST['username']))
	{
		if(!empty($_POST['username']))
		{
			$username = $_POST['username'];
			$msg = "Please reset your password by clicking the link that has been sent to your email.";
			include_once 'db_connection.php';
			include_once 'db_credentials.php';
			$obj = new DB_connect();
		    $conn = $obj->connect('localhost','php_project',$db_username,$db_password);
		    $query = "SELECT id FROM users WHERE username = '".$username."'";
		    $result = $obj->select_records($query);
		    if($result)
		    {
			    $sql = "UPDATE users SET token = '".uniqid()."' WHERE username = '".$username."'";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $query = "SELECT token,email FROM users WHERE username = '".$username."'";
			    $result = $obj->select_records($query);
			   
		    	foreach ($result as $key => $value) {
			    	require_once '/usr/share/php/libphp-phpmailer/class.phpmailer.php';
					require_once '/usr/share/php/libphp-phpmailer/class.smtp.php';
					//require_once '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';

					$mail = new PHPMailer;
					$mail->setFrom('spriha.mindfire@gmail.com');
					$mail->addAddress(''.$value['email'].'');
					$mail->Subject = 'Forgot Password';
					$mail->Body = '
					 
					Please click this link to reset your passsword:
					
					http://php.project.com/reset_password_form.php?q='.base64_encode($value["token"]).'&t='.base64_encode((time()+60)).'
					 ';
					$mail->IsSMTP();
					$mail->SMTPSecure = 'ssl';
					$mail->Host = 'ssl://smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Port = 465;

					include_once 'mail_credentials.php';
					$mail->Username = $mail_username;

					$mail->Password = $mail_password;
					if(!$mail->send()) {
					  $msg = 'Email is not sent.'. 'Email error: ' . $mail->ErrorInfo;
					}
				}
			}
		    else
		    {
		    	$msg = "The username you entered is not valid";
		    }
		}
		else
		{
			$msg = "Please enter a username";
		}
	}