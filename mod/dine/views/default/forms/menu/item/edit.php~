<?php
/**
 * Category edit form
 * 
 * @package ElggCategorys
 */

if (elgg_is_sticky_form('menu:item')) {
	extract(elgg_get_sticky_values('menu:item'));
	elgg_clear_sticky_form('menu:item');
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
		'value' => $vars['item']->title,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("description"); ?></label><br />
	<?php echo elgg_view("input/plaintext", array(
		'name' => 'description',
		'value' => $vars['item']->description,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("price"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'price',
		'value' => $vars['item']->price,
	));
	?>
</div>
<div>
<?php

if (isset($vars['item'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'item_guid',
		'value' => $vars['item']->getGUID(),
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
