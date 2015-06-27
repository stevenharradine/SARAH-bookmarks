<?php
	require_once '../../views/_secureHead.php';

	if( isset ($sessionManager) && $sessionManager->isAuthorized () ) {
		$id = request_isset ('id');
		$sbookmark = request_isset ('sbookmark');
		$title = request_isset ('title');
		$url = request_isset ('url');

		switch ($page_action) {
			case ('update_by_id') :
				$db_update_success = BookmarkManager::updateRecord ($id, $title, $url);
				break;
			case ('add_bookmark') :
				$db_update_success = BookmarkManager::addRecord ($title, $url);
				break;
			case ('delete_by_id') :
				$db_delete_success = BookmarkManager::deleteRecord ($id);
				break;
		}
		
		$page_title = 'Bookmarks';
		$search_target = 'bookmarks';
		$bookmark_data = BookmarkManager::getAllRecords();
		
		$alt_menu = getAddButton() . getSearchButton();

		$searchModel = new SearchModel( $search_target );

		$addModel = new AddModel('Add', 'add_bookmark');
		$addModel->addRow ('title', 'Title');
		$addModel->addRow ('url', 'URL');

		$bookmarkModel = new TableModel ( '', $search_target);
		/*$bookmarkModel->addRow ( array (
			TableView2::createCell ('site', 'Site', 'th'),
			TableView2::createCell ()
		));*/

		while (($bookmark_row = mysql_fetch_array( $bookmark_data )) != null) {
			$target = $sbookmark ? ' target="_blank"' : '';

			$bookmarkModel->addRow ( array (
				TableView2::createCell ('bookmark', '<a href="' . $bookmark_row['url'] . '" ' . $target . '>' . $bookmark_row['title'] . '</a>' ),
				TableView2::createEdit ($bookmark_row['BOOKMARK_ID'])
			));
		}

		$views_to_load = array();
		$views_to_load[] = ' ' . AddView2::render($addModel);
		$views_to_load[] = ' ' . SearchView::render($searchModel);
		$views_to_load[] = ' ' . TableView2::render($bookmarkModel);
		
		include $relative_base_path . 'views/_generic.php';
	}