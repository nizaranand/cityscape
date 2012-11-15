<?php
/**
 * Category function library
 */


/**
 * Create or edit a store
 *
 * @param string $page
 * @param int $guid
 */
function category_handle_edit_page($page, $guid) {
	admin_gatekeeper();

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

	if ($page == 'add') {

		$title = elgg_echo('category:add');
		elgg_push_breadcrumb($title);
		$content = elgg_view('category/edit', array('scope' => $scope));

	} else {

		$title = elgg_echo('category:edit');
		$category = get_entity($guid);

		if ($category && $category->canEdit()) {

			elgg_push_breadcrumb($category->title, $category->getURL());
			elgg_push_breadcrumb($title);
			$content = elgg_view('category/edit', array('entity' => $category));

		} else {

			$content = elgg_echo('category:noaccess');

		}

	}


	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Category view page
 *
 * @param int $guid Store entity GUID
 */
function category_handle_view_page($scope, $guid) {

	elgg_set_page_owner_guid($guid);

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$category = get_entity($guid);
	if (!$category) {
		forward();
	}

	elgg_push_breadcrumb($category->title);

	if (elgg_is_admin_logged_in()) {
		elgg_register_menu_item('title', array(
			'name' => $scope.':add',
			'href' => $scope.'/add/'.$category->guid,
			'text' => elgg_echo($scope.':add'),
			'link_class' => 'elgg-button elgg-button-action',
		));
		elgg_register_menu_item('title', array(
			'name' => 'category:edit',
			'href' => 'category/edit/'.$category->guid,
			'text' => elgg_echo('category:edit'),
			'link_class' => 'elgg-button elgg-button-action',
		));
	}

	$content = elgg_view('category/view/layout', array('entity' => $category));

	$params = array(
		'title' => elgg_echo($scope),
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($category->title, $body);
}

