<?php
/**
 * Dine function library
 */

/**
 * List all dine
 */
function dine_handle_all_page() {

	// all groups doesn't get link to self
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb(elgg_echo('dine'));

	$dine = get_entity($guid);

	if (elgg_is_admin_logged_in()) {
		elgg_register_menu_item('title', array(
			'name' => 'category:add',
			'href' => 'category/add?scope=dine',
			'text' => elgg_echo('category:add'),
			'link_class' => 'elgg-button elgg-button-action',
		));
	}

	$selected_tab = get_input('filter', 'newest');

	switch ($selected_tab) {
		case 'popular':
			$content = elgg_list_entities(array(
				'type' => 'group',
				'subtype' => 'dinecategory',
				'order_by' => 'e.last_action desc',
				'limit' => 40,
				'full_view' => false,
			));
			if (!$content) {
				$content = elgg_echo('dine:none');
			}
			break;
/*		case 'discussion':
			$content = elgg_list_entities(array(
				'type' => 'object',
				'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc',
				'limit' => 40,
				'full_view' => false,
			));
			if (!$content) {
				$content = elgg_echo('discussion:none');
			}
			break;
*/		case 'newest':
		default:
			$content = elgg_list_entities_from_metadata(array(
				'type' => 'group',
				'subtype' => 'category',
				'metadata_name' => 'scope',
				'metadata_value' => 'dine',
				'full_view' => false,
				'list_type' => 'gallery',
				'gallery_class' => 'elgg-gallery-users',
			));
			if (!$content) {
				$content = elgg_echo('dine:none');
			}
			break;
	}

	$filter = elgg_view('dine/group_sort_menu', array('selected' => $selected_tab));
	
//	$sidebar = elgg_view('groups/sidebar/find');
//	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => $filter,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page(elgg_echo('dine:all'), $body);
}

function groups_search_page() {
	elgg_push_breadcrumb(elgg_echo('search'));

	$tag = get_input("tag");
	$title = elgg_echo('groups:search:title', array($tag));

	// groups plugin saves tags as "interests" - see groups_fields_setup() in start.php
	$params = array(
		'metadata_name' => 'interests',
		'metadata_value' => $tag,
		'types' => 'group',
		'full_view' => FALSE,
	);
	$content = elgg_list_entities_from_metadata($params);
	if (!$content) {
		$content = elgg_echo('groups:search:none');
	}

	$sidebar = elgg_view('groups/sidebar/find');
	$sidebar .= elgg_view('groups/sidebar/featured');

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => false,
		'title' => $title,
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Add a dine
 *
 * @param string $page
 * @param int $guid
 */
function dine_handle_add_page($guid) {
	admin_gatekeeper();

	$category = get_entity($guid);
	
	elgg_set_page_owner_guid($guid);
	$title = elgg_echo('dine:add');
	elgg_push_breadcrumb($category->title, $category->getURL());
	elgg_push_breadcrumb($title);
	$content = elgg_view('dine/add', array('category_guid' => $guid));
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Edit a dine
 *
 * @param string $page
 * @param int $guid
 */
function dine_handle_edit_page($username) {
	admin_gatekeeper();
	
	$user = get_user_by_username($username);
	
	elgg_set_page_owner_guid($guid);
	$title = elgg_echo('dine:edit');
	elgg_push_breadcrumb($category->title, $category->getURL());
	elgg_push_breadcrumb($title);
	$content = elgg_view('dine/add', array('category_guid' => $guid));
	
	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Group invitations for a user
 */
function groups_handle_invitations_page() {
	gatekeeper();

	$user = elgg_get_page_owner_entity();

	$title = elgg_echo('groups:invitations');
	elgg_push_breadcrumb($title);

	// @todo temporary workaround for exts #287.
	$invitations = groups_get_invited_groups(elgg_get_logged_in_user_guid());
	$content = elgg_view('groups/invitationrequests', array('invitations' => $invitations));

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * List owned groups
 */
/**
 * Create or edit a dine
 *
 * @param string $page
 * @param int $guid
 */
function dine_handle_addcategory_page() {
	admin_gatekeeper();
	
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dine:addcategory');
	elgg_push_breadcrumb($title);
	$content = elgg_view('dine/addcategory');

	$params = array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($title, $body);
}

/**
 * Dine view page
 *
 * @param int $guid Dine entity GUID
 */
function dine_handle_view_page($username) {

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$user = get_user_by_username($username);

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}

	$category = $user->getGroups('', 1);
	if ($category) {
//		forward('http://facebook.com');
		$category = $category[0];
		elgg_push_breadcrumb($category->title, $category->getURL());
	}

	dine_register_view_buttons($user);

	elgg_set_page_owner_guid($user->guid);

	elgg_push_breadcrumb($user->name);

	$content = elgg_view('dine/view/layout', array('entity' => $user));

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'filter' => '',
	);
	$body = elgg_view_layout('one_column', $params);

	echo elgg_view_page($user->name, $body);
}

/**
 * Dine view page
 *
 * @param int $guid Dine entity GUID
 */
function dine_handle_menu_page($username) {

	// turn this into a core function
	global $autofeed;
	$autofeed = true;

	$user = get_user_by_username($username);

	// short circuit if invalid or banned username
	if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}

	if ($user->canEdit()) {
		elgg_register_menu_item('title', array(
			'name' => 'dine:menu:add:categories',
			'href' => "dine/menu/addcategories/{$user->username}",
			'text' => elgg_echo('dine:menu:add:categories'),
			'link_class' => 'elgg-button elgg-button-action',
		));
	}

	elgg_set_page_owner_guid($user->guid);

	elgg_push_breadcrumb($user->name);
	elgg_push_breadcrumb(elgg_echo('dine:menu'));

	$content = elgg_view('dine/view/layout', array('entity' => $user, 'page_context' => 'menu'));

	$params = array(
		'content' => $content,
		'sidebar' => $sidebar,
		'title' => $user->name.' - '.elgg_echo('dine:menu'),
		'filter' => '',
	);
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($user->name.' - '.elgg_echo('dine:menu'), $body);
}

/**
 * Registers the buttons for title area of the dine profile page
 *
 * @param ElggGroup $dine
 */
function dine_register_view_buttons($entity) {

	$actions = array();
	if(elgg_instanceof($entity, 'user', 'dine')) {

		// dine owners
		if ($entity->canEdit()) {
			// edit icon
			$url = elgg_get_site_url() . "/avatar/edit/{$entity->username}";
			$actions[$url] = 'dine:editicon';

			// edit
			$url = elgg_get_site_url() . "/profile/{$entity->username}/edit";
			$actions[$url] = 'dine:editinfo';

			// edit
			$url = elgg_get_site_url() . "/coverphoto/edit/{$entity->guid}";
			$actions[$url] = 'dine:editcoverphoto';

			if (elgg_is_admin_logged_in()) {
				if($entity->featured == 'yes') {
					$url = elgg_get_site_url() . "action/dine/featured?dine_guid={$entity->getGUID()}&action_type=unfeature";
					$url = elgg_add_action_tokens_to_url($url);
					$actions[$url] = 'dine:makeunfeatured';
				} else {
					$url = elgg_get_site_url() . "action/dine/featured?dine_guid={$entity->getGUID()}&action_type=feature";
					$url = elgg_add_action_tokens_to_url($url);
					$actions[$url] = 'dine:makefeatured';
				}
			}
		}

	}

	if ($actions) {
		foreach ($actions as $url => $text) {
			elgg_register_menu_item('title', array(
				'name' => $text,
				'href' => $url,
				'text' => elgg_echo($text),
				'link_class' => 'elgg-button elgg-button-action',
			));
		}
	}
}

/**
 * Registers a dine, returning false if the username already exists
 *
 * @param string $username              The username of the new user
 * @param string $password              The password
 * @param string $name                  The user's display name
 * @param string $email                 Their email address
 * @param bool   $allow_multiple_emails Allow the same email address to be
 *                                      registered multiple times?
 * @param int    $friend_guid           GUID of a user to friend once fully registered
 * @param string $invitecode            An invite code from a friend
 *
 * @return int|false The new user's GUID; false on failure
 */
function register_dine($username, $password, $name, $email,
$allow_multiple_emails = false) {

//	forward('http://facebook.com');
	// Load the configuration
	global $CONFIG;

	// no need to trim password.
	$username = trim($username);
	$name = trim(strip_tags($name));
	$email = trim($email);

	// A little sanity checking
	if (empty($username)
	|| empty($password)
	|| empty($name)
	|| empty($email)) {
		return false;
	}

	// Make sure a user with conflicting details hasn't registered and been disabled
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	if (!validate_email_address($email)) {
		throw new RegistrationException(elgg_echo('registration:emailnotvalid'));
	}

	if (!validate_password($password)) {
		throw new RegistrationException(elgg_echo('registration:passwordnotvalid'));
	}

	if (!validate_username($username)) {
		throw new RegistrationException(elgg_echo('registration:usernamenotvalid'));
	}

	if ($user = get_user_by_username($username)) {
		throw new RegistrationException(elgg_echo('registration:userexists'));
	}

	if ((!$allow_multiple_emails) && (get_user_by_email($email))) {
		throw new RegistrationException(elgg_echo('registration:dupeemail'));
	}

	access_show_hidden_entities($access_status);

	// Create user
	$user = new ElggDine();
	$user->username = $username;
	$user->email = $email;
	$user->name = $name;
	$user->access_id = ACCESS_PUBLIC;
	$user->salt = generate_random_cleartext_password(); // Note salt generated before password!
	$user->password = generate_user_password($user, $password);
	$user->owner_guid = 0; // Users aren't owned by anyone, even if they are admin created.
	$user->container_guid = 0; // Users aren't contained by anyone, even if they are admin created.
	$user->language = get_current_language();
	$user->save();


	// Turn on email notifications by default
	set_user_notification_setting($user->getGUID(), 'email', true);

	return $user->getGUID();
}

