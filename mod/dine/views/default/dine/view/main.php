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

$activity = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => array('event', 'offer'),
	'owner_guid' => $dine->guid,
	'full_view' => FALSE,
));
if (empty($activity)) {
	$activity = '<p>'.elgg_echo('river:none').'</p>';
}

?>
<div class="categories-right">
	<h2><?php echo elgg_echo("content:latest"); ?> </h2>
	<?php echo $activity; ?>
</div>

