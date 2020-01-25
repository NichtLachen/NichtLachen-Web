<?php

require_once (dirname(__FILE__) . '/../../config.php');

class Database {

	public PDO $conn;

	public function __construct() {
		$this->conn = new PDO('mysql:dbname=' . DBNAME . ';host=' . DBHOST . ';charset=utf8', DBUSER, DBPASS);
		$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}

?>
