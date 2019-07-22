<?php 
	 
	$msg = "";
	$username_msg = "";
	$firstname_msg = "";
	$lastname_msg = "";
	$email_msg = "";
	$password_msg = "";
	include_once 'db_credentials.php';
	include_once 'db_connection.php';
	include_once 'validate_input.php';
	require_once '/usr/share/php/libphp-phpmailer/class.phpmailer.php';
	require_once '/usr/share/php/libphp-phpmailer/class.smtp.php';
	include_once 'mail_credentials.php';

    $obj = new DB_connect();
	$table = "users";
    if (Token::check($_POST['token'])) {
		if (isset($_POST['fname']) && !empty($_POST['fname'])) {
			$firstname = Validation::test_input($_POST['fname']);
			$fname_test = Validation::validate_name($firstname);
			if ($fname_test) {
				$columns = array("firstname" => $_POST['fname']);
			    $conditions = array("username" => $_SESSION['username']);
			    $obj->update($conn, $table, $columns, $conditions);
				//$query = "UPDATE users SET firstname = '".$_POST['fname']."' WHERE username = '".$_SESSION['username']."'";
			}

			else {
				$firstname_msg = "Invalid name format";
			}
		}

		if (isset($_POST['lname']) && !empty($_POST['lname'])) {
			$lastname = Validation::test_input($_POST['lname']);
			$lname_test = Validation::validate_name($lastname);
			if ($lname_test) {
				$columns = array("lastname" => $_POST['lname']);
			    $conditions = array("username" => $_SESSION['username']);
			    $obj->update($conn, $table, $columns, $conditions);
				//$query = "UPDATE users SET lastname = '".$_POST['lname']."' WHERE username = '".$_SESSION['username']."'";
			}

			else {
				$lastname_msg = "Invalid name format";
			}
		}

		if (isset($_POST['password']) && !empty($_POST['password'])) {
			$password = Validation::test_input($_POST['password']);
			$password_test = Validation::validate_name($password);
			if ($password_test) {
				$pass = md5($_POST['password']);
				$columns = array("password" => $pass);
			    $conditions = array("username" => $_SESSION['username']);
			    $obj->update($conn, $table, $columns, $conditions);
				//$query = "UPDATE users SET password = '".md5($_POST['password'])."' WHERE username = '".$_SESSION['username']."'";
			}

			else {
				$password_msg = "Invalid password format";
			}
		}

		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$email = Validation::test_input($_POST['email']);
			$email_test = Validation::validate_name($email);
			if ($email_test) {
				$query = "SELECT id FROM users WHERE email = '".$_POST['email']."'";
				$result = $obj->select_records($conn, $query);
				if ($result) {
					$email_msg = "Email Id already exists";
				}

				else {
					$query = "SELECT email_verification_code FROM users WHERE username = '".$_SESSION['username']."'";
					$result = $obj->select_records($conn, $query);
					foreach ($result as $key => $value) {
						$hash = $value['email_verification_code'];
					}
					$columns = array("email_verification_status" => 0);
				    $conditions = array("username" => $_SESSION['username']);
				    $obj->update($conn, $table, $columns, $conditions);
					//$query = "UPDATE users SET email_verification_status = 0 WHERE username = '".$_SESSION['username']."'";
					
					$mail = new PHPMailer;
					$mail->setFrom('spriha.mindfire@gmail.com');
					$mail->addAddress(''.$_POST['email'].'');
					$mail->Subject = 'Email Updation | Verification';
					$mail->Body = '
					 
					Please click this link to update your email:
					
					http://php.project.com/update_mail.php?q='.base64_encode($hash).'&q1='.base64_encode($_POST['email']).'
					 
					 ';
					$mail->IsSMTP();
					$mail->SMTPSecure = 'ssl';
					$mail->Host = 'ssl://smtp.gmail.com';
					$mail->SMTPAuth = true;
					$mail->Port = 465;

					$mail->Username = $mail_username;
					$mail->Password = $mail_password;
					if (!$mail->send()) {
					  $email_msg = 'Email is not sent.'. 'Email error: ' . $mail->ErrorInfo;
					}
					else {
						$email_msg = "Please verify it by clicking the activation link that has been send to your email.";
					}
				}
			}
			else {
				$email_msg = "Invalid email format";
			}
		}

		if (isset($_POST['username']) && !empty($_POST['username'])) {
			$username = Validation::test_input($_POST['username']);
			$username_test = Validation::validate_name($username);
			if ($username_test) {
				$query = "SELECT id FROM users WHERE username = '".$_POST['username']."'";
				$result = $obj->select_records($conn, $query);
				if ($result) {
					$username_msg = "Username already exists";
				}
				else {
					$columns = array("username" => $_POST['username']);
				    $conditions = array("username" => $_SESSION['username']);
				    $obj->update($conn, $table, $columns, $conditions);
					//$query = "UPDATE users SET username = '".$_POST['username']."' WHERE username = '".$_SESSION['username']."'";
				}
				//header("Location:logout.php");
			}
			else {
				$username_msg = "Invalid username format";
			}
		}
	}
 ?>