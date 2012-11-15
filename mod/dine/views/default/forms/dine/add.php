<?php
/**
 * Elgg add store form.
 *
 * @package ElggStores
 * 
 */

$name = $username = $email = $password = $password2 = $admin = '';

$category_guid = elgg_extract('category_guid', $vars, null);
$category = get_entity($category_guid);

if (elgg_is_sticky_form('useradd')) {
	extract(elgg_get_sticky_values('useradd'));
	elgg_clear_sticky_form('useradd');
	if (is_array($admin)) {
		$admin = $admin[0];
	}
}

?>
<div>
	<label><?php echo elgg_echo('category');?></label><br />
	<?php
	echo elgg_view_entity($category, array('full_view' => false, 'icon_size'=> 'tiny'));
	echo elgg_view('input/hidden', array(
		'name' => 'category_guid',
		'value' => $category->getGUID(),
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('name');?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'name',
		'value' => $name,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('username'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'username',
		'value' => $username,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('email'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'email',
		'value' => $email,
	));
	?>
</div>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('register'))); ?>
</div>
