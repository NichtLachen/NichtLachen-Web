<?php
class Comment {

	private int $cmtid;
	private int $pid;
	private int $uid;
	private ?int $uid_f;
	private string $content;
	private string $createdAt;

	public function __construct(int $cmtid, int $pid, int $uid, ?int $uid_f, string $content, string $createdAt) {
		$this->cmtid = $cmtid;
		$this->pid = $pid;
		$this->uid = $uid;
		$this->uid_f = $uid_f;
		$this->content = $content;
		$this->createdAt = $createdAt;
	}

	public function getCMTID() : int {
		return $this->cmtid;
	}

	public function getPID() : int {
		return $this->pid;
	}

	public function getCreatorUID() : int {
		return $this->uid;
	}

	public function getReplyTo() : ?int {
		return $this->uid_f;
	}

	public function getContent() : string {
		return $this->content;
	}

	public function getCreatedAt() : string {
		return $this->createdAt;
	}

}
?>
