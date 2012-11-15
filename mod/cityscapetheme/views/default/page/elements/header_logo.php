<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_url = elgg_get_site_url();
?>

<div class="elgg-menu-site-logo">
	<a class="elgg-heading-site" href="<?php echo $site_url; ?>">
		<img src="<?php echo $site_url; ?>/mod/cityscapetheme/graphics/logo/logo.png" />
	</a>
</div>

