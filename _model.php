<?php
	class BookmarkRecord {
		private $USER_ID;
		private $BOOKMARK_ID;
		private $title;
		private $url;

		public function __construct ($BOOKMARK_ID, $title, $url) {
			$this->BOOKMARK_ID = $BOOKMARK_ID;
			$this->title = $title;
			$this->url = $url;
		}

		public function getTitle () {
			return $this->title;
		}
		public function getUrl () {
			return $this->url;
		}
	}
	class BookmarkManager {
		public function updateRecord ($BOOKMARK_ID, $title, $url) {
			$sql = <<<EOD
	UPDATE `sarah`.`bookmarks`
	SET `title` = '$title',
	`url` = '$url'
	WHERE `BOOKMARK_ID`='$BOOKMARK_ID';
EOD;
			
			return mysql_query($sql) or die(mysql_error());
		}

		public function addRecord ($title, $url) {
			global $sessionManager;
			$USER_ID = $sessionManager->getUserId();

			return mysql_query("INSERT INTO `sarah`.`bookmarks` (`USER_ID`, `title`, `url`) VALUES ('$USER_ID', '$title', '$url');") or die(mysql_error());
		}

		public function deleteRecord ($BOOKMARK_ID) {
			global $sessionManager;
			$USER_ID = $sessionManager->getUserId();

			return mysql_query("DELETE FROM `sarah`.`bookmarks` WHERE `BOOKMARK_ID`='$BOOKMARK_ID' AND `USER_ID`='$USER_ID';") or die(mysql_error());
		}

		public function getRecord ($BOOKMARK_ID) {
			global $sessionManager;
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
	SELECT *
	FROM `bookmarks`
	WHERE `BOOKMARK_ID`='$BOOKMARK_ID'
	AND `USER_ID`='$USER_ID';
EOD;
			$data = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array( $data );

			$title = $row['title'];
			$url = $row['url'];

			return new BookmarkRecord ($BOOKMARK_ID, $title, $url);
		}

		public function getAllRecords () {
			$sql = "SELECT * FROM `bookmarks`WHERE `USER_ID`='" . $_SESSION['USER_ID'] . "'";
			//echo $sql;
			$bookmark_data = mysql_query($sql) or die(mysql_error());

			return $bookmark_data;
		}
	}