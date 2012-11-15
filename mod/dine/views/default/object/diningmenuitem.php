<?php
/**
 * View for event objects
 *
 * @package Event
 */

$item = elgg_extract('entity', $vars, FALSE);

if (!$item) {
	return TRUE;
}

$url = elgg_get_site_url();
if ($item->getIconURL() == $url.'blank') {
	$item_icon = '';
} else {
	$item_icon = elgg_view_entity_icon($item, 'medium');
}

if (elgg_is_logged_in()) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'menu/categories',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$params = array(
	'title' => $item->title,
	'content' => $item->description,
	'metadata' => $metadata,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($item_icon, $list_body);

