<?php
/**
 * Edit/add a dining menu category wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);
$category = elgg_extract('category', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array(
	'entity' => $entity,
	'category' => $category,
);
echo elgg_view_form('menu/categories/edit', $form_vars, $body_vars);
