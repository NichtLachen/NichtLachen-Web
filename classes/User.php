<?php

class User {

	private string $uid;
	private string $name;
	private string $email;
	private string $description;
	private string $profileimageid;
	private int $rank;

	function __construct(string $uid, string $name, string $email, string $description, string $profileimageid, int $rank) {
		$this->uid = $uid;
		$this->name = $name;
		$this->email = $email;
		$this->description = $description;
		$this->profileimageid = $profileimageid;
		$this->rank = $rank;
	}

	function getUID() : string {
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

	function getProfileImageID() : string {
		return $this->profileimageid;
	}

	function getRank() : int {
		return $this->rank;
	}

}

?>
