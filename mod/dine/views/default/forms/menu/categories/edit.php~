<?php
/**
 * Category edit form
 * 
 * @package ElggCategorys
 */

if (elgg_is_sticky_form('menu:categories')) {
	extract(elgg_get_sticky_values('menu:categories'));
	elgg_clear_sticky_form('menu:categories');
}
?>
<div>
	<label><?php echo elgg_echo("icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo("title"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'title',
		'value' => $vars['category']->title,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("description"); ?></label><br />
	<?php echo elgg_view("input/plaintext", array(
		'name' => 'description',
		'value' => $vars['category']->description,
	));
	?>
</div>
<div>
<?php

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'entity_guid',
		'value' => $vars['entity']->getGUID(),
	));
}
if (isset($vars['category'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'category_guid',
		'value' => $vars['category']->getGUID(),
	));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

?>
</div>
