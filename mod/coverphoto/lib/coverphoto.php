<?php
/**
 * Cover photo function library
 *
 * @package Cityscape.Coverphoto
 */

/**
 * Add or edit a cover photo
 */
function coverphoto_handle_edit_page($page, $guid) {

	if(!elgg_is_admin_logged_in() || elgg_get_logged_in_user_guid() == $guid) {
		forward();
	}

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	$title = elgg_echo('coverphoto:edit');
	$coverphoto = get_entity($guid);

	if ($coverphoto && $coverphoto->canEdit()) {
		elgg_push_breadcrumb($coverphoto->title, $coverphoto->getURL());
		elgg_push_breadcrumb($title);
		$content = elgg_view('coverphoto/edit', array('entity' => $coverphoto));
	} else {
		$content = elgg_echo('coverphoto:noaccess');
	}

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}


