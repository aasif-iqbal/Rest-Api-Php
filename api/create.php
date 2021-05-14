<?php
//headers
header("Access-Control-Allow-Origin: *"); //* => allow all origin ie localhost,domain,subdomain.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); //accept only POST request
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../classes/student.php';

//create object for database
$db = new Database();
$connection = $db->connect();
//create object for student
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	//getting data from body
	$data = json_decode(file_get_contents("php://input"));

	if (!empty($data->name && !empty($data->email) && !empty($data->mobile))) {

		$student->name = $data->name;
		$student->email = $data->email;
		$student->mobile = $data->mobile;

		//submit data
		if ($student->create_student_record()) {
			//status code:200 Ok
			http_response_code(200);
			echo json_encode(array(
				"status" => 1,
				"message" => "data insert successfully",
			));
		} else {
			//status code:500 internal server error
			http_response_code(500);
			echo json_encode(array(
				"status" => 0,
				"message" => "Failed to insert data",
			));
		}
	} else {
		//status code:404 File Not Found
		http_response_code(404);
		echo json_encode(array(
			"status" => 0,
			"message" => "All values needed",
		));
	}
} else {
	//status code:503 "Service Unavailable"
	http_response_code(503);
	echo json_encode(array(
		"status" => 0,
		"message" => "Access Denined",
	));
}