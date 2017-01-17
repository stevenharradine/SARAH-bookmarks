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
		public function get_link () {
			global $DB_ADDRESS;
			global $DB_USER;
			global $DB_PASS;
			global $DB_NAME;

			return $link = DB_Connect($DB_ADDRESS, $DB_USER, $DB_PASS, $DB_NAME);
		}
		public function updateRecord ($BOOKMARK_ID, $title, $url) {
			global $sessionManager;
			$link = BookmarkManager::get_link();
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
UPDATE
	`sarah`.`bookmarks`
SET
	`title` = '$title',
	`url` = '$url'
WHERE
	`BOOKMARK_ID`='$BOOKMARK_ID';
EOD;
			
			return $link->query($sql);
		}

		public function addRecord ($title, $url) {
			global $sessionManager;
			$link = BookmarkManager::get_link();
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
INSERT INTO
	`sarah`.`bookmarks` (
		`USER_ID`,
		`title`,
		`url`
	) VALUES (
		'$USER_ID',
		'$title',
		'$url'
	);
EOD;

			return $link->query($sql);
		}

		public function deleteRecord ($BOOKMARK_ID) {
			global $sessionManager;
			$link = BookmarkManager::get_link();
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
DELETE FROM
	`sarah`.`bookmarks`
WHERE
	`BOOKMARK_ID`='$BOOKMARK_ID'
		AND
	`USER_ID`='$USER_ID';
EOD;

			return $link->query($sql);
		}

		public function getRecord ($BOOKMARK_ID) {
			global $sessionManager;
			$link = BookmarkManager::get_link();
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
SELECT
	*
FROM
	`bookmarks`
WHERE
	`BOOKMARK_ID`='$BOOKMARK_ID'
		AND
	`USER_ID`='$USER_ID';
EOD;

			if ($result = $link->query($sql)) {
				if ( $row = (array)$result->fetch_object() ) {
					$title = $row['title'];
					$url = $row['url'];

					return new BookmarkRecord ($BOOKMARK_ID, $title, $url);
				}
			} else {
				return NULL;
			}
		}

		public function getAllRecords () {
			global $sessionManager;
			$link = BookmarkManager::get_link();
			$USER_ID = $sessionManager->getUserId();

			$sql = <<<EOD
SELECT
	*
FROM
	`bookmarks`
WHERE
	`USER_ID`='$USER_ID';
EOD;

			$bookmarks = array ();

			if ($result = $link->query($sql)) {
				while ( $row = $result->fetch_object() ) {
					$bookmarks[] = array (
						"BOOKMARK_ID" => $row->BOOKMARK_ID,
						"title" => $row->title,
						"url" => $row->url,
					);
				}
			}

			return $bookmarks;
		}
	}