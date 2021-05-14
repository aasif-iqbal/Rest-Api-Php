<?php

class Student {

	public $students_id;
	public $name;
	public $email;
	public $mobile;

	private $conn;
	private $table_name;

	public function __construct($db) {
		$this->conn = $db;
		$this->table_name = "students_tbl";
	}

	//Create Data Records
	public function create_student_record() {

		//prepare
		$obj = $this->conn->prepare("INSERT INTO " . $this->table_name . "(name, email, mobile)
			VALUES (?, ?, ?)");

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->mobile = htmlspecialchars(strip_tags($this->mobile));

		//bind params
		$obj->bind_param("sss", $this->name, $this->email, $this->mobile);

		//execute
		if ($obj->execute()) {
			return true;
		} else {
			return false;
		}

	}

	//Read all data
	public function get_all_data() {
		$query = "SELECT * FROM " . $this->table_name . "";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->get_result();
	}

	//fetch single record
	public function get_single_student_record() {

		$query = "SELECT * FROM " . $this->table_name . " WHERE students_id = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("i", $this->students_id);
		$stmt->execute();
		$data = $stmt->get_result();

		return $data->fetch_assoc();
	}

	//update information
	public function update_student_record() {

		$query = "UPDATE " . $this->table_name . " SET name=?, email=?, mobile=? WHERE students_id=?";

		//prepare
		$stmt = $this->conn->prepare($query);

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->mobile = htmlspecialchars(strip_tags($this->mobile));
		//where-sequence is important
		$this->students_id = htmlspecialchars(strip_tags($this->students_id));
		
		// var_dump($this->students_id);
		// //check id is present in database or not.
		// $sqlQuery = "SELECT * FROM " . $this->table_name . "";
		// $results = $this->conn->query($sqlQuery);

		// foreach ($results as $row) {
		// 	if ($row['students_id'] == $this->students_id) {
		// 		echo ("Found students_id");
		// 	}
		// }
		//echo ("Id is Not Present in Database");
		//return false;

		//bind query
		$stmt->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->students_id);
                
		//execute
		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	//delete - student information
	public function delete_student_record() {

		$query = "DELETE FROM " . $this->table_name . " WHERE students_id=?";

		$stmt = $this->conn->prepare($query);

		$this->students_id = htmlspecialchars(strip_tags($this->students_id));

		$stmt->bind_param("i", $this->students_id);

		if ($stmt->execute()) {
			return true;
		}
		return false;
	}

	//search - name field
	public function search_by_name(){
			
		$name = isset($_GET['name']) ? strval($_GET['name']) : "";
	
		$query = "SELECT * FROM ".$this->table_name." WHERE name LIKE '%".$name."%'";

		$stmt = $this->conn->prepare($query);
		
			$stmt->execute();

			$data = $stmt->get_result();

    		return $data->fetch_assoc();
	}

}