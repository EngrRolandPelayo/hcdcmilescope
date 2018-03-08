<?php
class Database

	{
	protected $ms_conn;
	protected $ms_host = 'localhost:3306'; // 3306 = MySql (JSON supported make sure your version is 5.7 or later) || 3307 = MariadDB (not supported CAST JSON may cause query ERROR!)
	protected $ms_user = 'root';
	protected $ms_pass = '';
	protected $ms_db = 'ms_database';

	// create pdo connection ms

	public

	function __construct()
		{
		try
			{
			$this->ms_conn = new PDO("mysql:host=$this->ms_host;dbname=$this->ms_db", $this->ms_user, $this->ms_pass);
			}

		catch(PDOException $error)
			{
			die($error->getMessage());
			}
		}
	}

class Student extends Database

	{

	// cell name generator

	public

	function cellNC($check, $cid, $mod)
		{
		if ($check % 2 == 0)
			{
			$result = $cid - $mod;
			}
		  else
			{
			$result = $cid + $mod;
			}

		$result = $result + $cid;
		return "cc" . $result;
		}

	// json cell checker

	public

	function cellCC($sid, $tid, $cid)
		{
		$stmt = $this->ms_conn->prepare("SELECT student_notes FROM `ms_students` WHERE JSON_CONTAINS_PATH(student_notes, 'all','$.{$tid}.{$cid}.notes') AND student_id = ?");
		$stmt->execute([$sid]);
		$result = $stmt->rowCount();
		return $result;
		}

	public

	function insertNote($sid, $tid, $cid, $note, $date, $source)
		{
		$json = '{"date" : "' . $date . '" , "note": "' . $note . '" , "source":"' . $source . '"}';
		$stmt = $this->ms_conn->prepare("UPDATE ms_students SET student_notes = JSON_ARRAY_APPEND(student_notes, '$.{$tid}.{$cid}.notes', CAST('$json' AS JSON)), student_notes = JSON_REPLACE(student_notes, '$.{$tid}.{$cid}.updated', '{$date}') WHERE student_id = ?");
		$stmt->execute([$sid]);
		}

	public

	function insertScore($sid, $test, $score)
		{
		$date = date('Y-m-d');
		if ($score == 1)
			{
			$score = .5;
			}
		  else
		if ($score == 2)
			{
			$score = 1;
			}

		$stmt = $this->ms_conn->prepare('SELECT student_score FROM ms_students WHERE student_id = ?');
		$stmt->execute([$sid]);
		$newscore = json_decode($stmt->fetch(PDO::FETCH_OBJ)->student_score)->$test->score + $score;
		$stmt = $this->ms_conn->prepare("UPDATE ms_students SET student_score = JSON_REPLACE(student_score, '$.{$test}.score', '{$newscore}'), student_score = JSON_REPLACE(student_score, '$.{$test}.date', '{$date}') WHERE student_id = ?");
		$stmt->execute([$sid]);
		$stmt = null;
		}

	public

	function fetchNote($sid)
		{
		$stmt = $this->ms_conn->prepare('SELECT student_notes FROM ms_students WHERE student_id = ?');
		$stmt->execute([$sid]);
		$result = $stmt->fetch(PDO::FETCH_OBJ)->student_notes;
		$result = json_decode($result);
		return $result;
		}

	// List of Students

	public

	function getList()
		{
		$result = array();
		$stmt = $this->ms_conn->prepare('SELECT student_id,student_fname,student_lname FROM ms_students');
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		foreach($data as $row)
			{
			$result[] = array(
				'id' => $row->student_id,
				'fname' => $row->student_fname,
				'lname' => $row->student_lname
			);
			}

		return $result;
		$stmt = null; // close conn
		}

	// Get the table info of a student

	public

	function getTable($id)
		{
		$stmt = $this->ms_conn->prepare('SELECT student_analysis FROM ms_students WHERE student_id = ?');
		$stmt->execute([$id]);
		$result = $stmt->fetch(PDO::FETCH_OBJ)->student_analysis;
		return $result;
		$stmt = null; // close conn
		}

	public

	function getScore($sid)
		{
		$stmt = $this->ms_conn->prepare('SELECT student_score FROM ms_students WHERE student_id = ?');
		$stmt->execute([$sid]);
		$response = json_decode($stmt->fetch(PDO::FETCH_OBJ)->student_score);
		if ($response->t1->score != 0)
			{
			$score1 = $response->t1->score / 170 * 100;
			}
		  else
			{
			$score1 = 0;
			}

		if ($response->t2->score != 0)
			{
			$score2 = $response->t1->score + $response->t2->score / 170 * 100;
			}
		  else
			{
			$score2 = 0;
			}

		if ($response->t3->score != 0)
			{
			$score3 = $response->t1->score + $response->t2->score + $response->t3->score / 170 * 100;
			}
		  else
			{
			$score3 = 0;
			}

		if ($response->t4->score != 0)
			{
			$score4 = $response->t1->score + $response->t2->score + $response->t3->score + $response->t4->score / 170 * 100;
			}
		  else
			{
			$score4 = 0;
			}

		$result = json_encode(array(
			"TEST 1" => array(
				"score" => round($score1),
				"date" => $response->t1->date,
				"color" => "t1"
			) ,
			"TEST 2" => array(
				"score" => round($score2),
				"date" => $response->t2->date,
				"color" => "t2"
			) ,
			"TEST 3" => array(
				"score" => round($score3),
				"date" => $response->t3->date,
				"color" => "t3"
			) ,
			"TEST 4" => array(
				"score" => round($score4),
				"date" => $response->t4->date,
				"color" => "t4"
			)
		));
		return $result;
		}

	// Get the notes info of a student

	public

	function getNote($data)
		{
		$info = json_decode(json_encode($data));
		switch ($info->tid)
			{
		case 'table1':
			$mod = 9;
			break;

		case 'table2':
			$mod = 12;
			break;

		default:
			$mod = 13;
			}

		$table = $info->tid;
		$cell = $this->cellNC($info->check, $info->cid, $mod);
		$verify = $this->cellCC($info->sid, $info->tid, $cell);
		$response = [];
		if ($verify == 0)
			{
			$insert = '{"notes":[],"updated":""}';
			$stmt = $this->ms_conn->prepare("UPDATE ms_students SET student_notes = JSON_REPLACE(student_notes, '$.{$info->tid}.{$cell}', CAST('$insert' AS JSON)) WHERE student_id = ?");
			$result = $stmt->execute([$info->sid]);
			if ($result)
				{
				$fetch = $this->fetchNote($info->sid);
				foreach($fetch->$table->$cell->notes as $data)
					{
					$response[] = array(
						'name' => $data->source,
						'note' => $data->note,
						'date' => $data->date
					);
					}
				}
			}
		  else
			{
			$fetch = $this->fetchNote($info->sid);
			foreach($fetch->$table->$cell->notes as $data)
				{
				$response[] = array(
					'name' => $data->source,
					'note' => $data->note,
					'date' => $data->date
				);
				}
			}

		return json_encode($response);
		$stmt = null; // close conn
		}

	// Update the table cell color

	public

	function updateTable($data)
		{
		$info = json_decode(json_encode($data));
		switch ($info->tid)
			{
		case 'table1':
			$mod = 9;
			break;

		case 'table2':
			$mod = 12;
			break;

		case 'table3':
			$mod = 13;
		default:
			$mod = 0;
			}

		$cell = $this->cellNC($info->check, $info->cid, $mod);
		$verify = $this->cellCC($info->sid, $info->tid, $cell);
		if ($verify == 0)
			{
			$insert = '{"notes":[],"updated":""}';
			$stmt = $this->ms_conn->prepare("UPDATE ms_students SET student_notes = JSON_REPLACE(student_notes, '$.{$info->tid}.{$cell}', CAST('$insert' AS JSON)) WHERE student_id = ?");
			$result = $stmt->execute([$info->sid]);
			if ($result)
				{
				$this->insertScore($info->sid, $info->test, $info->score);
				}
			}
		  else
			{
			$this->insertScore($info->sid, $info->test, $info->score);
			}

		foreach($info->row as $key)
			{
			$string = '"' . $key->cell . '"';
			$stmt1 = $this->ms_conn->prepare("UPDATE ms_students SET student_analysis = JSON_REPLACE(student_analysis, '$.{$info->tid}.{$key->id}.{$string}', '{$key->color}') WHERE student_id = ?");
			$stmt1->execute([$info->sid]);
			$stmt1 = null; // close conn
			}
		}

	// Add a note

	public

	function addNote($data)
		{
		$date = date('Y-m-d h:i:a');
		$source = "Admin"; // change to current loggedin admin or session
		$info = json_decode(json_encode($data));
		switch ($info->tid)
			{
		case 'table1':
			$mod = 9;
			break;

		case 'table2':
			$mod = 12;
			break;

		case 'table3':
			$mod = 13;
		default:
			$mod = 0;
			}

		$cell = $this->cellNC($info->check, $info->cid, $mod);
		$verify = $this->cellCC($info->sid, $info->tid, $cell);
		if ($verify == 0)
			{
			$insert = '{"notes":[],"updated":""}';
			$stmt = $this->ms_conn->prepare("UPDATE ms_students SET student_notes = JSON_REPLACE(student_notes, '$.{$info->tid}.{$cell}', CAST('$insert' AS JSON)) WHERE student_id = ?");
			$result = $stmt->execute([$info->sid]);
			if ($result)
				{
				$this->insertNote($info->sid, $info->tid, $cell, $info->note, $date, $source);
				}

			$stmt = null;
			}
		  else
			{
			$this->insertNote($info->sid, $info->tid, $cell, $info->note, $date, $source);
			}
		}

	// Search Student

	public

	function searchStudent($query)
		{
		$result = array();
		$stmt = $this->ms_conn->prepare('SELECT student_id,student_fname,student_lname FROM ms_students WHERE student_fname LIKE :fname OR student_lname LIKE :lname');
		$stmt->execute(array(
			'fname' => '%' . $query . '%',
			'lname' => '%' . $query . '%'
		));
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		foreach($data as $row)
			{
			$result[] = array(
				'id' => $row->student_id,
				'label' => "{$row->student_fname} {$row->student_lname}",
				'value' => "{$row->student_fname} {$row->student_lname}"
			);
			}

		return $result;
		$stmt = null; // close conn
		}
	}

class Account extends Database

	{
	public

	function totalAccounts()
		{
		$stmt = $this->ms_conn->prepare('SELECT * FROM ms_students');
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $stmt->rowCount();
		}

	public

	function getAccounts($data)
		{

		$info = json_decode($data);
		$stmtquery = '';
		$stmtquery.= "SELECT * FROM ms_students";
		if ($info->search)
			{

			$stmtquery.= ' WHERE student_fname LIKE "%' . $info->search . '%" ';
			$stmtquery.= ' OR student_lname LIKE "%' . $info->search . '%" ';
			}

		if ($info->order)
			{
			$stmtquery.= ' ORDER BY ' . $info->ordercol . ' ' . $info->orderdir . ' ';
			}
		  else
			{
			$stmtquery.= ' ORDER BY student_id ASC ';
			}

		if ($info->length != - 1)
			{
			$stmtquery.= ' LIMIT ' . $info->start . ', ' . $info->length;
			}

		$stmt = $this->ms_conn->prepare($stmtquery);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$data = array();
		$filtered_rows = $stmt->rowCount();
		foreach($result as $row)
			{
			$array = array();
			$array[] = $row["student_id"];
			$array[] = $row["student_fname"];
			$array[] = $row["student_lname"];
			$array[] = $row["student_age"];
			$array[] = $row["student_gender"];
			$array[] = $row["student_address"];
			$array[] = $row["student_parents"];
			$array[] = '<button type="button" data-id=' . $row["student_id"] . ' id="rupdate" class="btn btn-primary btn-sm">Edit</button> <button type="button" id="rdelete"  data-id=' . $row["student_id"] . ' class="btn btn-danger btn-sm ">Delete</button>';
			$data[] = $array;
			}

		$response = json_encode(array(
			"draw" => intval($info->draw) ,
			"recordsTotal" => $filtered_rows,
			"recordsFiltered" => $this->totalAccounts() ,
			"data" => $data
		));

		return $response;
		}

		function getAccount($sid){
			$stmt = $this->ms_conn->prepare('SELECT * FROM ms_students WHERE student_id = ?');
			$stmt->execute([$sid]);
			$data = $stmt->fetch(PDO::FETCH_OBJ);
			$response = json_encode(array("sid" => $data->student_id, "fname" => $data->student_fname, "lname" => $data->student_lname, "address" => $data->student_address));
			$stmt = null;
			return $response;
		}

		function deleteAccount($data){
			$info = json_decode(json_encode($data));

			$stmt = $this->ms_conn->prepare('DELETE FROM ms_students WHERE student_id = ?');
			$stmt->execute([$info->dsid]);
			$stmt = null;
			return json_encode($data);
		}

		function updateAccount($data){
			$info = json_decode(json_encode($data));

			$stmt = $this->ms_conn->prepare('UPDATE ms_students SET student_fname = ? , student_lname = ? , student_address = ? WHERE student_id = ?');
			$stmt->execute([$info->fname, $info->lname, $info->address, $info->sid]);
			$stmt = null;
			return json_encode($data);
		}


	}