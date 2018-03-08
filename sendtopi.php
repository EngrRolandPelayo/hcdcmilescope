<?php
$code = $_POST['code'];

switch($code){
	case 'practice':
        	echo '<pre>';
		system('sudo sh export DISPLAY=:0');
		exec("sudo -u pi /home/pi/./practice.sh 2<&1",$output);
        	echo json_encode($output);
		echo '</pre>';
		break;
	default:
		break;
}

?>
