<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *"); //* => allow all origin ie localhost,domain,subdomain.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); //accept only get request
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../classes/student.php';

//create object for database
$db = new Database();
$connection = $db->connect();
//create object for student
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$data = $student->get_all_data();

	if ($data->num_rows > 0) {

		$students["records"] = array();

		//diff bwt arry, obj as assoc.
		//while ($row = $data->fetch_array()) {
		//while ($row = $data->fetch_object()) {
		while ($row = $data->fetch_assoc()) {
			array_push($students['records'], array(
				'students_id' => $row['students_id'],
				'name' => $row['name'],
				'email' => $row['email'],
				'mobile' => $row['mobile'],
				'status' => $row['status'],
				'created_at' => date("y-m-d", strtotime($row['created_at'])),
			));
		}

		//status code:Ok
		http_response_code(200);
		echo json_encode(array(
			"status" => 1,
			"data" => $students['records'],
		));
	}
} else {
	//status code:Service Unavailable
	http_response_code(503);
	echo json_encode(array(
		"status" => 0,
		"message" => "Access Denined",
	));
}