<?php

	$array = array("givenname" => "", "surname" => "", "mail" => "", "tel" => "", "message" => "", "givennameError" => "", "surnameError" => "", "mailError" => "", "telError" => "", "messageError" => "", "isallvalidate" => false);

	$myEmail = "pascalkourouma27@gmail.com";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$array["givenname"] = checkinput($_POST['givenname']);
		$array["surname"] = checkinput($_POST['surname']);
		$array["mail"] = checkinput($_POST['mail']);
		$array["tel"] = checkinput($_POST['tel']);
		$array["message"] = checkinput($_POST['message']);
		$array["isallvalidate"] = true;
		$emailText = "";

		if(empty($array["givenname"]))
		{
			$array["givennameError"] = "I need your given name to identifty you";
			$array["isallvalidate"] = false;
		}
		else
		{
			$emailText .= "Given name : {$array["givenname"]}\n";
		}

		if(empty($array["surname"]))
		{
			$array["surnameError"] = "And your surname as well";
			$array["isallvalidate"] = false;
		}
		else
		{
			$emailText .= "Surname: {$array["surname"]}\n";
		}

		if(!isEmail($array["mail"]))
		{
			$array["mailError"] = "Please enter a valid email address!";
			$array["isallvalidate"] = false;
		}
		else
		{
			$emailText .= "Email : {$array["mail"]}\n";
		}

		if(!isTel($array["tel"]))
		{
			$array["telError"] ="Digits and Spaces please";
			$array["isallvalidate"] = false;
		}
		else
		{
			$emailText .= "Phone number : {$array["tel"]}\n";
		}

		if(empty($array["message"]))
		{
			$array["messageError"] = "What are you trying to tell me ?";
			$array["isallvalidate"] = false;
		}
		else
		{
			$emailText .= "Message : {$array["message"]}\n";
		}

		if($array["isallvalidate"])
		{
			$headers = "From: {$array["givenname"]} {$array["surname"]} <{$array["mail"]}>\r\nReply To : {$array["mail"]}";
			mail($myEmail, "Un message de mon site", $emailText, $headers);
		}

		echo json_encode($array);
	}

	function checkinput($var)
	{
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlspecialchars($var);
		return $var;
	}
	function isEmail($var)
	{
		return filter_var($var, FILTER_VALIDATE_EMAIL);
	}
	function isTel($var)
	{
		return preg_match("/^[0-9 ]*$/",$var);
	}
?>