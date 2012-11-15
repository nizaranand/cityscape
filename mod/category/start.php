<?php
/**
 * stores
 *
 * @package stores
 *
 */


elgg_register_event_handler('init', 'system', 'category_init');

/**
 * Init category plugin.
 */
function category_init() {

	elgg_register_library('elgg:category', elgg_get_plugins_path() . 'category/lib/category.php');

	elgg_extend_view('css/elgg', 'category/css');

	elgg_register_page_handler('category', 'category_page_handler');

	elgg_register_entity_url_handler('group', 'category', 'category_url');
	elgg_register_plugin_hook_handler('entity:icon:url', 'group', 'category_icon_url_override');

	// Register an icon handler for events
	elgg_register_page_handler('categoryicon', 'category_icon_handler');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'category/actions/category';
	elgg_register_action("category/edit", "$action_base/edit.php");
	elgg_register_action("category/delete", "$action_base/delete.php");

	// notifications
	register_notification_object('group', 'category', elgg_echo('category:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'category_notify_message');

	// Register for search.
	elgg_register_entity_type('group', 'category');
}

/**
 * Category page handler
 *
 * URLs take the form of
 *  category view:        category/view/<guid>/<title>
 *  New category:            category/add
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function category_page_handler($page) {

	elgg_load_library('elgg:category');

	switch ($page[0]) {
		case 'shop':
			category_handle_view_page($page[0], $page[1]);
			break;
		case 'dine':
			category_handle_view_page($page[0], $page[1]);
			break;
		case 'entertain':
			category_handle_view_page($page[0], $page[1]);
			break;
		case 'add':
			category_handle_edit_page($page[0]);
			break;
		case 'edit':
			category_handle_edit_page($page[0], $page[1]);
			break;
		default:
			return true;
	}
	return true;
}

/**
 * Populates the ->getUrl() method for category entities
 *
 * @param ElggEntity $entity File entity
 * @return string File URL
 */
function category_url($entity) {
	$scope = elgg_get_friendly_title($entity->scope);
	$title = elgg_get_friendly_title($entity->title);

	return "category/$scope/$entity->guid/$title";
}

/**
 * Override the default entity icon for a category
 *
 * @return string Relative URL
 */
function category_icon_url_override($hook, $type, $returnvalue, $params) {
	if (elgg_instanceof($params['entity'], 'group', 'category')) {
		$category = $params['entity'];
		$size = $params['size'];

		if (isset($category->icontime)) {
			// return thumbnail
			$icontime = $category->icontime;
			return "categoryicon/$category->guid/$size/$icontime.jpg";
		}

		return "mod/category/graphics/{$size}.png";
	}
}

/**
 * Handle category icons.
 *
 * @param array $page
 * @return void
 */
function category_icon_handler($page) {

	// The username should be the file we're getting
	if (isset($page[0])) {
		set_input('category_guid', $page[0]);
	}
	if (isset($page[1])) {
		set_input('size', $page[1]);
	}
	// Include the standard profile index
	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/category/icon.php");
	return true;
}

