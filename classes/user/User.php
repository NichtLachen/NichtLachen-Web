<?php

class User {

	private int $uid;
	private string $joinedAt;
	private string $name;
	private ?string $oldName;
	private string $nameChangedAt;
	private string $email;
	private ?string $description;
	private ?int $rank;

	function __construct(int $uid, string $joinedAt, string $name, ?string $oldName, string $nameChangedAt, string $email, ?string $description, ?int $rank) {
		$this->uid = $uid;
		$this->joinedAt = $joinedAt;
		$this->name = $name;
		$this->oldName = $oldName;
		$this->nameChangedAt = $nameChangedAt;
		$this->email = $email;
		$this->description = $description;
		$this->rank = $rank;
	}

	function getUID() : int {
		return $this->uid;
	}

	function getJoinedAt() : string {
		return $this->joinedAt;
	}

	function getName() : string {
		return $this->name;
	}

	function getOldName() : ?string {
		return $this->oldName;
	}

	function getNameChangedAt() : string {
		return $this->nameChangedAt;
	}

	function getEMail() : string {
		return $this->email;
	}

	function getDescription() : ?string {
		return $this->description;
	}

	function getRank() : ?int {
		return $this->rank;
	}

}

?>
