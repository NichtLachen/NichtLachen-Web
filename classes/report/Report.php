<?php
class Report {

	private int $rpid;
	private ?int $pid;
	private ?int $cmtid;
	private ?int $ruid;
	private string $reason;
	private int $uid;

	public function __construct(int $rpid, ?int $pid, ?int $cmtid, ?int $ruid, string $reason, int $uid) {
		$this->rpid = $rpid;
		$this->pid = $pid;
		$this->cmtid = $cmtid;
		$this->ruid = $ruid;
		$this->reason = $reason;
		$this->uid = $uid;
	}

	public function getReportID() : int {
		return $this->rpid;
	}

	public function getReportedPID() : ?int {
		return $this->pid;
	}

	public function getReportedCMTID() : ?int {
		return $this->cmtid;
	}

	public function getReportedUID() : ?int {
		return $this->ruid;
	}

	public function getReason() {
		return $this->reason;
	}

	public function getReporterUID() {
		return $this->uid;
	}

}
?>
