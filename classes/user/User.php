<?php

class User {

	private int $uid;
	private string $name;
	private string $email;
	private string $description;
	private int $rank;

	function __construct(int $uid, string $name, string $email, string $description, int $rank) {
		$this->uid = $uid;
		$this->name = $name;
		$this->email = $email;
		$this->description = $description;
		$this->rank = $rank;
	}

	function getUID() : int {
		return $this->uid;
	}

	function getName() : string {
		return $this->name;
	}

	function getEMail() : string {
		return $this->email;
	}

	function getDescription() : string {
		return $this->description;
	}

	function getRank() : int {
		return $this->rank;
	}

}

?>
