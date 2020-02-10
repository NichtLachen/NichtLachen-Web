<?php
class Comment {

	private int $cmtid;
	private int $pid;
	private int $uid;
	private array $replyTo;
	private string $content;
	private string $createdAt;

	public function __construct(int $cmtid, int $pid, int $uid, array $replyTo, string $content, string $createdAt) {
		$this->cmtid = $cmtid;
		$this->pid = $pid;
		$this->uid = $uid;
		$this->replyTo = $replyTo;
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

	public function getReplyTo() : array {
		return $this->replyTo;
	}

	public function getContent() : string {
		return $this->content;
	}

	public function getCreatedAt() : string {
		return $this->createdAt;
	}

}

class CommentReply {

	private int $uid_f;
	private string $replace;

	public function __construct(int $uid_f, string $replace) {
		$this->uid_f = $uid_f;
		$this->replace = $replace;
	}

	public function getReplyTo() : int {
		return $this->uid_f;
	}

	public function getReplaceValue() : string {
		return $this->replace;
	}
}
?>
