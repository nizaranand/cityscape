<?php
/**
 * Elgg stores category edit action.
 *
 * @package ElggGroups
 */

$input['title'] = get_input('title');
$input['title'] = html_entity_decode($input['title'], ENT_COMPAT, 'UTF-8');
$input['description'] = get_input('description');
$input['description'] = html_entity_decode($input['description'], ENT_COMPAT, 'UTF-8');

$user = elgg_get_logged_in_user_entity();

$scope = get_input('scope');
$category_guid = (int)get_input('category_guid');
$new_category_flag = $category_guid == 0;

$category = new ElggGroup($category_guid); // load if present, if not create a new category
if (($category_guid) && (!$category->canEdit())) {
	register_error(elgg_echo("categorys:cantedit"));

	forward(REFERER);
}
$category->subtype = 'category';
$category->scope = $scope;

// Assume we can edit or this is a new category
if (sizeof($input) > 0) {
	foreach($input as $shortname => $value) {
		$category->$shortname = $value;
	}
}

// Validate create
if (!$category->title) {
	register_error(elgg_echo("categorys:notitle"));

	forward(REFERER);
}
if (!$category->scope) {
	register_error(elgg_echo("categorys:noscope"));

	forward(REFERER);
}

$category->membership = ACCESS_PRIVATE;
$category->access_id = ACCESS_PUBLIC;

$category->save();

// category creator needs to be member of new category and river entry created
if ($new_category_flag) {
	elgg_set_page_owner_guid($category->guid);
}

// Now see if we have a file icon
if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {

	$icon_sizes = elgg_get_config('icon_sizes');

	$prefix = "categorys/" . $category->guid;

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $category->owner_guid;
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();

	$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['tiny']['w'], $icon_sizes['tiny']['h'], $icon_sizes['tiny']['square']);
	$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['small']['w'], $icon_sizes['small']['h'], $icon_sizes['small']['square']);
	$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), '', 90, FALSE);
	$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), $icon_sizes['large']['w'], $icon_sizes['large']['h'], $icon_sizes['large']['square']);

	if ($thumbtiny) {

		$thumb = new ElggFile();
		$thumb->owner_guid = $category->owner_guid;
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

		$category->icontime = time();
	}
}

system_message(elgg_echo("st0res:category:saved"));

forward($category->getUrl());
