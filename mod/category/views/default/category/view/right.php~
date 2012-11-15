<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

$members = elgg_list_entities_from_relationship(array(
	'type' => 'object',
	'subtype' => 'offer',
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

echo "<div class=\"elgg-places-left\">";
echo "<div class=\"elgg-places-profile\">";
echo $members;
echo "</div>";
echo "</div>";

