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

$offers = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'offer',
	'owner_guid' => $dine->guid,
	'full_view' => false,
));
$offers_title = elgg_view('output/url', array(
	'text' => elgg_echo('offers'),
	'href' => 'offers/owner/'.$dine->username,
));

$events = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'event',
	'owner_guid' => $dine->guid,
	'full_view' => false,
));
$events_title = elgg_view('output/url', array(
	'text' => elgg_echo('events'),
	'href' => 'events/owner/'.$dine->username,
));

echo "<div class=\"elgg-places-right\">";

echo "<div class=\"elgg-places-profile\">";
echo "<h2>" . $offers_title . "</h3>";
echo $offers;
echo "</div>";

echo "<div class=\"elgg-places-profile\">";
echo "<h2>" . $events_title . "</h3>";
echo $events;
echo "</div>";

echo "</div>";

