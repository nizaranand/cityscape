<?php
/**
 * Group profile fields
 */

$category = $vars['entity'];
$stores = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
	'types' => 'user',
//	'limit' => $limit,
//	'list_type' => 'gallery',
//	'gallery_class' => 'elgg-gallery-users',
));


echo $stores;
