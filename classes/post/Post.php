<?php
require_once (__DIR__ . '/IPost.php');

class Post implements IPost {

	private int $pid;
	private int $cid;
	private int $uid;
	private string $content;
	private string $createdAt;

	public function __construct(int $pid, int $cid, int $uid, string $content, string $createdAt) {
		$this->pid = $pid;
		$this->cid = $cid;
		$this->uid = $uid;
		$this->content = $content;
		$this->createdAt = $createdAt;
	}

	public function getPID() : int {
		return $this->pid;
	}

	public function getCID() : int {
		return $this->cid;
	}

	public function getCreatorUID() : int {
		return $this->uid;
	}

	public function getContent() : string {
		return $this->content;
	}

	public function getCreatedAt() : string {
		return $this->createdAt;
	}

}
?>
