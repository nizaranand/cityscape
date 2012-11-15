<?php
/**
 * Elgg Search css
 * 
 */
?>

/**********************************
Search plugin
***********************************/
.elgg-search fieldset {
	background: transparent;
	padding: 0;
}
.elgg-search-header {
	bottom: 15px;
	height: 23px;
	position: absolute;
	right: 0;
}
.elgg-search input[type=text] {
	width: 230px;
}
.elgg-search input[type=submit] {
	display: none;
}
.elgg-search input[type=text] {
//	border: 1px solid #71b9f7;
	font-size: 12px;
	padding: 3px 4px 3px 26px;
	background: white url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat 6px -916px;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active {
	background-color: white;
	background-position: 6px -916px;
	color: #0054A7;
}

.search-list li {
	padding: 5px 0 0;
}
.search-heading-category {
	margin-top: 20px;
	color: #666666;
}

.search-highlight {
	background-color: #bbdaf7;
}
.search-highlight-color1 {
	background-color: #bbdaf7;
}
.search-highlight-color2 {
	background-color: #A0FFFF;
}
.search-highlight-color3 {
	background-color: #FDFFC3;
}
.search-highlight-color4 {
	background-color: #ccc;
}
.search-highlight-color5 {
	background-color: #4690d6;
}
