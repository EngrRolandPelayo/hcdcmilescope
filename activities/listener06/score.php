<?php
session_start();

// pdo connection

function pdo(){
	$ms_conn = new PDO("mysql:host=localhost:3306;dbname=ms_database", "root", "");
	$ms_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $ms_conn;
}


// update score

function insertScore($sid, $test, $score, $table)
	{
	$conn = pdo();
	if ($score == 56)
		{
		$nscore = 1;
		$color = $test;
		$color2 = $test;
		}
	elseif($score == 0)
		{
		$nscore = 0;
		$color = "none";
		$color2 = "none";
		}
	else
		{
		$nscore = .5;
		$color = "";
		$color2 = $test;
		}

	$date = date('Y-m-d');
	$stmt = $conn->prepare('SELECT student_score FROM ms_students WHERE student_id = ?');
	$stmt->execute([$sid]);
	$newscore = json_decode($stmt->fetch(PDO::FETCH_OBJ)->student_score)->$test->score + $nscore;
	$stmt = $conn->prepare("UPDATE ms_students SET student_score = JSON_REPLACE(student_score, '$.{$test}.score', '{$newscore}'), student_score = JSON_REPLACE(student_score, '$.{$test}.date', '{$date}') WHERE student_id = ?");
	$result = $stmt->execute([$sid]);

	if($result){
	$json = json_decode('[{"id":"row9","cell":"99","color":"'.$color.'"},{"id":"row10","cell":"111","color":"'.$color2.'"}]');

	foreach($json as $row => $key)
	{	
			$string = '"' . $key->cell . '"';
			$stmt = $conn->prepare("UPDATE ms_students SET student_analysis = JSON_REPLACE(student_analysis, '$.{$table}.{$key->id}.{$string}', '{$key->color}') WHERE student_id = ?");
			$stmt->execute([$sid]);
			$stmt = null; // close conn
	}
	}
	$stmt = null;
	return true;
	}

$student_id = $_POST["id"];
$student_score = $_POST["score"];
$student_test = $_POST["test"];
$table = $_POST["loc"];
$insertScore = insertScore($student_id, $student_test, $student_score, $table);

