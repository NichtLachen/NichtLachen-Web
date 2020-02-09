<?php

require_once (__DIR__ . '/../../config.php');

class Database {

	public PDO $conn;

	public function __construct() {
		$this->conn = new PDO('mysql:dbname=' . DBNAME . ';host=' . DBHOST . ';charset=utf8mb4', DBUSER, DBPASS);
		$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}

?>
