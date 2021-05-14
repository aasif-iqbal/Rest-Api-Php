<?php
ini_set("display_errors", 1);
//headers
header("Access-Control-Allow-Origin: *"); //* => allow all origin ie localhost,domain,subdomain.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); //accept only GET request
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

	$students_id = isset($_GET['students_id']) ? intval($_GET['students_id']) : "";

	if (!empty($students_id)) {

		//initilize student_id
		$student->students_id = $students_id;

		if ($student->delete_student_record()) {
			//Ok
			http_response_code(200);

			echo json_encode(array(
				'status' => 1,
				'message' => 'Record Deleted Successfully',
			));
		} else {
			//Internal Server Error
			http_response_code(500);

			echo json_encode(array(
				'status' => 0,
				'message' => 'Internal Server Error',
			));
		}
	} else {
		//Data Not Found
		http_response_code(404);

		echo json_encode(array(
			'status' => 0,
			'message' => 'Data Not Found',
		));
	}
} else {
	//status code:Service Unavailable
	http_response_code(503);

	echo json_encode(array(
		'status' => 0,
		"message" => "Access Denined",
	));
}