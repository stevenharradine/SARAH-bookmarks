<?php
	require_once '../../views/_secureHead.php';
	require_once $relative_base_path . 'models/edit.php';

	if( isset ($sessionManager) && $sessionManager->isAuthorized () ) {
		$BOOKMARK_ID = request_isset ('id');

		$bookmarkManager = new BookmarkManager ();
		
		$record = $bookmarkManager->getRecord ($BOOKMARK_ID);

		$page_title = 'Edit | Bookmarks';

		// build edit view
		$editModel = new EditModel ('Edit', 'update_by_id', $BOOKMARK_ID);
		$editModel->addRow ('title', 'Title', $record->getTitle () );
		$editModel->addRow ('url', 'URL', $record->getUrl () );

		$views_to_load = array();
		$views_to_load[] = ' ' . EditView2::render($editModel);

		include $relative_base_path . 'views/_generic.php';
	}
?>