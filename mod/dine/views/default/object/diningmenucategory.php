<?php
/**
 * View for event objects
 *
 * @package Event
 */

$category = elgg_extract('entity', $vars, FALSE);
$full = elgg_extract('full_view', $vars, FALSE);

if (!$category) {
	return TRUE;
}

$owner = $category->getOwnerEntity();

$subcategories = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'diningmenucategory',
	'owner_guid' => $category->guid,
	'full_view' => false,
));

$items = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'diningmenuitem',
	'owner_guid' => $category->guid,
	'full_view' => true,
));

$url = elgg_get_site_url();
if ($category->getIconURL() == $url.'blank') {
	$category_icon = '';
} else {
	if ($full) {
		$category_icon = elgg_view_entity_icon($category, 'large');
	} else {
		$category_icon = elgg_view_entity_icon($category, 'medium');
	}
}

if (elgg_is_logged_in()) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'menu/categories',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

if (elgg_get_context() == 'gallery') {
	$icon = elgg_view_entity_icon($category, 'medium', $vars);
	echo $icon;
} else {
	if ($full) {
		$params = array(
			'title' => $category->title,
			'metadata' => $metadata,
			'content' => $category->description,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);

		echo $subcategories . $items;
		echo elgg_view_image_block($category_icon, $list_body);
	} else {
		$params = array(
			'title' => $category->title,
			'metadata' => FALSE,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);

		echo elgg_view_image_block($category_icon, $list_body);
	}
}
