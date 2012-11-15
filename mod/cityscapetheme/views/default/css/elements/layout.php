<?php
/**
 * Page Layout
 *
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */
?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
body {
	background: #888;
}
.elgg-page-default {
	min-width: 998px;
	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#888), to(#bbb));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #bbb, #888);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #bbb, #888);
	/* IE 10 */
	background: -ms-linear-gradient(top, #bbb, #888);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #bbb, #888);
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 990px;
	margin: 0 auto;
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	width: 990px;
	margin: 0 auto;
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	padding: 5px 0;
}

/***** TOPBAR ******/
.elgg-page-topbar {
//	background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	background: #aaa;

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#999), to(#777));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #777, #999);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #777, #999);
	/* IE 10 */
	background: -ms-linear-gradient(top, #777, #999);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #777, #999);

	position: relative;
	height: 24px;
	z-index: 9000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 24px;
	right: 20px;
	max-width: 500px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
	position: relative;
	top: 1px;
	background: #fff;

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f01d25), to(#e71c23));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #e71c23, #f01d25);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #e71c23, #f01d25);
	/* IE 10 */
	background: -ms-linear-gradient(top, #e71c23, #f01d25);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #e71c23, #f01d25);

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f01d25), to(#c0151b));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #c0151b, #f01d25);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #c0151b, #f01d25);
	/* IE 10 */
	background: -ms-linear-gradient(top, #c0151b, #f01d25);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #c0151b, #f01d25);

//	border: 1px solid #f01d25;
	border-bottom: 1px solid #fff;
}
.elgg-page-header > .elgg-inner {
	position: relative;
}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
	background: white; //url(<?php echo elgg_get_site_url(); ?>_graphics/sidebar_background.gif) repeat-y right top;

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#fff), to(#eee));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #eee, #fff);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #eee, #fff);
	/* IE 10 */
	background: -ms-linear-gradient(top, #eee, #fff);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #eee, #fff);
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}
.elgg-layout-error {
	margin-top: 20px;
}
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	width: 210px;
	margin: 0 0 0 10px;
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
}
.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 20px;

	/* Safari 4-5, Chrome 1-9 */
	background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#fff), to(#eee));
	/* Safari 5.1, Chrome 10+ */
	background: -webkit-linear-gradient(top, #eee, #fff);
	/* Firefox 3.6+ */
	background: -moz-linear-gradient(top, #eee, #fff);
	/* IE 10 */
	background: -ms-linear-gradient(top, #eee, #fff);
	/* Opera 11.10+ */
	background: -o-linear-gradient(top, #eee, #fff);
}
.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	position: relative;
}
.elgg-page-footer {
	background: #888;
	color: #fff;
}
.elgg-page-footer a:hover {
	color: #fff;
}
