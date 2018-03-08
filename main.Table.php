<?php 
session_start();
include 'main.Class.php'; 
$student = new Student();
// CSRF check
if (isset($_POST['ms_token']) && $_POST['ms_token'] === $_SESSION['ms_token']) {
$request = $_POST['req'];
switch($request){
	case 'users' : 
		 die(json_encode($student->getList()));
		break;
	case 'tables' : 
		die($student->getTable($_POST['sid']));
		break;
	case 'update' : 
		die($student->updateTable($_POST['data']));
		break;
	case 'note' : 
		die($student->addNote($_POST['data']));
		break;
	case 'notes' : 
		die($student->getNote($_POST['data']));
		break;
	case 'score' : 
		die($student->getScore($_POST['sid']));
		break;
	case 'search':
		die(json_encode($student->searchStudent($_POST['query'])));
		break;
	default:
	die('Unable to Handle Request');
}
}
