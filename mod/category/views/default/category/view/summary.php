<?php
/**
 * Group profile summary
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('category:notfound');
	return true;
}

$category = $vars['entity'];
echo $category->scope;
$featured = elgg_list_entities_from_metadata(array(
	'metadata_name' => 'featured',
	'metadata_value' => 'yes',
	'type' => 'user',
	'subtype' => $category->scope,
	'limit' => 10,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
));
$members = elgg_list_entities_from_relationship(array(
	'relationship' => 'member',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'subtype' => $category->scope,
//	'limit' => $limit,
//	'list_type' => 'gallery',
//	'gallery_class' => 'elgg-gallery-users',
));
$offers = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'offer',
	'container_guid' => $category->guid,
	'limit' => 5,
	'full_view' => FALSE,
));
if (empty($offers)) {
	$offers = elgg_echo('offers:none');
}
$events = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'event',
	'container_guid' => $category->guid,
	'limit' => 5,
	'full_view' => FALSE,
));
if (empty($events)) {
	$events = elgg_echo('events:none');
}

?>
<div class="groups-profile clearfix elgg-image-block">
	<div class="categories-left">
		<div class="categories-widget">
			<h5><?php echo elgg_echo("{$category->scope}:featured"); ?> </h5>
			<div class="categories-widget-content">
				<?php echo $featured; ?>
			</div>
		</div>
		<div>
			<h2><?php echo elgg_echo("$category->scope"); ?> </h2>
				<?php echo $members; ?>
		</div>
	</div>

	<div class="categories-right">
		<div>
			<h2><?php echo elgg_echo("offers:latest"); ?> </h2>
			<?php echo $offers; ?>
		</div>

		<div>
			<h2><?php echo elgg_echo("events:latest"); ?> </h2>
			<?php echo $events; ?>
		</div>
	</div>
</div>
<?php
?>

