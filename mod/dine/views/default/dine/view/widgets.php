<?php
/**
* Stores category widgets/tools
* 
* @package ElggGroups
*/ 
	
// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';

// enable tools to extend this area
echo elgg_view("stores/category/tool_latest", $vars);

echo "</ul>";

