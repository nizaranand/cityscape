<?php
/**
 * Menu function library
 */

/**
 * List menu items of a dining place
 *
 * @param int $guid Group entity GUID
 */
function menu_handle_view_page($username) {

	$dine = get_user_by_username($username);
	if (!$dine) {
		register_error(elgg_echo('dine:notfound'));
		forward();
	}

	if ($dine->canEdit()) {
		elgg_register_menu_item('title', array(
			'name' => 'menu:categories:add',
			'href' => 'menu/categories/add/'.$dine->username,
			'text' => elgg_echo('menu:categories:add'),
			'link_class' => 'elgg-button elgg-button-action',
		));
	}

	elgg_set_page_owner_guid($dine->getGUID());

	elgg_push_breadcrumb($dine->name, $dine->getURL());

	$title = $dine->name . ' - '
		.elgg_echo('item:object:diningmenu');
	
	$options = array(
		'type' => 'object',
		'subtype' => 'diningmenucategory',
		'owner_guid' => $dine->guid,
//		'order_by' => 'e.last_action asc',
		'full_view' => false,
	);
	$content = elgg_list_entities($options);
	if (!$content) {
		$content = elgg_echo('menu:none');
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
 * Edit or add a menu topic
 *
 * @param string $type 'add' or 'edit'
 * @param int    $guid GUID of group or topic
 */
function menu_handle_edit_page($handler, $page, $id) {
	gatekeeper();

	if ($handler == 'item') {

		if ($page == 'add') {

			$category = get_entity($id);
			if (!$category) {
				register_error(elgg_echo('menu:categories:notfound'));
				forward();
			}

			$dine = $category->getOwnerEntity();
			// make sure user has permissions to add a topic to container
			if (!$dine->canEdit()) {
				register_error(elgg_echo('dine:permissions:error'));
				forward($dine->getURL());
			}

			elgg_push_breadcrumb($dine->name, $dine->getURL());
			elgg_push_breadcrumb(elgg_echo('menu:item:add'));

			$title = $dine->name . ' - '
				.elgg_echo('menu:item:add');

			$content = elgg_view('menu/item/edit', array('category' => $category));

		} else if ($page == 'edit') {

			$item = get_entity($id);
			if (!$item) {
				register_error(elgg_echo('menu:item:notfound'));
				forward();
			}

			$dine = $item->getOwnerEntity();
			// make sure user has permissions to add a topic to container
			if (!$dine->canEdit()) {
				register_error(elgg_echo('dine:permissions:error'));
				forward($dine->getURL());
			}

			elgg_push_breadcrumb($dine->name, $dine->getURL());
			elgg_push_breadcrumb(elgg_echo('menu:item:edit'));

			$title = $dine->name . ' - '
				.elgg_echo('menu:item:edit');

			$content = elgg_view('menu/item/edit', array('entity' => $item));

		}

	} else if ($handler == 'categories') {

		if ($page == 'add') {

			$dine = get_user_by_username($id);
			if (!$dine) {
				$dine = get_entity($id);
				if (!$dine) {
					register_error(elgg_echo('dine:notfound'));
					forward();
				}
			}

			// make sure user has permissions to add a topic to container
			if (!$dine->canEdit()) {
				register_error(elgg_echo('dine:permissions:error'));
				forward($dine->getURL());
			}

			elgg_push_breadcrumb($dine->name, $dine->getURL());
			elgg_push_breadcrumb(elgg_echo('menu:categories:add'));

			$title = $dine->name . ' - '
				.elgg_echo('menu:categories:add');

			$content = elgg_view('menu/categories/edit', array('entity' => $dine));

		} else if ($page == 'edit') {

			$category = get_entity($id);
			if (!$category) {
				register_error(elgg_echo('menu:categories:notfound'));
				forward();
			}

			$dine = $category->getOwnerEntity();
			// make sure user has permissions to add a topic to container
			if (!$dine->canEdit()) {
				register_error(elgg_echo('dine:permissions:error'));
				forward($dine->getURL());
			}

			elgg_push_breadcrumb($dine->name, $dine->getURL());
			elgg_push_breadcrumb(elgg_echo('menu:categories:edit'));

			$title = $dine->name . ' - '
				.elgg_echo('menu:categories:edit');

			$content = elgg_view('menu/categories/edit', array('category' => $category, 'dine' => $dine));
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
 * Prepare menu topic form variables
 *
 * @param ElggObject $topic Topic object if editing
 * @return array
 */
function menu_prepare_editcategories_form_vars($dine) {
	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'status' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $topic,
	);

	if ($topic) {
		foreach (array_keys($values) as $field) {
			if (isset($topic->$field)) {
				$values[$field] = $topic->$field;
			}
		}
	}

	if (elgg_is_sticky_form('topic')) {
		$sticky_values = elgg_get_sticky_values('topic');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('topic');

	return $values;
}

