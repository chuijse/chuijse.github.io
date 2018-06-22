<?php  

	
	function clean_input($input){
			return strip_tags(trim($input));
	}
	if( isset($_POST) ){  

	//form validation vars  
	$formok = true;  
	$errors = array();  

	//sumbission data  
	$ipaddress = $_SERVER['REMOTE_ADDR'];  
	$date = date('d/m/Y');  
	$time = date('H:i:s');  

	//form data  
	$name = clean_input($_POST['name']);  
	$email = clean_input($_POST['email']);  
	$telephone = clean_input($_POST['phone']);  
	$enquiry = clean_input($_POST['enquiry']);  
	$website = clean_input($_POST['url']);  
	$message = clean_input($_POST['message']);  

	if(empty($name)){  
		$formok = false;  
		$errors[] = "You have not entered a name";  
	}

	if(empty($email)){  
		$formok = false;  
		$errors[] = "You have not entered an email address";  
	//validate email address is valid  
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){  
		$formok = false;  
		$errors[] = "You have not entered a valid email address";  
	}  

	if(empty($message)){  
		$formok = false;  
		$errors[] = "You have not entered a message";  
	}  
	//validate message is greater than 20 charcters  
	//elseif(strlen($message) < 20){  
	//	$formok = false;  
	//	$errors[] = "Your message must be greater than 20 characters";  
	//}  
	
	$to ="cristian.huijse@gmail.com";
	
	if($formok){  
		$headers = "From: $email" . "\r\n";  
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  

		$emailbody = "<p>You have recieved a new message from the enquiries form on your website.</p> 
			  <p><strong>Name: </strong> {$name} </p> 
			  <p><strong>Email Address: </strong> {$email} </p> 
			  <p><strong>Telephone: </strong> {$telephone} </p> 
			  <p><strong>Website: </strong> {$website} </p> 
			  <p><strong>Message: </strong> {$message} </p> 
			  <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";  

		$sent=mail($to,"[$enquiry] New Enquiry",$emailbody,$headers);  
  
	}  
	if($sent) {
		print "Your mail was sent successfully"; 
		} 
	else {
		print "We encountered an error sending your mail"; 
	} 
		 
	//what we need to return back to our form  
	$returndata = array(  
		'posted_form_data' => array(  
			'name' => $name,  
			'email' => $email,  
			'telephone' => $telephone,  
			'website' => $website,  
			'enquiry' => $enquiry,  
			'message' => $message  
		),  
		'form_ok' => $formok,  
		'errors' => $errors  
	);  

	//if this is not an ajax request  
	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){  
		//set session variables  
		session_start();  
		$_SESSION['cf_returndata'] = $returndata;  

		//redirect back to form  
		header('location: ' . $_SERVER['HTTP_REFERER']);  
	}  

}  
