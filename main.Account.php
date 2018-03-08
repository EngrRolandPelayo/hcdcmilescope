<?php
error_reporting(0);
session_start();

include 'main.Class.php'; 
$account = new Account();


$request = $_POST["req"];
switch($request){
	case 'info' : 
	die($account->getAccount($_POST["sid"]));
	break;
	case 'update' : 
	die($account->updateAccount($_POST["data"]));
	break;
	case 'delete' :
	die($account->deleteAccount($_POST["data"]));
	break;
	default:
	die($account->getAccounts(json_encode(array("search" => $_POST["search"]["value"], "order" =>  $_POST['order'], "ordercol" => $_POST['order']['0']['column'], "orderdir" => $_POST['order']['0']['dir'], "start" => $_POST['start'], "length" => $_POST['length'], "draw" => $_POST["draw"]))));
}
