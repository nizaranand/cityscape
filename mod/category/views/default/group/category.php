<?php
/**
 * View for category objects
 *
 * @package Book
 */

$full = elgg_extract('full_view', $vars, FALSE);
$category = elgg_extract('entity', $vars, FALSE);
$icon_size = elgg_extract('icon_size', $vars, 'small');
$metadata = elgg_extract('metadata', $vars, FALSE);

if (!$category) {
	return TRUE;
}

$owner_icon = elgg_view_entity_icon($category, $icon_size);
$subtitle = $category->description;
if($metadata) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'category',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
} else {
	$metadata = '';
}

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if (elgg_get_context() == 'gallery') {
	$icon = elgg_view_entity_icon($category, 'medium');

	echo "<div class=\"elgg-places-profile\">";
	echo "<div class=\"elgg-places-icon\">";
	echo $icon;
	echo "</div>";
	echo "<div class=\"elgg-places-title\">";
	echo "<h3>".$category->title."</h3>";
	echo "</div>";
	echo "</div>";
} else {
	if ($full) {

		$body = elgg_list_entities_from_relationship(array(
			'relationship' => 'member',
			'relationship_guid' => $category->guid,
			'inverse_relationship' => true,
			'types' => 'user',
			'limit' => 40,
	//		'list_type' => 'gallery',
	//		'gallery_class' => 'elgg-gallery-users',
		));

		echo elgg_view('object/elements/full', array(
			'body' => $body,
		));

	} else {
		// brief view

		$params = array(
			'entity' => $category,
			'metadata' => $metadata,
		);
		$params = $params + $vars;
		echo elgg_view('object/elements/summary', $params);

//		echo elgg_view_image_block($owner_icon, $list_body);
	}
}
