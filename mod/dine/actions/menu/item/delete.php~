<?php
/**
 * Delete dining menu category entity
 *
 * @package Event
 */

$item_guid = get_input('guid');
$item = get_entity($item_guid);

if (elgg_instanceof($item, 'object', 'diningmenuitem') && $item->canEdit()) {
	if ($item->delete()) {
		system_message(elgg_echo('menu:item:deleted'));
	} else {
		register_error(elgg_echo('menu:item:deletefailed'));
	}
} else {
	register_error(elgg_echo('menu:item:notfound'));
}

forward(REFERER);

