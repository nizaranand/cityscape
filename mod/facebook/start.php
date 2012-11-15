<?php
/**
 * Facebook plugin
 *
 * @package Cityscape.Facebook
 */

elgg_register_event_handler('init', 'system', 'facebook_init');

/**
 * Initialise facebook plugin
 *
 */
function facebook_init() {

	elgg_register_library('elgg:facebook', elgg_get_plugins_path() . 'facebook/lib/facebook.php');

	elgg_extend_view('css/elgg', 'facebook/css');

	$code = $_REQUEST["code"];

	if(empty($code)) {
		$app_id = elgg_get_plugin_setting('appid');
		$app_secret = elgg_get_plugin_setting('appsecret');
		$redirect_url = elgg_get_site_url();
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
		$fb_login_url = "https://www.facebook.com/dialog/oauth?client_id=" 
			. $app_id . "&redirect_uri=" . $redirect_url . "&state="
			. $_SESSION['state'] . "&scope=email";

		// add an extras navigatio
		if (!elgg_is_logged_in()) {
			$item = new ElggMenuItem('facebook_login', elgg_echo('facebook:login'), $fb_login_url);
			$item->setLinkClass('f-link');
			elgg_register_menu_item('extras', $item);
		}
	}
	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
		// state variable matches
		$token_url = "https://graph.facebook.com/oauth/access_token?"
			."client_id=" . $app_id . "&redirect_uri=" . $redirect_url
			."&client_secret=" . $app_secret . "&code=" . $code;

		$response = file_get_contents($token_url);
		$params = null;
		parse_str($response, $params);
		system_message(elgg_echo('facebook:statematch'));
	} else {
		register_error(elgg_echo('facebook:statenotmatch'));
	}

	elgg_register_page_handler('facebook', 'facebook_page_handler');

}

