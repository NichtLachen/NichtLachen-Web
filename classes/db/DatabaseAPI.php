<?php

require_once (dirname(__FILE__) . '/Database.php');
require_once (dirname(__FILE__) . '/../user/User.php');

class DatabaseAPI {

	private Database $database;

	public function __construct() {
		$this->database = new Database();
	}

	private function getUser(array $row) : User {
		return new User($row['UID'], $row['Name'], $row['EMail'], $row['Description'], $row['Rank']);
	}

	public function addUser(string $name, string $email, string $password) {
		$stmt = $this->database->conn->prepare("INSERT INTO users (Name, EMail, Password) VALUES (:name, :email, :password)");
		$stmt->execute(array("name" => $name, "email" => $email, "password" => $password));
	}

	public function getUserByName(string $name) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE Name LIKE :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function getUserByEMail(string $email) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function getUserByUID(int $uid) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function verify(string $name, string $email, string $password) : string {
		$vid = uniqid("", true);
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

	public function isNameInVerification(string $name) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE Name LIKE :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function isEMailInVerification(string $email) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function authenticate(int $uid, string $password) : bool {
		$stmt = $this->database->conn->prepare("SELECT Password FROM users WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return password_verify($password, $row['Password']);
		}

		return false;
	}

	public function setSessionID(int $uid, string $sid) {
		$stmt = $this->database->conn->prepare("INSERT INTO sessions (SID, UID, ExpiresAt) VALUES (:sid, :uid, NOW() + INTERVAL 7 DAY)");
		$stmt->execute(array("uid" => $uid, "sid" => $sid));
	}

	public function getUIDBySessionID(string $sid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT UID FROM sessions WHERE SID = :sid");
		$stmt->execute(array("sid" => $sid));

		foreach ($stmt as $row) {
			return $row['UID'];
		}

		return null;
	}

	public function refreshSession(string $sid) {
		$stmt = $this->database->conn->prepare("UPDATE sessions SET ExpiresAt = NOW() + INTERVAL 7 DAY WHERE SID = :sid");
		$stmt->execute(array("sid" => $sid));
	}

	public function countPostLikes(int $pid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND POS = '1'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countPostDislikes(int $pid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND POS = '0'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countCommentLikes(int $cmtid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND POS = '1'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countCommentDislikes(int $cmtid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND POS = '0'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countFollowers(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(FollowerUID) FROM followers WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(FollowerUID)'];
		}

		return null;
	}


	public function countFollows(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(UID) FROM followers WHERE FollowerUID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(UID)'];
		}

		return null;
	}

	public function countPosts(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(PID)'];
		}

		return null;
	}
}

?>
