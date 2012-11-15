<?php
/**
 * Edit/create a category wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);
$scope = elgg_extract('scope', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array(
	'entity' => $entity,
	'scope' => $scope
);
echo elgg_view_form('category/edit', $form_vars, $body_vars);
