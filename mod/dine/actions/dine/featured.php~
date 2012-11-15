<?php	
/**
 * Feature a dine
 *
 * @package ElggDine
 */

$dine_guid = get_input('dine_guid');
$action = get_input('action_type');

$dine = get_entity($dine_guid);

if (elgg_instanceof($page_owner, 'object', 'dine')) {
	register_error(elgg_echo('dine:featured_error'));
	forward(REFERER);
}

//get the action, is it to feature or unfeature
if ($action == "feature") {
	$dine->featured = "yes";
	system_message(elgg_echo('dine:featuredon', array($dine->name)));
} else {
	$dine->featured = "no";
	system_message(elgg_echo('dine:unfeatured', array($dine->name)));
}

forward(REFERER);
