<?php
/**
 * Category edit form
 * 
 * @package ElggCategorys
 */

$scope = get_input('scope');
?>
<div>
	<label><?php echo elgg_echo("category:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>
<div>
	<label><?php echo elgg_echo("title"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		'name' => 'title',
		'value' => $vars['entity']->title,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("description"); ?></label><br />
	<?php echo elgg_view("input/plaintext", array(
		'name' => 'description',
		'value' => $vars['entity']->description,
	));
	?>
</div>

<?php

if (isset($vars['entity'])) {
	echo elgg_view('input/hidden', array(
		'name' => 'category_guid',
		'value' => $vars['entity']->getGUID(),
	));
} else {
	echo elgg_view('input/hidden', array(
		'name' => 'scope',
		'value' => $scope,
	));
}

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

if (isset($vars['entity'])) {
	$delete_url = 'action/category/delete?guid=' . $vars['entity']->getGUID();
	echo elgg_view('output/confirmlink', array(
		'text' => elgg_echo('category:delete'),
		'href' => $delete_url,
		'confirm' => elgg_echo('category:deletewarning'),
		'class' => 'elgg-button elgg-button-delete float-alt',
	));
}
?>
</div>
