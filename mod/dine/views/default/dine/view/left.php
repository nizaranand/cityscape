<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('dine:notfound');
	return true;
}

$dine = $vars['entity'];
$reviews = elgg_list_entities_from_relationship(array(
	'relationship' => 'review_on',
	'relationship_guid' => $dine->guid,
	'inverse_relationship' => true,
	'full_view' => FALSE,
));
$reviews_title = elgg_view('output/url', array(
	'text' => elgg_echo('reviews'),
	'href' => 'reviews/owner/'.$dine->username,
));

$menu = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'diningmenucategory',
	'owner_guid' => $dine->guid,
	'full_view' => FALSE,
//	'list_type' => 'gallery',
//	'gallery_class' => 'elgg-gallery-users',
));
$menu_title = elgg_view('output/url', array(
	'text' => elgg_echo('menu'),
	'href' => 'menu/view/'.$dine->username,
));

echo "<div class=\"elgg-places-left\">";

echo "<div class=\"elgg-places-profile\">";
echo "<h2>" . $menu_title . "</h3>";
echo $menu;
echo "</div>";

echo "<div class=\"elgg-places-profile\">";
echo "<h2>" . $reviews_title . "</h3>";
echo $reviews;
echo "</div>";

echo "</div>";

?>

