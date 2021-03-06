<?php
/**
 * Layout of the dine view page
 *
 * @uses $vars['entity']
 */

$context = $vars['page_context'];

$profile_fields = elgg_get_config('profile_fields');

$dine = $vars['entity'];
$icon = elgg_view_entity_icon($dine, 'medium');
$list_body = "<h2>" . $dine->name . "</h2>";

if (is_array($profile_fields) && sizeof($profile_fields) > 0) {
	foreach ($profile_fields as $shortname => $valtype) {
		$value = $dine->$shortname;
		if (!empty($value)) {
			$list_body .= "<br /><b>" . elgg_echo("profile:{$shortname}") . ": </b>";
			$list_body .= elgg_view("output/{$valtype}", array('value' => $dine->$shortname));
		}
	}
}

echo elgg_view_menu('title');
echo "<div class=\"elgg-places-profile\">";

echo elgg_view_image_block($icon, $list_body);

echo "</div>";

echo elgg_view('dine/view/left', $vars);
echo elgg_view('dine/view/right', $vars);

