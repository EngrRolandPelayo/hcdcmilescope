<?php
session_start();
// Database
try{
	$ms_conn = new PDO("mysql:host=localhost:3306;dbname=ms_database", "root", "");
	$ms_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch (PDOException $error){
	die($error->getMessage());
}

//csrf check
if (isset($_POST['ms_token']) && $_POST['ms_token'] === $_SESSION['ms_token']) {
$info = json_decode(json_encode($_POST["data"]));


if(!empty($info->username && $info->password)){

	$stmt = $ms_conn->prepare("SELECT username, password FROM ms_admin WHERE username = ?");
	$stmt->execute([$info->username]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if($result === false){
		$message = array('status' => 'danger', 'message' => 'Login Failed');
	}else{
 		$verifypass = password_verify($info->password, $result['password']);

 		if($verifypass){
		$_SESSION['authorize'] = $info->username;
		$message = array('status' => 'success', 'message' => 'Login Success'); 			
 		}else{
 		$message = array('status' => 'danger', 'message' => 'Login Failed');	
 	}
	}



}else{
	$message = array('status' => 'danger', 'message' => 'Some Field Is Empty');
}


die(json_encode($message));
}