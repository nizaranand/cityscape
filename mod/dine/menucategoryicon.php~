<?php
/**
 * Icon display
 *
 * @package ElggVooks
 */

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$category_guid = get_input('category_guid');
$category = get_entity($category_guid);

// If is the same ETag, content didn't changed.
$etag = $category->icontime . $category_guid;
if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
	header("HTTP/1.1 304 Not Modified");
	exit;
}

$size = strtolower(get_input('size'));
if (!in_array($size, array('large', 'medium', 'small', 'tiny', 'master', 'topbar')))
	$size = "medium";

$success = false;

$filehandler = new ElggFile();
$filehandler->owner_guid = $category->owner_guid;
$filehandler->setFilename("menu/categories/" . $category->guid . $size . ".jpg");

$success = false;
if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->size())) {
		$success = true;
	}
}

if (!$success) {
	$location = elgg_get_plugins_path() . "categories/graphics/default{$size}.jpg";
	$contents = @file_get_contents($location);
}

header("Content-type: image/jpeg");
header('Expires: ' . date('r',time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));
header("ETag: $etag");
echo $contents;
