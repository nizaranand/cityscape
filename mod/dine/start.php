<?php
/**
 * dine
 *
 * @package dine
 *
 */


elgg_register_event_handler('init', 'system', 'dine_init');

// Ensure this runs after other plugins
elgg_register_event_handler('init', 'system', 'dine_fields_setup', 10000);

/**
 * Init dine plugin.
 */
function dine_init() {

	elgg_register_library('elgg:dine', elgg_get_plugins_path() . 'dine/lib/dine.php');

	elgg_unregister_menu_item('topbar', 'friends');
	elgg_unregister_menu_item('entity', 'access_id');

	// add a site navigation item
	$item = new ElggMenuItem('dine', elgg_echo('dine:dine'), 'dine/all');
	elgg_register_menu_item('site', $item);

	elgg_extend_view('css/elgg', 'dine/css');

	// routing of urls
	elgg_register_page_handler('dine', 'dine_page_handler');

	// override the default url to view a dine entity
	elgg_register_entity_url_handler('user', 'dine', 'dine_url');

	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'dine_override_icon_url');
	elgg_unregister_plugin_hook_handler('entity:icon:url', 'user', 'dine', 'user_avatar_hook');

	elgg_register_simplecache_view('icon/user/dine/tiny');
	elgg_register_simplecache_view('icon/user/dine/topbar');
	elgg_register_simplecache_view('icon/user/dine/small');
	elgg_register_simplecache_view('icon/user/dine/medium');
	elgg_register_simplecache_view('icon/user/dine/large');
	elgg_register_simplecache_view('icon/user/dine/master');

	// Register some actions
	$action_base = elgg_get_plugins_path() . 'dine/actions/dine';
	elgg_register_action("dine/add", "$action_base/add.php");
	elgg_register_action("dine/edit", "$action_base/add.php");
	elgg_register_action("dine/featured", "$action_base/featured.php");

	// notifications
	register_notification_object('user', 'dine', elgg_echo('dine:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'dine_notify_message');

	// Register for search.
	elgg_register_entity_type('user', 'dine');

	elgg_register_event_handler('pagesetup', 'system', 'dine_setup_sidebar_menus');

	// Extend avatar hover menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'dine_user_hover_menu');
}

/**
 * This function loads a set of default fields into the profile, then triggers
 * a hook letting other plugins to edit add and delete fields.
 *
 * Note: This is a system:init event triggered function and is run at a super
 * low priority to guarantee that it is called after all other plugins have
 * initialized.
 */
function dine_fields_setup() {

	$profile_defaults = array(
		'description' => 'longtext',
		'briefdescription' => 'text',
		'website' => 'url',
		'twitter' => 'url',
		'facebook' => 'url',
		'googleplus' => 'url',
	);

	$profile_defaults = elgg_trigger_plugin_hook('profile:fields', 'group', NULL, $profile_defaults);

	elgg_set_config('dine', $profile_defaults);

	// register any tag metadata names
	foreach ($profile_defaults as $name => $type) {
		if ($type == 'tags') {
			elgg_register_tag_metadata_name($name);

			// only shows up in search but why not just set this in en.php as doing it here
			// means you cannot override it in a plugin
			add_translation(get_current_language(), array("tag_names:$name" => elgg_echo("groups:$name")));
		}
	}
}

/**
 * Add to the user hover menu
 */
function dine_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];

	if (elgg_instanceof($user, 'user', 'dine') && elgg_is_logged_in() && elgg_get_logged_in_user_guid() == $user->guid) {
		$url = "messages/compose?send_to={$user->guid}";
		$item = new ElggMenuItem('add', elgg_echo('dine:addoffer'), $url);
		$item->setSection('action');
		$return[] = $item;
	}

	return $return;
}


/**
 * dine page handler
 *
 * URLs take the form of
 *  dine place view:        dine/view/<guid>/<title>
 *  User's followed dine: dine/joined/<username>
 *  New dine place:            dine/add
 *  dine activity:       dine/activity/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function dine_page_handler($page) {

	elgg_load_library('elgg:dine');

	elgg_push_breadcrumb(elgg_echo('dine'), "dine/all");

	switch ($page[0]) {
		case 'all':
			dine_handle_all_page();
			break;
		case 'search':
			dine_search_page();
			break;
		case 'menu':
			dine_handle_menu_page($page[1]);
			break;
		case 'add':
			dine_handle_add_page($page[1]);
			break;
		case 'edit':
			dine_handle_edit_page($page[1]);
			break;
		default:
			dine_handle_view_page($page[0]);
	}
	return true;
}

/**
 * Populates the ->getUrl() method for dine entities
 *
 * @param ElggEntity $entity File entity
 * @return string File URL
 */
function dine_url($entity) {
	$title = elgg_get_friendly_title($entity->username);

	return "dine/$title";
}

/**
 * Use a URL for avatars that avoids loading Elgg engine for better performance
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $return_value
 * @param array  $params
 * @return string
 */
function dine_override_icon_url($hook, $entity_type, $return_value, $params) {

	// if someone already set this, quit
	if ($return_value) {
		return null;
	}

	$user = $params['entity'];
	$size = $params['size'];
	
	if (!elgg_instanceof($user, 'user', 'dine')) {
		return null;
	}

	$user_guid = $user->getGUID();
	$icon_time = $user->icontime;

	if (!$icon_time) {
		return "mod/dine/graphics/icons/user/dine/{$size}.png";
	}

	if ($user->isBanned()) {
		return null;
	}

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $user_guid;
	$filehandler->setFilename("profile/{$user_guid}{$size}.jpg");

	try {
		if ($filehandler->exists()) {
			$join_date = $user->getTimeCreated();
			return "mod/profile/icondirect.php?lastcache=$icon_time&joindate=$join_date&guid=$user_guid&size=$size";
		}
	} catch (InvalidParameterException $e) {
		elgg_log("Unable to get profile icon for user with GUID $user_guid", 'ERROR');
		return "graphics/icons/user/dine/$size.png";
	}

	return null;
}

/**
 * Configure the dine sidebar menu. Triggered on page setup
 *
 */
function dine_setup_sidebar_menus() {

	// Get the page owner entity
	$page_owner = elgg_get_page_owner_entity();

	if (elgg_get_context() == 'dine') {
		$categories = elgg_get_entities_from_metadata(array(
			'type' => 'group',
			'subtype' => 'category',
			'metadata_name' => 'scope',
			'metadata_value' => 'dine',
		));
		if($categories) {
			foreach($categories as $category) {
				elgg_register_menu_item('page', array(
					'name' => $category->title,
					'text' => $category->title,
					'href' => $category->getURL(),
				));
			}
		}
	}
}

/**
 * Menu
 *
 */

elgg_register_event_handler('init', 'system', 'menu_init');

/**
 * Initialize the menu component
 */
function menu_init() {

	elgg_register_library('elgg:menu', elgg_get_plugins_path() . 'dine/lib/menu.php');

	elgg_register_page_handler('menu', 'menu_page_handler');

	elgg_register_entity_url_handler('object', 'diningmenu', 'menu_override_url');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'menu_categories_icon_url_override');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'menu_item_icon_url_override');

	// Register an icon handler for events
	elgg_register_page_handler('menucategoryicon', 'menu_categories_icon_handler');
	elgg_register_page_handler('menuitemicon', 'menu_item_icon_handler');

	// commenting not allowed on menu (use a different annotation)
	elgg_register_plugin_hook_handler('permissions_check:comment', 'object', 'menu_comment_override');
	
	$action_base = elgg_get_plugins_path() . 'dine/actions/menu';
	elgg_register_action('menu/save', "$action_base/save.php");
	elgg_register_action('menu/delete', "$action_base/delete.php");

	$item_action_base .= $action_base . '/item';
	elgg_register_action('menu/item/edit', "$item_action_base/edit.php");
	elgg_register_action('menu/item/delete', "$item_action_base/delete.php");

	$categories_action_base .= $action_base . '/categories';
	elgg_register_action('menu/categories/edit', "$categories_action_base/edit.php");
	elgg_register_action('menu/categories/delete', "$categories_action_base/delete.php");

	// add link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'menu_owner_block_menu');

	// add link to owner block
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'menu_entity_menu');

	// Register for search.
	elgg_register_entity_type('object', 'diningmenu');

	// notifications
	register_notification_object('object', 'diningmenu', elgg_echo('diningmenu:new'));
	elgg_register_plugin_hook_handler('object:notifications', 'object', 'group_object_notifications_intercept');
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'diningmenu_notify_message');
}

/**
 * Menu page handler
 *
 * URLs take the form of
 *  All menus in site:    menu/all
 *  List items in menu:  menu/owner/<username>
 *  View menu: menu/view/<guid>
 *  Add menu:  menu/add/<guid>
 *  Edit menu: menu/edit/<guid>
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function menu_page_handler($page) {

	elgg_load_library('elgg:menu');

	elgg_push_breadcrumb(elgg_echo('menu'), 'menu/all');

	switch ($page[0]) {
		case 'item':
			menu_handle_edit_page($page[0], $page[1], $page[2]);
			break;
		case 'categories':
			menu_handle_edit_page($page[0], $page[1], $page[2]);
			break;
		case 'view':
			menu_handle_view_page($page[1]);
			break;
		default:
			return false;
	}
	return true;
}

/**
 * Override the menu url
 *
 * @param ElggObject $entity Menu topic
 * @return string
 */
function menu_override_url($entity) {
	$owner = $entity->getOwnerEntity();
	return 'menu/view/' . $owner->username;
}

/**
 * We don't want people commenting on topics in the river
 */
function menu_comment_override($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'diningmenu')) {
		return false;
	}
}

/**
 * Add owner block link
 */
function menu_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user', 'dine')) {
		$url = "menu/view/{$params['entity']->username}";
		$item = new ElggMenuItem('menu', elgg_echo('menu'), $url);
		$return[] = $item;
	}

	return $return;
}

/**
 * Add owner block link
 */
function menu_entity_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'diningmenucategory')) {

		$url = "menu/item/add/{$params['entity']->guid}";
		$item = new ElggMenuItem('menu:item:add', elgg_echo('menu:item:add'), $url);
		$return[] = $item;

		$url = "menu/categories/add/{$params['entity']->guid}";
		$item = new ElggMenuItem('menu:categories:addsubcategory', elgg_echo('menu:categories:addsubcategory'), $url);
		$return[] = $item;

	} else if (elgg_instanceof($params['entity'], 'object', 'diningmenuitem')) {

		$url = "";
		$item = new ElggMenuItem('menu:item:price', elgg_echo('menu:item:price').': '.elgg_echo('menu:item:currency').$params['entity']->price, $url);
		$return[] = $item;

	}

	return $return;
}

/**
 * Override the default entity icon for menu categories
 *
 * @return string Relative URL
 */
function menu_categories_icon_url_override($hook, $type, $returnvalue, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'diningmenucategory')) {
		$category = $params['entity'];
		$size = $params['size'];

		if (isset($category->icontime)) {
			// return thumbnail
			$icontime = $category->icontime;
			return "menucategoryicon/$category->guid/$size/$icontime.jpg";
		}

		return "blank";
	}
}

/**
 * Override the default entity icon for menu item
 *
 * @return string Relative URL
 */
function menu_item_icon_url_override($hook, $type, $returnvalue, $params) {
	if (elgg_instanceof($params['entity'], 'object', 'diningmenuitem')) {
		$item = $params['entity'];
		$size = $params['size'];

		if (isset($item->icontime)) {
			// return thumbnail
			$icontime = $item->icontime;
			return "menuitemicon/$item->guid/$size/$icontime.jpg";
		}

		return "mod/dine/graphics/{$size}.png";
	}
}

/**
 * Handle menu categories icons.
 *
 * @param array $page
 * @return void
 */
function menu_categories_icon_handler($page) {

	// The username should be the file we're getting
	if (isset($page[0])) {
		set_input('category_guid', $page[0]);
	}
	if (isset($page[1])) {
		set_input('size', $page[1]);
	}
	// Include the standard profile index
	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/dine/menucategoryicon.php");
	return true;
}

/**
 * Handle menu item icons.
 *
 * @param array $page
 * @return void
 */
function menu_item_icon_handler($page) {

	// The username should be the file we're getting
	if (isset($page[0])) {
		set_input('item_guid', $page[0]);
	}
	if (isset($page[1])) {
		set_input('size', $page[1]);
	}
	// Include the standard profile index
	$plugin_dir = elgg_get_plugins_path();
	include("$plugin_dir/dine/menuitemicon.php");
	return true;
}

