<?php
/**
 * Elgg add/edit event form.
 *
 * @package ElggStores
 * 
 */

$title = $description = '';
$host_guid = get_input('host');

if (elgg_is_sticky_form('event')) {
	extract(elgg_get_sticky_values('event'));
	elgg_clear_sticky_form('event');
}
?>
<div>
	<label><?php echo elgg_echo("events:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo('title');?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'title',
		'value' => $vars['entity']->title,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('description');?></label><br />
	<?php
	echo elgg_view('input/plaintext', array(
		'name' => 'description',
		'value' => $vars['entity']->description,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('events:start');?></label><br />
	<?php
	echo elgg_view('input/date', array(
		'name' => 'start',
		'value' => $vars['entity']->start,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('events:end');?></label><br />
	<?php
	echo elgg_view('input/date', array(
		'name' => 'end',
		'value' => $vars['entity']->end,
	));
	?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/hidden', array('name' => 'event_guid', 'value' => $vars['entity']->guid)); ?>
	<?php echo elgg_view('input/hidden', array('name' => 'host_guid', 'value' => $host_guid)); ?>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('submit'))); ?>
</div>

