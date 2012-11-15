<?php
/**
 * Edit/add a cover photo wrapper
 *
 * @uses $vars['entity'] ElggEntity
 *
 * @package Cityscape.Coverphoto
 */

$entity = elgg_extract('entity', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);
$body_vars = array('entity' => $entity);
echo elgg_view_form('coverphoto/upload', $form_vars, $body_vars);
echo elgg_view_form('coverphoto/crop', $form_vars, $body_vars);

