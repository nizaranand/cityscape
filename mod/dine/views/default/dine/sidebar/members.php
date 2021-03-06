<?php
/**
 * Course members sidebar
 *
 * @package ElggCourses
 *
 * @uses $vars['entity'] Course entity
 * @uses $vars['limit']  The number of members to display
 */

$limit = elgg_extract('limit', $vars, 10);

$all_link = elgg_view('output/url', array(
	'href' => 'courses/members/' . $vars['entity']->guid,
	'text' => elgg_echo('courses:members:more'),
	'is_trusted' => true,
));

$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => true,
	'types' => 'user',
	'metadata_names' => 'position',
	'metadata_values' => 'facultymember',
	'limit' => $limit,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

$body .= "<div class='center mts'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('courses:members:staff'), $body);

$body = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => true,
	'types' => 'user',
	'metadata_names' => 'position',
	'metadata_values' => 'student',
	'limit' => $limit,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));

$body .= "<div class='center mts'>$all_link</div>";

echo elgg_view_module('aside', elgg_echo('courses:members:students'), $body);

