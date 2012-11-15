<?php
/**
 * Delete dining menu category entity
 *
 * @package Event
 */

$category_guid = get_input('guid');
$category = get_entity($category_guid);

if (elgg_instanceof($category, 'object', 'diningmenucategory') && $category->canEdit()) {
	if ($category->delete()) {
		system_message(elgg_echo('menu:categories:deleted'));
	} else {
		register_error(elgg_echo('menu:categories:deletefailed'));
	}
} else {
	register_error(elgg_echo('menu:categories:notfound'));
}

forward(REFERER);

