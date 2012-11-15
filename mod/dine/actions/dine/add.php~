<?php
/**
 * Elgg add action
 *
 * @package Elgg
 * @subpackage Core
 */

elgg_load_library('elgg:dine');

elgg_make_sticky_form('useradd');

// Get variables
$username = get_input('username');
$email = get_input('email');
$name = get_input('name');
$category_guid = get_input('category_guid');
$category = get_entity($category_guid);

// no blank fields
if ($username == '' || $email == '' || $name == '') {
	register_error(elgg_echo('register:fields'));
	forward(REFERER);
}

$password = "cityscape";

// For now, just try and register the user
try {
	$guid = register_dine($username, $password, $name, $email, FAlSE);

	if ($guid) {
		$new_user = get_entity($guid);
		elgg_clear_sticky_form('useradd');

		$category->join($new_user);

		$new_user->admin_created = TRUE;
		// @todo ugh, saving a guid as metadata!
		$new_user->created_by_guid = elgg_get_logged_in_user_guid();

		$subject = elgg_echo('useradd:subject');
		$body = elgg_echo('useradd:body', array(
			$name,
			elgg_get_site_entity()->name,
			elgg_get_site_entity()->url,
			$username,
			$password,
		));

		notify_user($new_user->guid, elgg_get_site_entity()->guid, $subject, $body);

		system_message(elgg_echo("adduser:ok", array(elgg_get_site_entity()->name)));
	} else {
		register_error(elgg_echo("adduser:bad"));
	}
} catch (RegistrationException $r) {
	register_error($r->getMessage());
}
forward('category/dine/'.$category->guid);

