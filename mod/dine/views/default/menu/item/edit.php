<?php
/**
 * Edit/add a dining menu category wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$category = elgg_extract('category', $vars, null);
$item = elgg_extract('item', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array(
	'category' => $category,
	'item' => $item,
);
echo elgg_view_form('menu/item/edit', $form_vars, $body_vars);
