<?php
/**
 * Edit a dining place wrapper
 *
 * @uses $vars['entity'] ElggObject object
 */

$entity = elgg_extract('category_guid', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array('category_guid' => $entity);
echo elgg_view_form('dine/edit', $form_vars, $body_vars);

