<?php

require_once (__DIR__ . '/Database.php');
require_once (__DIR__ . '/../user/User.php');
require_once (__DIR__ . '/../post/Post.php');
require_once (__DIR__ . '/../post/Comment.php');
require_once (__DIR__ . '/../report/Report.php');
require_once (__DIR__ . '/../../config.php');

DatabaseAPI::$DB_INSTANCE = isset(DatabaseAPI::$DB_INSTANCE) ? DatabaseAPI::$DB_INSTANCE : new Database();

class DatabaseAPI {

	public static Database $DB_INSTANCE;
	private Database $database;

	public function __construct() {
		$this->database = self::$DB_INSTANCE;
	}

	public function getUserRanks(int $uid) : array {
		$res = [];
		$stmt = $this->database->conn->prepare("SELECT Rank FROM ranks WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['Rank'];
		}

		return $res;
	}

	private function getUser(array $row) : User {
		return new User($row['UID'], $row['JoinedAt'], $row['Name'], $row['OldName'], $row['NameChangedAt'], $row['EMail'], $row['Description'], $this->getUserRanks($row['UID']));
	}

	public function addUser(string $name, string $email, string $password) {
		$stmt = $this->database->conn->prepare("INSERT INTO users (JoinedAt, Name, NameChangedAt, EMail, Password) VALUES (NOW(), :name, NOW(), :email, :password)");
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

	public function setUserName(int $uid, string $name) {
		$user = $this->getUserByUID($uid);
		$stmt = $this->database->conn->prepare("UPDATE users SET Name = :name WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid, "name" => $name));
		$stmt = $this->database->conn->prepare("UPDATE users SET OldName = :oldname WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid, "oldname" => $user->getName()));
		$stmt = $this->database->conn->prepare("UPDATE users SET NameChangedAt = NOW() WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));
	}

	public function setUserEMail(int $uid, string $email) {
		$stmt = $this->database->conn->prepare("UPDATE users SET EMail = :email WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid, "email" => $email));
	}

	public function setUserPassword(int $uid, string $password) {
		$stmt = $this->database->conn->prepare("UPDATE users SET Password = :password WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid, "password" => $password));
	}

	public function setUserDescription(int $uid, ?string $description) {
		$stmt = $this->database->conn->prepare("UPDATE users SET Description = :description WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid, "description" => $description));
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

		return $stmt->rowCount() > 0;
	}

	public function isEMailInVerification(string $email) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM verify WHERE EMail LIKE :email");
		$stmt->execute(array("email" => $email));

		return $stmt->rowCount() > 0;
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

	public function countPostLikes(int $pid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND Value = '1'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return 0;
	}

	public function countPostDislikes(int $pid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE PID = :pid AND Value = '-1'");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return 0;
	}

	public function countCommentLikes(int $cmtid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND Value = '1'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return 0;
	}

	public function countCommentDislikes(int $cmtid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(LID) FROM likes WHERE CMTID = :cmtid AND Value = '-1'");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $row['COUNT(LID)'];
		}

		return 0;
	}

	public function countFollowers(int $uid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(FollowerUID) FROM followers WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(FollowerUID)'];
		}

		return 0;
	}


	public function countFollows(int $uid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(UID) FROM followers WHERE FollowerUID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(UID)'];
		}

		return 0;
	}

	public function getFollows(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM users,followers WHERE FollowerUID = :uid AND users.UID = followers.UID LIMIT :start,:end");
		$stmt->execute(array("uid" => $uid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getUser($row);
		}

		return $res;
	}

	public function moreFollows(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(UID) FROM followers WHERE FollowerUID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			if ($row['COUNT(UID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function searchUsers(string $query, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM users WHERE Name LIKE :query LIMIT :start,:end");
		$stmt->execute(array("query" => "%" . $query . "%", "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getUser($row);
		}

		return $res;
	}

	public function moreSearchUsers(string $query, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(UID) FROM users WHERE Name LIKE :query");
		$stmt->execute(array("query" => "%" . $query . "%"));

		foreach ($stmt as $row) {
			if ($row['COUNT(UID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function countPosts(int $uid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE UID = :uid");
		$stmt->execute(array("uid" => $uid));

		foreach ($stmt as $row) {
			return $row['COUNT(PID)'];
		}

		return 0;
	}

	public function countPostComments(int $pid) : int {
		$stmt = $this->database->conn->prepare("SELECT COUNT(CMTID) FROM comments WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['COUNT(CMTID)'];
		}

		return 0;
	}

	private function getComment(array $row) : Comment {
		$replyTo = [];
		$stmt = $this->database->conn->prepare("SELECT * FROM comment_reply WHERE CMTID = :cmtid");
		$stmt->execute(array("cmtid" => $row['CMTID']));

		foreach ($stmt as $tmp) {
			$replyTo[sizeof($replyTo)] = new CommentReply($tmp['UID_F'], $tmp['ReplaceValue']);
		}

		return new Comment($row['CMTID'], $row['PID'], $row['UID'], $replyTo, $row['Content'], $row['CreatedAt']);
	}

	public function getComments(int $pid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
 		$stmt = $this->database->conn->prepare("SELECT * FROM comments WHERE PID = :pid ORDER BY CMTID DESC LIMIT :start,:end");
		$stmt->execute(array("pid" => $pid, "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getComment($row);
		}

		return $res;
	}

	public function getCommentByCMTID(int $cmtid) : ?Comment {
		$stmt = $this->database->conn->prepare("SELECT * FROM comments WHERE CMTID = :cmtid");
		$stmt->execute(array("cmtid" => $cmtid));

		foreach ($stmt as $row) {
			return $this->getComment($row);
		}

		return null;
	}

	public function moreComments(int $pid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(CMTID) FROM comments WHERE PID = :pid ORDER BY CMTID");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			if ($row['COUNT(CMTID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function postComment(int $pid, int $uid, array $replyTo, string $content) {
		$stmt = $this->database->conn->prepare("INSERT INTO comments(PID,UID,Content,CreatedAt) VALUES (:pid,:uid,:content,NOW())");
		$stmt->execute(array("pid" => $pid, "uid" => $uid, "content" => $content));

		$cmtid = 0;
		$stmt = $this->database->conn->prepare("SELECT LAST_INSERT_ID()");
		$stmt->execute();

		foreach ($stmt as $row) {
			$cmtid = $row['LAST_INSERT_ID()'];
		}

		foreach ($replyTo as $reply) {
			$stmt = $this->database->conn->prepare("INSERT INTO comment_reply(CMTID,UID_F,ReplaceValue) VALUES (:cmtid,:uid_f,:replacevalue)");
			$stmt->execute(array("cmtid" => $cmtid, "uid_f" => $reply->getReplyTo(), "replacevalue" => $reply->getReplaceValue()));
		}
	}

	private function getPost(array $row) : Post {
		return new Post($row['PID'], $row['CID'], $row['UID'], $row['Content'], $row['CreatedAt']);
	}

	public function getPostByPID(int $pid) : ?Post {
		$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $this->getPost($row);
		}

		return null;
	}

	public function getAllSubCategories() : array {
		$res = [];
		$stmt = $this->database->conn->prepare("SELECT CID FROM categories WHERE SUPER = '0' ORDER BY CID ASC");
		$stmt->execute();

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['CID'];
		}

		return $res;
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

		return $stmt->rowCount() > 0;
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

	public function postQueue(int $cid, int $uid, string $content) {
		$stmt = $this->database->conn->prepare("INSERT INTO posts_verify(CID,UID,CreatedAt,Content) VALUES (:cid,:uid,NOW(),:content)");
		$stmt->execute(array("cid" => $cid, "uid" => $uid, "content" => $content));
	}

	public function hasPostAcceptedOrRejected(int $uid, int $pid) : bool {
		$stmt = $this->database->conn->prepare("SELECT PID FROM posts_verify_accept WHERE UID = :uid AND PID = :pid");
		$stmt->execute(array("uid" => $uid, "pid" => $pid));

		return $stmt->rowCount() > 0;
	}

	public function getQueuedPostOwner(int $pid) : ?int {
		$stmt = $this->database->conn->prepare("SELECT UID FROM posts_verify WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['UID'];
		}

		return null;
	}

	public function getPostQueueAccepts(int $pid) : int {
		$stmt = $this->database->conn->prepare("SELECT SUM(Value) FROM posts_verify_accept WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			return $row['SUM(Value)'] != null ? $row['SUM(Value)'] : 0;
		}

		return 0;
	}

	public function postQueueAccept(int $uid, int $pid) {
		$stmt = $this->database->conn->prepare("INSERT INTO posts_verify_accept (UID,PID,Value) VALUES (:uid,:pid,1)");
		$stmt->execute(array("uid" => $uid, "pid" => $pid));
	}

	public function postQueueReject(int $uid, int $pid) {
		$stmt = $this->database->conn->prepare("INSERT INTO posts_verify_accept (UID,PID,Value) VALUES (:uid,:pid,-1)");
		$stmt->execute(array("uid" => $uid, "pid" => $pid));
	}

	public function postDeQueue(int $pid) {
		$stmt = $this->database->conn->prepare("SELECT * FROM posts_verify WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			$stmt = $this->database->conn->prepare("INSERT INTO posts(CID,UID,CreatedAt,Content) VALUES (:cid,:uid,:created,:content)");
			$stmt->execute(array("cid" => $row['CID'], "uid" => $row['UID'], "created" => $row['CreatedAt'], "content" => $row['Content']));
			$this->postQueueDelete($pid);
			return;
		}
	}

	public function postQueueDelete(int $pid) {
		$stmt = $this->database->conn->prepare("DELETE FROM posts_verify_accept WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));
		$stmt = $this->database->conn->prepare("DELETE FROM posts_verify WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));
	}

	public function commentDelete(int $cmtid) {
		$stmt = $this->database->conn->prepare("DELETE FROM comment_reply WHERE CMTID = :cmtid");
		$stmt->execute(array("cmtid" => $cmtid));
		$stmt = $this->database->conn->prepare("DELETE FROM likes WHERE CMTID = :cmtid");
		$stmt->execute(array("cmtid" => $cmtid));
		$stmt = $this->database->conn->prepare("DELETE FROM comments WHERE CMTID = :cmtid");
		$stmt->execute(array("cmtid" => $cmtid));
	}

	public function postDelete(int $pid) {
		$stmt = $this->database->conn->prepare("SELECT CMTID FROM comments WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));

		foreach ($stmt as $row) {
			$this->commentDelete($row['CMTID']);
		}

		$stmt = $this->database->conn->prepare("DELETE FROM favorites WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));
		$stmt = $this->database->conn->prepare("DELETE FROM likes WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));
		$stmt = $this->database->conn->prepare("DELETE FROM posts WHERE PID = :pid");
		$stmt->execute(array("pid" => $pid));
	}

	public function getNewPosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount

		$categoryfilter = $this->getUserSettings($uid, "categoryfilter");
		$enabledCategories = $this->getUserSettings($uid, "filter_enabled_category");
		if (sizeof($categoryfilter) > 0 && $categoryfilter[0] && sizeof($enabledCategories) > 0) {
			$enabled = str_repeat('?,', count($enabledCategories) - 1) . '?'; // generates string with questionmarks for prepared statement

			$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE CID IN ($enabled) ORDER BY PID DESC LIMIT ?,?");
			$stmt->execute(array_merge($enabledCategories, array($start, $end)));
		} else {
 			$stmt = $this->database->conn->prepare("SELECT * FROM posts ORDER BY PID DESC LIMIT :start,:end");
			$stmt->execute(array("start" => $start, "end" => $end));
		}

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreNewPosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;

		$categoryfilter = $this->getUserSettings($uid, "categoryfilter");
		$enabledCategories = $this->getUserSettings($uid, "filter_enabled_category");
		if (sizeof($categoryfilter) > 0 && $categoryfilter[0] && sizeof($enabledCategories) > 0) {
			$enabled = str_repeat('?,', count($enabledCategories) - 1) . '?'; // generates string with questionmarks for prepared statement

			$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE CID IN ($enabled)");
			$stmt->execute($enabledCategories);
		} else {
			$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts ORDER BY PID");
			$stmt->execute();
		}

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getUserPosts(int $uid, bool $own, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$disallowedCIDs = $own ? array('') : ANONYMOUS_CATEGORIES;
		$disallowed = str_repeat('?,', count($disallowedCIDs) - 1) . '?'; // generates string with questionmarks for prepared statement
		$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE UID = ? AND CID NOT IN ($disallowed) ORDER BY PID DESC LIMIT ?,?");
		$stmt->execute(array_merge(array($uid), $disallowedCIDs, array($start, $end)));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreUserPosts(int $uid, bool $own, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$disallowedCIDs = $own ? array('') : ANONYMOUS_CATEGORIES;
		$disallowed  = str_repeat('?,', count($disallowedCIDs) - 1) . '?'; // generates string with questionmarks for prepared statement
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts WHERE UID = ? AND CID NOT IN($disallowed) ORDER BY PID");
		$stmt->execute(array_merge(array($uid), $disallowedCIDs));

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

	public function getQueuePosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM posts_verify WHERE UID != :uid AND NOT EXISTS (SELECT PID FROM posts_verify_accept WHERE posts_verify.PID = posts_verify_accept.PID AND posts_verify_accept.UID = :uidX) ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("uid" => $uid, "start" => $start, "end" => $end, "uidX" => $uid));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreQueuePosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(PID) FROM posts_verify WHERE UID != :uid AND NOT EXISTS (SELECT PID FROM posts_verify_accept WHERE posts_verify.PID = posts_verify_accept.PID AND posts_verify_accept.UID = :uidX) ORDER BY PID");
		$stmt->execute(array("uid" => $uid, "uidX" => $uid));

		foreach ($stmt as $row) {
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getTopPosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount

		$categoryfilter = $this->getUserSettings($uid, "categoryfilter");
		$enabledCategories = $this->getUserSettings($uid, "filter_enabled_category");
		if (sizeof($categoryfilter) > 0 && $categoryfilter[0] && sizeof($enabledCategories) > 0) {
			$enabled = str_repeat('?,', count($enabledCategories) - 1) . '?'; // generates string with questionmarks for prepared statement

			$stmt = $this->database->conn->prepare("SELECT * FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID AND CID IN ($enabled) GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC LIMIT ?,?");
			$stmt->execute(array_merge($enabledCategories, array($start, $end)));
		} else {
			$stmt = $this->database->conn->prepare("SELECT * FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC LIMIT :start,:end");
			$stmt->execute(array("start" => $start, "end" => $end));
		}

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreTopPosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;

		$categoryfilter = $this->getUserSettings($uid, "categoryfilter");
		$enabledCategories = $this->getUserSettings($uid, "filter_enabled_category");
		if (sizeof($categoryfilter) > 0 && $categoryfilter[0] && sizeof($enabledCategories) > 0) {
			$enabled = str_repeat('?,', count($enabledCategories) - 1) . '?'; // generates string with questionmarks for prepared statement

			$stmt = $this->database->conn->prepare("SELECT posts.PID FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID AND posts.CID IN ($enabled) GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC");
			$stmt->execute($enabledCategories);
		} else {
			$stmt = $this->database->conn->prepare("SELECT posts.PID FROM likes,posts WHERE likes.PID IS NOT NULL AND posts.PID = likes.PID GROUP BY likes.PID HAVING SUM(likes.Value) > 0 ORDER BY CreatedAt DESC, SUM(likes.Value) DESC");
			$stmt->execute();
		}

		return $stmt->rowCount() > $end;

		return false;
	}

	public function searchPosts(string $query, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT * FROM posts WHERE Content LIKE :query ORDER BY PID DESC LIMIT :start,:end");
		$stmt->execute(array("query" => "%" . $query . "%", "start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreSearchPosts(string $query, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(posts.PID) FROM posts WHERE Content LIKE :query");
		$stmt->execute(array("query" => "%" . $query . "%"));

		foreach ($stmt as $row) {
			if ($row['COUNT(posts.PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function getUserSubscriptionPosts(int $uid, int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$disallowedCIDs = ANONYMOUS_CATEGORIES;
		$disallowed = str_repeat('?,', count($disallowedCIDs) - 1) . '?'; // generates string with questionmarks for prepared statement
		$stmt = $this->database->conn->prepare("SELECT * FROM posts,followers WHERE posts.UID = followers.UID AND followers.FollowerUID = ? AND CID NOT IN ($disallowed) ORDER BY PID DESC LIMIT ?,?");
		$stmt->execute(array_merge(array($uid), $disallowedCIDs, array($start, $end)));

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $this->getPost($row);
		}

		return $res;
	}

	public function moreUserSubscriptionPosts(int $uid, int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$disallowedCIDs = ANONYMOUS_CATEGORIES;
		$disallowed = str_repeat('?,', count($disallowedCIDs) - 1) . '?'; // generates string with questionmarks for prepared statement
		$stmt = $this->database->conn->prepare("SELECT COUNT(posts.PID) FROM posts,followers WHERE posts.UID = followers.UID AND followers.FollowerUID = ? AND CID NOT IN ($disallowed) ORDER BY PID");
		$stmt->execute(array_merge(array($uid), $disallowedCIDs));

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

		return $stmt->rowCount() > 0;
	}

	public function removeCommentLikes(int $cmtid, int $uid) {
		$stmt = $this->database->conn->prepare("DELETE FROM likes WHERE CMTID = :cmtid AND UID = :uid");
		$stmt->execute(array("cmtid" => $cmtid, "uid" => $uid));
	}

	public function likeComment(int $cmtid, int $uid) {
		$this->removeCommentLikes($cmtid, $uid);
		$stmt = $this->database->conn->prepare("INSERT INTO likes (CMTID,UID,Value) VALUES (:cmtid,:uid,1)");
		$stmt->execute(array("cmtid" => $cmtid, "uid" => $uid));
	}

	public function isCommentLikeSet(int $cmtid, int $uid, int $val) : bool {
		$stmt = $this->database->conn->prepare("SELECT LID FROM likes WHERE CMTID = :cmtid AND UID = :uid AND Value = :val");
		$stmt->execute(array("cmtid" => $cmtid, "uid" => $uid, "val" => $val));

		return $stmt->rowCount() > 0;
	}

	public function favPost(int $pid, int $uid) {
		$stmt = $this->database->conn->prepare("INSERT INTO favorites (PID,UID) VALUES (:pid,:uid)");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));
	}

	public function isFavSet(int $pid, int $uid) : bool {
		$stmt = $this->database->conn->prepare("SELECT FID FROM favorites WHERE PID = :pid AND UID = :uid");
		$stmt->execute(array("pid" => $pid, "uid" => $uid));

		return $stmt->rowCount() > 0;
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
			if ($row['COUNT(PID)'] > $end) {
				return true;
			}
		}

		return false;
	}

	public function hasSubscribed(int $followeruid, int $uid) : bool {
		$stmt = $this->database->conn->prepare("SELECT * FROM followers WHERE FollowerUID = :followeruid AND UID = :uid");
		$stmt->execute(array("followeruid" => $followeruid, "uid" => $uid));

		return $stmt->rowCount() > 0;
	}

	public function subscribe(int $followeruid, int $uid) {
		$stmt = $this->database->conn->prepare("INSERT INTO followers (FollowerUID, UID) VALUES (:followeruid, :uid)");
		$stmt->execute(array("followeruid" => $followeruid, "uid" => $uid));
	}

	public function unsubscribe(int $followeruid, int $uid) {
		$stmt = $this->database->conn->prepare("DELETE FROM followers WHERE FollowerUID = :followeruid AND UID = :uid");
		$stmt->execute(array("followeruid" => $followeruid, "uid" => $uid));
	}

	public function canSubscribe(int $followeruid, int $uid) {
		return $followeruid != $uid && !$this->hasSubscribed($followeruid, $uid);
	}

	public function getUserSettings(int $uid, string $key) : array {
		$stmt = $this->database->conn->prepare("SELECT Value FROM settings WHERE UID = :uid AND Name = :key");
		$stmt->execute(array("uid" => $uid, "key" => $key));

		$res = [];

		foreach ($stmt as $row) {
			$res[sizeof($res)] = $row['Value'];
		}

		return $res; 
	}

	public function addUserSetting(int $uid, string $key, string $value) {
		$stmt = $this->database->conn->prepare("INSERT INTO settings (UID,Name,Value) VALUES (:uid, :key, :value)");
		$stmt->execute(array("uid" => $uid, "key" => $key, "value" => $value));
	}

	public function deleteUserSettings(int $uid, string $key) {
		$stmt = $this->database->conn->prepare("DELETE FROM settings WHERE UID = :uid AND Name = :key");
		$stmt->execute(array("uid" => $uid, "key" => $key));
	}
	
	public function reportPost(int $uid, int $pid, string $reason) {
		$stmt = $this->database->conn->prepare("INSERT INTO reports (UID,PID,Reason) VALUES (:uid, :pid, :reason)");
		$stmt->execute(array("uid" => $uid, "pid" => $pid, "reason" => $reason));
	}
	
	public function reportComment(int $uid, int $cmtid, string $reason) {
		$stmt = $this->database->conn->prepare("INSERT INTO reports (UID,CMTID,Reason) VALUES (:uid, :cmtid, :reason)");
		$stmt->execute(array("uid" => $uid, "cmtid" => $pid, "reason" => $reason));
	}
	
	public function reportUser(int $uid, int $ruid, string $reason) {
		$stmt = $this->database->conn->prepare("INSERT INTO reports (UID,RUID,Reason) VALUES (:uid, :cmtid, :reason)");
		$stmt->execute(array("uid" => $uid, "ruid" => $ruid, "reason" => $reason));
	}
	
	public function hasReportedPost(int $uid, int $pid) : bool {
		$stmt = $this->database->conn->prepare("SELECT RPID FROM reports WHERE UID = :uid AND PID = :pid");
		$stmt->execute(array("uid" => $uid, "pid" => $pid));
		
		return $stmt->rowCount() > 0;
	}
	
	public function hasReportedComment(int $uid, int $cmtid) : bool {
		$stmt = $this->database->conn->prepare("SELECT RPID FROM reports WHERE UID = :uid AND CMTID = :cmtid");
		$stmt->execute(array("uid" => $uid, "cmtid" => $cmtid));
		
		return $stmt->rowCount() > 0;
	}
	
	public function hasReportedUser(int $uid, int $ruid) : bool {
		$stmt = $this->database->conn->prepare("SELECT RPID FROM reports WHERE UID = :uid AND RUID = :ruid");
		$stmt->execute(array("uid" => $uid, "ruid" => $ruid));
		
		return $stmt->rowCount() > 0;
	}
	
	public function getPostReports(int $page, int $perPage) : array {
		$res = [];
		$start = ($page - 1) * $perPage;
		$end = $perPage; // LIMIT offset,amount
		$stmt = $this->database->conn->prepare("SELECT PID, COUNT(*) FROM reports WHERE PID IS NOT NULL GROUP BY PID ORDER BY COUNT(*) DESC LIMIT :start,:end");
		$stmt->execute(array("start" => $start, "end" => $end));

		foreach ($stmt as $row) {
			$tmpstmt = $this->database->conn->prepare("SELECT * FROM reports WHERE PID = :pid");
			$tmpstmt->execute(array("pid" => $row['PID']));

			$reports = [];
			
			foreach ($tmpstmt as $tmprow) {
				$reports[sizeof($reports)] = new Report($tmprow['RPID'], $tmprow['PID'], null, null, $tmprow['Reason'], $tmprow['UID']);
			}
			
			$res[sizeof($res)] = $reports;
		}

		return $res;
	}

	public function morePostReports(int $page, int $perPage) : bool {
		$start = ($page - 1) * $perPage;
		$end = $start + $perPage;
		$stmt = $this->database->conn->prepare("SELECT COUNT(DISTINCT PID) FROM reports WHERE PID IS NOT NULL");
		$stmt->execute();

		foreach ($stmt as $row) {
			if ($row['COUNT(DISTINCT PID)'] > $end) {
				return true;
			}
		}

		return false;
	}
}

?>
