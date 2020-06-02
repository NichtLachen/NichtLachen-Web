<?php
require_once (__DIR__ . '/Post.php');

class Comment extends Post {

	private int $cmtid;
	private array $replyTo;

	public function __construct(int $cmtid, int $pid, int $cid, int $uid, array $replyTo, string $content, string $createdAt) {
		parent::__construct($pid, $cid, $uid, $content, $createdAt);
		$this->cmtid = $cmtid;
		$this->replyTo = $replyTo;
	}

	public function getCMTID() : int {
		return $this->cmtid;
	}

	public function getReplyTo() : array {
		return $this->replyTo;
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
