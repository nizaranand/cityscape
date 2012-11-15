<?php
/**
 * Elgg stores category edit action.
 *
 * @package ElggGroups
 */

elgg_make_sticky_form('menu:item');

$input['title'] = get_input('title');
$input['title'] = html_entity_decode($input['title'], ENT_COMPAT, 'UTF-8');
$input['description'] = get_input('description');
$input['description'] = html_entity_decode($input['description'], ENT_COMPAT, 'UTF-8');
$input['price'] = get_input('price');
$input['price'] = html_entity_decode($input['price'], ENT_COMPAT, 'UTF-8');

$item_guid = (int)get_input('item_guid');
$item = get_entity($item_guid);
$category_guid = (int)get_input('category_guid');
$category = get_entity($category_guid);
$new_category_flag = $category_guid == 0;

$item = new ElggObject($item_guid); // load if present, if not create a new category
if (($item_guid) && (!$item->canEdit())) {
	register_error(elgg_echo("menu:item:cantedit"));

	forward(REFERER);
}
$item->subtype = 'diningmenuitem';

// Assume we can edit or this is a new item
if (sizeof($input) > 0) {
	foreach($input as $shortname => $value) {
		$item->$shortname = $value;
	}
}

// Validate create
if (!$item->title) {
	register_error(elgg_echo("menu:item:notitle"));

	forward(REFERER);
}
if (!is_numeric($item->price)) {
	register_error(elgg_echo("menu:item:pricenotnumber"));

	forward(REFERER);
}

$item->owner_guid = $category_guid;
$item->access_id = ACCESS_PUBLIC;

$item->save();

// Now see if we have a file icon
if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {

	$icon_sizes = elgg_get_config('icon_sizes');

	$prefix = "menu/item/" . $item->guid;

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $item->owner_guid;
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();

	$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['tiny']['w'], $icon_sizes['tiny']['h'], $icon_sizes['tiny']['square']);
	$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['small']['w'], $icon_sizes['small']['h'], $icon_sizes['small']['square']);
	$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['medium']['w'], $icon_sizes['medium']['h'], FALSE);
	$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), '', $icon_sizes['large']['h'], $icon_sizes['large']['square']);
	if ($thumbtiny) {

		$thumb = new ElggFile();
		$thumb->owner_guid = $item->owner_guid;
		$thumb->setMimeType('image/jpeg');

		$thumb->setFilename($prefix."tiny.jpg");
		$thumb->open("write");
		$thumb->write($thumbtiny);
		$thumb->close();

		$thumb->setFilename($prefix."small.jpg");
		$thumb->open("write");
		$thumb->write($thumbsmall);
		$thumb->close();

		$thumb->setFilename($prefix."medium.jpg");
		$thumb->open("write");
		$thumb->write($thumbmedium);
		$thumb->close();

		$thumb->setFilename($prefix."large.jpg");
		$thumb->open("write");
		$thumb->write($thumblarge);
		$thumb->close();

		$item->icontime = time();
	}
}

// category creator needs to be member of new category and river entry created
if ($new_item_flag) {
	elgg_set_page_owner_guid($category->guid);
}

system_message(elgg_echo("menu:item:saved"));

$dine = $category->getOwnerEntity();
forward('menu/view/'.$dine->username);
