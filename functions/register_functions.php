<?php
function register($user_name, $password, $org_name, $email, $code, $db) {
	include 'conf/main_config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO users (id, user_name, password, org_name, email, code, db)
	VALUES ('', '$user_name', '$password', '$org_name', '$email', '$code', '$db')";

	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}


function send_mail_for_activation($org_name, $user_name, $email){


	$mail = new PHPMailer();

	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "mail.myrakiyawa.com";                 // specify main and backup server
	$mail->SMTPAuth = true;                             // turn on SMTP authentication
	$mail->Username = "admin+myrakiyawa.com";         // SMTP username
	$mail->Password = "rakiyawa1";                     // SMTP password

	$mail->From = "admin@myrakiyawa.com";
	$mail->FromName = "Activation Process";
	$mail->AddAddress("$email", "$org_name");
	//$mail->AddAddress("ellen@example.com");                  // name is optional
	$mail->AddReplyTo("admin@myrakiyawa.com", "Information");

	$mail->WordWrap = 50;                                    // set word wrap to 50 characters
	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");   // optional name
	$mail->IsHTML(true);                                  // set email format to HTML

	$mail->Subject = "Mail for activate your account";
	$mail->Body    = "Dear Member,<br />
					Thank you for register with accountant.lk. “The Perfect place to maintain your business”
					 your username and password is given below, please save this and keep it confidential for security purpose. 
					 To activate your account kindly follow the steps below,<br /><br />
					$org_name,<br /><br />
					Your Username - $user_name <br />
					Your Password - ********** <br /><br />
					Step 1 : To enjoy the full benefits offered by us, kindly activate your account by making the relevant payment to the following bank account,<br />
					<br />
					Amount  (Annual Fee)         :15,000/- (Fifteen Thousand) <br />
					Account Name            	 :Scriptmen.com <br />
					Bank                         :Commercial Bank, Kollupitiya, Colombo 03 <br />
					Bank A/C No  	             :1108569701 <br /><br />
					Step 2 : Upon completion of your payment, please call or send a SMS to our administrator in the following numbers for quick activation. 
					In the event if you do not call or SMS your activation will be delayed. <br /><br />
					Contact No                   : +94 75 215 1580 or +94 77 22 41 925 <br />
					Thank you for registering with us, we wish you a happy experience with us";
	$mail->AltBody = "Dear Member,
					Thank you for register with accountant.lk. “The Perfect place to maintain your business”
					 your username and password is given below, please save this and keep it confidential for security purpose. 
					 To activate your account kindly follow the steps below,
					 
					$company_name,
					Your Username - $user_name 
					Your Password - ********** 
					Step 1 : To enjoy the full benefits offered by us, kindly activate your account by making the relevant payment to the following bank account,
					
					Amount  (Annual Fee)         :15,000/- (Fifteen Thousand) 
					Account Name            	 :Scriptmen.com
					Bank                         :Commercial Bank, Kollupitiya, Colombo 03 
					Bank A/C No  	             :1108569701
					Step 2 : Upon completion of your payment, please call or send a SMS to our administrator in the following numbers for quick activation. 
					In the event if you do not call or SMS your activation will be delayed. 
					
					Contact No                   : +94 77 237 60 60 or +94 77 22 41 925 
					
					Thank you for registering with us, we wish you a happy experience with us";
	if(!$mail->Send())
	{

		exit;
	}

}

function send_mail_for_password_reset($email){
	
$user_info=get_employee_info_by_email($email);
$full_name=$user_info[full_name];
$user_name=$user_info[user_name];
$activation_code=$user_info[activation_code];



	$mail = new PHPMailer();

	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "mail.myrakiyawa.com";                 // specify main and backup server
	$mail->SMTPAuth = true;                             // turn on SMTP authentication
	$mail->Username = "admin+myrakiyawa.com";         // SMTP username
	$mail->Password = "rakiyawa1";                     // SMTP password

	$mail->From = "admin@myrakiyawa.com";
	$mail->FromName = "Password Reset Code";
	$mail->AddAddress("$email", "$full_name");
	//$mail->AddAddress("ellen@example.com");                  // name is optional
	$mail->AddReplyTo("admin@myrakiyawa.com", "Information");

	$mail->WordWrap = 50;                                    // set word wrap to 50 characters
	//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");   // optional name
	$mail->IsHTML(true);                                  // set email format to HTML

	$mail->Subject = "Mail for reset your account password";
	$mail->Body    = "Hi <strong>$full_name, <br />
			Your Username - $user_name <br />
			Code - $activation_code<br />
			Reset Link - <a href='www.myrakiyawa.com/forget.php'>Reset</a>
			</strong>";
	$mail->AltBody = "Your Username - $user_name
			Code - $activation_code
			Reset Link - www.myrakiyawa.com/forget.php";
	if(!$mail->Send())
	{

		exit;
	}

}

function check_mail_and_code($email, $code){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		if(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM employee WHERE email = '$email' AND activation_code='$code'"))){

			return 1;
		}
		else{
			return 0;
		}

	include 'conf/closedb.php';
	
}

function update_password($email, $password){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE employee SET
	password='$password'  
	WHERE email='$email' AND active='1'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


