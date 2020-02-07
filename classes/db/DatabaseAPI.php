<?php

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/../user/User.php');
require_once (__DIR__ . '/../post/Post.php');

class DatabaseAPI {

	private Database $database;

	public function __construct() {
		$this->database = new Database();
	}

	private function getUser(array $row) : User {
		return new User($row['UID'], $row['Name'], $row['EMail'], $row['Description'], $row['Rank']);
	}

	public function addUser(string $name, string $email, string $password) {
		$stmt = $this->database->conn->prepare("INSERT INTO users (Name, EMail, Password) VALUES (:name, :email, :password)");
		$stmt->execute(array("name" => $name, "email" => $email, "password" => $password));
	}

	public function getUserByName(string $name) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE Name LIKE :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function getUserByOldName(string $oldname) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE OldName LIKE :name");
		$stmt->execute(array("name" => $oldname));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function isNameInUse(string $name) : bool {
		return $this->getUserByName($name) != null || $this->getUserByOldName($name) != null;
	}

	public function getUserByEMail(string $email) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function getUserByUID(int $uid) : ?User {
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $this->getUser($row);
		}

		return null;
	}

	public function verify(string $name, string $email, string $password) : string {
		$vid = uniqid("", true);
		$stmt = $this->database->conn->prepare("INSERT INTO verify (VID, Name, Password, EMail, ExpiresAT) VALUES (:vid, :name, :password, :email, NOW() + INTERVAL 1 DAY)");
		$stmt->execute(array("vid" => $vid, "name" => $name, "password" => $password, "email" => $email));

		return $vid;
	}

	public function verifyEnable(string $vid) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE VID LIKE :vid");
		$stmt->execute(array("vid" => $vid));

		foreach ($stmt as $row) {
			$this->addUser($row['Name'], $row['EMail'], $row['Password']);
			$stmt = $this->database->conn->prepare("DELETE FROM verify WHERE VID LIKE :vid");
			$stmt->execute(array("vid" => $vid));
			return true;
		}

		return false;
	}

	public function isNameInVerification(string $name) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE Name LIKE :name");
		$stmt->execute(array("name" => $name));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function isEMailInVerification(string $email) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function authenticate(int $uid, string $password) : bool {
		$stmt = $this->database->conn->prepare("SELECT Password FROM users WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return password_verify($password, $row['Password']);
		}

		return false;
	}

	public function setSessionID(int $uid, string $sid) {
		$stmt = $this->database->conn->prepare("INSERT INTO sessions (SID, UID, ExpiresAt) VALUES (:sid, :uid, NOW() + INTERVAL 7 DAY)");
		$stmt->execute(array("uid" => $uid, "sid" => $sid));
	}

	public function getUIDBySessionID(string $sid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT UID FROM sessions WHERE SID = :sid");
		$stmt->execute(array("sid" => $sid));

		foreach ($stmt as $row) {
			return $row['UID'];
		}

		return null;
	}

	public function refreshSession(string $sid) {
		$stmt = $this->database->conn->prepare("UPDATE sessions SET ExpiresAt = NOW() + INTERVAL 7 DAY WHERE SID = :sid");
		$stmt->execute(array("sid" => $sid));
	}

	public function removeSession(string $sid) {
		$stmt = $this->database->conn->prepare("DELETE FROM sessions WHERE SID = :sid");
		$stmt->execute(array("sid" => $sid));
	}

	public function countPostLikes(int $pid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND Value = '1'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countPostDislikes(int $pid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND Value = '-1'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countCommentLikes(int $cmtid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND Value = '1'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countCommentDislikes(int $cmtid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND Value = '-1'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return null;
	}

	public function countFollowers(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(FollowerUID) FROM followers WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(FollowerUID)'];
		}

		return null;
	}


	public function countFollows(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(UID) FROM followers WHERE FollowerUID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(UID)'];
		}

		return null;
	}

	public function countPosts(int $uid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(PID)'];
		}

		return null;
	}

	private function getPost(array $row) : Post {
		return new Post($row['PID'], $row['CID'], $row['UID'], $row['Content'], $row['CreatedAt']);
	}

	public function getParentLessCategories() : array {
		$res = [];
		$stmt = $this->database->conn->prepare("SELECT CID FROM categories WHERE Parent IS NULL AND Super = '0' ORDER BY CID ASC");
		$stmt->execute();

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['CID'];
		}

		return $res;
	}

	public function getSuperCategories() : array {
		$res = [];
		$stmt = $this->database->conn->prepare("SELECT CID FROM categories WHERE Super = '1' ORDER BY CID ASC");
		$stmt->execute();

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['CID'];
		}

		return $res;
	}

	public function getSubCategories(int $supercid) : array {
		$res = [];
		$stmt = $this->database->conn->prepare("SELECT CID FROM categories WHERE Parent = :cid ORDER BY CID ASC");
		$stmt->execute(array("cid" => $supercid));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['CID'];
		}

		return $res;
	}

	public function getCategoryName(int $cid) : ?string {
		$stmt = $this->database->conn->prepare("SELECT Name FROM categories WHERE CID = :cid");
		$stmt->execute(array("cid" => $cid));

		foreach ($stmt as $row) {
			return $row['Name'];
		}

		return null;
	}

	public function isSuperCategory(int $cid) : bool {
		$stmt = $this->database->conn->prepare("SELECT Name FROM categories WHERE CID = :cid AND Super = '1'");
		$stmt->execute(array("cid" => $cid));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function getNewCategoryPosts(int $cid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE CID = :cid ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("cid" => $cid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreNewCategoryPosts(int $cid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE CID = :cid ORDER BY PID");
		$stmt->execute(array("cid" => $cid));

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function postVerify(int $cid, int $uid, string $content) {
		$stmt = $this->database->conn->prepare("INSERT INTO posts_verify(CID,UID,CreatedAt,Content) VALUES (:cid,:uid,NOW(),:content)");
		$stmt->execute(array("cid" => $cid, "uid" => $uid, "content" => $content));
	}

	public function postVerifyEnable(int $pid) {
		$stmt = $this->database->conn->prepare("SELECT * FROM posts_verify WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			$stmt = $this->database->conn->prepare("INSERT INTO posts(CID,UID,CreatedAt,Content) VALUES (:cid,:uid,:created,:content)");
			$stmt->execute(array("cid" => $row['CID'], "uid" => $row['UID'], "created" => $row['CreatedAt'], "content" => $row['Content']));
			$stmt = $this->database->conn->prepare("DELETE FROM posts_verify WHERE PID = :pid");
			$stmt->execute(array("pid" => $pid));
			return;
		}
	}

	public function getNewPosts(int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
 		$stmt = $this->database->conn->prepare("SELECT * FROM posts ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreNewPosts(int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts ORDER BY PID");
		$stmt->execute();

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getUserPosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE UID = :uid ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("uid" => $uid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreUserPosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE UID = :uid ORDER BY PID");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getUserQueuePosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM posts_verify WHERE UID = :uid ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("uid" => $uid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreUserQueuePosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts_verify WHERE UID = :uid ORDER BY PID");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getTopPosts(int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC LIMIT :start,:end");
		$stmt->execute(array("start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreTopPosts(int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(posts.PID) FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC");
		$stmt->execute();

		foreach ($stmt as $row) {
			if ($row['COUNT(posts.PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function removeLikes(int $pid, int $uid) {
		$stmt = $this->database->conn->prepare("DELETE FROM likes WHERE PID = :pid AND UID = :uid");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}

	public function likePost(int $pid, int $uid) {
		$this->removeLikes($pid, $uid);
		$stmt = $this->database->conn->prepare("INSERT INTO likes (PID,UID,Value) VALUES (:pid,:uid,1)");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}

	public function dislikePost(int $pid, int $uid) {
		$this->removeLikes($pid, $uid);
		$stmt = $this->database->conn->prepare("INSERT INTO likes (PID,UID,Value) VALUES (:pid,:uid,-1)");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}

	public function isLikeSet(int $pid, int $uid, int $val) : bool {
		$stmt = $this->database->conn->prepare("SELECT LID FROM likes WHERE PID = :pid AND UID = :uid AND Value = :val");
		$stmt->execute(array("pid" => $pid, "uid" => $uid, "val" => $val));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function favPost(int $pid, int $uid) {
		$stmt = $this->database->conn->prepare("INSERT INTO favorites (PID,UID) VALUES (:pid,:uid)");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}

	public function isFavSet(int $pid, int $uid) : bool {
		$stmt = $this->database->conn->prepare("SELECT FID FROM favorites WHERE PID = :pid AND UID = :uid");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));

		foreach ($stmt as $row) {
			return true;
		}

		return false;
	}

	public function removeFav(int $pid, int $uid) {
		$stmt = $this->database->conn->prepare("DELETE FROM favorites WHERE PID = :pid AND UID = :uid");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}


	public function getNewFavPosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
 		$stmt = $this->database->conn->prepare("SELECT * FROM favorites,posts WHERE favorites.UID = :uid AND favorites.PID = posts.PID ORDER BY FID DESC LIMIT :start,:end");
		$stmt->execute(array("uid" => $uid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreNewFavPosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM favorites WHERE UID = :uid ORDER BY FID");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			if ($row['COUNT(posts.PID)'] > $end) {
				return true;
			}
		}

		return false;
	}	
}

?>
