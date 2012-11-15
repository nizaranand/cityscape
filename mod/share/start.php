<?php
/**
 * Share plugin
 *
 * @package Cityscape.Share
 */

elgg_register_event_handler('init', 'system', 'share_init');

/**
 * Initialize the share plugin.
 */
function share_init() {

	elgg_register_library('elgg:share', elgg_get_plugins_path() . 'share/lib/share.php');

	$site_url = elgg_get_site_url();

	// Set up the menu
	$fb_page = "http://www.facebook.com/CityscapeMall";
	$item = new ElggMenuItem('fb_page', '', $fb_page);
	$item->setLinkClass('f-link');
	$item->setPriority(1);
	elgg_register_menu_item('extras', $item);

	$t_account = "http://www.twitter.com/cityscapemall";
	$item = new ElggMenuItem('t_page', '', $t_account);
	$item->setTooltip('Follow us on Twitter');
	$item->setLinkClass('t-logo');
	$item->setPriority(2);
	elgg_register_menu_item('extras', $item);

	elgg_unregister_menu_item('extras', 'rss');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('share', 'share_page_handler');

	//extend some views
	elgg_extend_view('css/elgg', 'share/css');
	elgg_extend_view('js/elgg', 'share/js');

}

/**
 * share page handler
 *
 * URLs take the form of
 *  Facebook like:           groups/all
 *
 * @param array $page Array of url segments for routing
 * @return bool
 */
function share_page_handler($page) {

	elgg_load_library('elgg:share');

	switch ($page[0]) {
		case 'fb':
			share_handle_fb_page();
			break;
		default:
			return false;
	}
	return true;
}

