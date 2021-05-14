<?php
ini_set("display_errors", 1); //for Debugging

header("Access-Control-Allow-Origin: *"); //* => allow all origin ie localhost,domain,subdomain.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); //accept only POST request
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
	
	$student_name = isset($_GET['name']) ? strval($_GET['name']) : "";
	
	$rawData = $student->search_by_name();

	if (!empty($rawData)) {
		//status code:200 "OK"
		http_response_code(200);
		echo json_encode(array(
			"status" => 1,
			"message" => $rawData,
		));	
	}else{
		//status code:404 "Not Data Found"
		http_response_code(404);
		echo json_encode(array(
			"status" => 0,
			"message" => "Not Data Found",
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