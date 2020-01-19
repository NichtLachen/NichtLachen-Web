<?php

$root = dirname(__FILE__);
require_once ($root . '/Database.php');
require_once ($root . '/../user/User.php');

class DatabaseAPI {

	private Database $database;

	public function __construct() {
		$database = new Database();
	}

	private function getUser(

	public function getUserByName(string $name) : User {
		$stmt = $database->conn->prepare("SELECT * FROM users WHERE Name = :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			
		}

		return null;
	}

}

?>
