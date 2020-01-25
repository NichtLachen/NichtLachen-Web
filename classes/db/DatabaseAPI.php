<?php

require_once (dirname(__FILE__) . '/Database.php');
require_once (dirname(__FILE__) . '/../user/User.php');

class DatabaseAPI {

	private Database $database;

	public function __construct() {
		$this->database = new Database();
	}

	private function getUser(array_map $row) : ?User {
	}

	public function addUser(string $name, string $email, string $password) {
		$stmt = $this->database->conn->prepare("INSERT INTO users (Name, EMail, Password) VALUES (:name, :email, :password)");
		$stmt->execute(array("name" => $name, "email" => $email, "password" => $password));
	}

	public function getUserByName(string $name) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE Name LIKE :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			return new User($row['UID'], $row['Name'], $row['EMail'], $row['Description'], $row['Rank']);
		}

		return null;
	}

	
	public function getUserByEMail(string $email) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		foreach ($stmt as $row) {
			return new User($row['UID'], $row['Name'], $row['EMail'], $row['Description'], $row['Rank']);
		}

		return null;
	}

	public function verify(string $name, string $email, string $password) : string {
		$vid = uniqid();
		$stmt = $this->database->conn->prepare("INSERT INTO verify (VID, Name, Password, EMail, ExpiresAT) VALUES (:vid, :name, :password, :email, NOW() + INTERVAL 1 DAY)");
		$stmt->execute(array("vid" => $vid, "name" => $name, "password" => $password, "email" => $email));

		return $vid;
	}

	public function verifyEnable(string $vid) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE VID LIKE :vid");
		$stmt->execute(array("vid" => $vid));

		foreach ($stmt as $row) {
			$this->addUser($row['Name'], $row['EMail'], $row['Password']);
			$stmt = $this->database->conn->prepare("DELETE FROM verify WHERE VID LIKE :vid");
			$stmt->execute(array("vid" => $vid));
			return true;
		}

		return false;
	}
}

?>
