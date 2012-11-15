<?php
/**
 * Layout of the category view page
 *
 * @uses $vars['entity']
 */

//echo elgg_view('category/view/summary', $vars);
//echo elgg_view('category/view/widgets', $vars);

echo "<div class=\"elgg-places-profile\">";

$category = $vars['entity'];

$icon = elgg_view_entity_icon($category, 'medium');

$params = array(
	'content' => $category-> description,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($icon, $list_body);
echo "</div>";

echo elgg_view('category/view/left', $vars);


$members = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'subtype' => $category->scope,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

echo "<div class=\"elgg-places-profile\">";
echo $members;
echo "</div>";

