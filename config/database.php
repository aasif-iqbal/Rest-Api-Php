<?php

class Database {

	private $hostname;
	private $username;
	private $password;
	private $database;

	private $conn;

	public function connect() {

		$this->hostname = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->database = "rest-api-php";

		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);

		if ($this->conn->connect_errno) {
			print_r($this->conn->connect_error);
			exit;
		} else {
			//echo ("connect");
			return $this->conn;
		}
	}
}

//$db = new Database();
