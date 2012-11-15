<?php
/**
 * Cover photo
 *
 * @package Cityscape.Coverphoto
 *
 */


elgg_register_event_handler('init', 'system', 'coverphoto_init');

/**
 * Init cover photo plugin.
 */
function coverphoto_init() {

	elgg_register_library('elgg:coverphoto', elgg_get_plugins_path() . 'coverphoto/lib/coverphoto.php');

	elgg_extend_view('css/elgg', 'coverphoto/css');

	// routing of urls
	elgg_register_page_handler('coverphoto', 'coverphoto_page_handler');

	// override the default url to view a cover photo object
	elgg_register_entity_url_handler('object', 'coverphoto', 'coverphoto_url');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'coverphoto_icon_url_override');

	// Register an icon handler for cover photo
	elgg_register_page_handler('coverphotoicon', 'coverphoto_icon_handler');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'coverphoto/actions/coverphoto';
	elgg_register_action("coverphoto/upload", "$action_base/upload.php");
	elgg_register_action("coverphoto/crop", "$action_base/crop.php");

}

/**
 * Cover photo page handler
 *
 * URLs take the form of
 *  Edit cover photo:           coverphoto/edit/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function coverphoto_page_handler($page) {

	elgg_load_library('elgg:coverphoto');

	elgg_push_breadcrumb(elgg_echo('coverphoto'), "coverphoto/edit");

	switch ($page[0]) {
		case 'edit':
			coverphoto_handle_edit_page($page[0], $guid = $page[1]);
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Override the default entity icon for the cover photo
 *
 * @return string Relative URL
 */
function coverphoto_icon_url_override($hook, $type, $returnvalue, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'coverphoto')) {
		$coverphoto = $params['entity'];
		$size = $params['size'];

		if (isset($coverphoto->icontime)) {
			// return thumbnail
			$icontime = $coverphoto->icontime;
			return "coverphotoicon/$coverphoto->guid/$size/$icontime.jpg";
		}

		return "mod/coverphoto/graphics/{$size}.png";
	}
}

/**
 * Handle cover photo icons.
 *
 * @param array $page
 * @return void
 */
function coverphoto_icon_handler($page) {

	// The username should be the file we're getting
	if (isset($page[0])) {
		set_input('coverphoto_guid', $page[0]);
	}
	if (isset($page[1])) {
		set_input('size', $page[1]);
	}
	// Include the standard profile index
	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/coverphoto/icon.php");
	return true;
}


