<?php
/**
 * Cityscape theme plugin
 *
 * @package Cityscape.Theme
 */

elgg_register_event_handler('init', 'system', 'cityscapetheme_init');

/**
 * Initialize the cityscape theme plugin.
 */
function cityscapetheme_init() {

	//extend some views
	elgg_extend_view('css/elgg', 'cityscapetheme/css');
	elgg_extend_view('js/elgg', 'cityscapetheme/js');

	elgg_register_plugin_hook_handler('register', 'menu:topbar', 'remove_items');
}

/**
 * Remove unused items from the topbar.
 * It is done in this way instead of using the builtin function elgg_unregister_menu_item,
 * cause the function can't remove the friends item from the topbar menu.
 */
function remove_items($hook, $type, $menu_items, $option) {
	foreach($menu_items as $i => $item) {
		if ($item->getName() == 'elgg_logo') {
			unset($menu_items[$i]);
		} else if ($item->getName() == 'friends') {
			unset($menu_items[$i]);
		}
	}

	return $menu_items;
}
