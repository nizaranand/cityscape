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
$featured_stores = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
	'types' => 'user',
//	'limit' => $limit,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));
$stores = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
	'types' => 'user',
//	'limit' => $limit,
//	'list_type' => 'gallery',
//	'gallery_class' => 'elgg-gallery-users',
));
$offers = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'offer',
	'limit' => 5,
	'full_view' => FALSE,
));
$events = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'event',
	'limit' => 5,
	'full_view' => FALSE,
));

?>
<div class="groups-profile clearfix elgg-image-block">
	<div class="categories-left">
		<div class="categories-widget">
			<?php echo elgg_view_entity_icon($dine, 'large', array('href' => '')); ?>
		</div>
		<div>
			<h2><?php echo elgg_echo("stores:stores"); ?> </h2>
				<?php echo $stores; ?>
		</div>
	</div>

	<div class="categories-right">
		<h2><?php echo elgg_echo("offers:latest"); ?> </h2>
		<?php echo $offers; ?>

		<h2><?php echo elgg_echo("events:latest"); ?> </h2>
		<?php echo $events; ?>
	</div>
</div>
<?php
?>

