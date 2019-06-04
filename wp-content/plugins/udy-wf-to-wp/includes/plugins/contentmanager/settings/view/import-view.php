<?php
use UdyWfToWp\i18n\i18n;

if (isset($_GET['clean-fe-transients']) && 'true' == $_GET['clean-fe-transients']) {
    \UdyWfToWp\Utils\Utils::delete_fe_transients();
}
?>
<div class="wrap">
	<div class="wrap cdg-woo-kit-custom-meta-box" id="udesly_contentmanager_settings">
	<h1><?php _e('Import from Webflow', i18n::$textdomain); ?></h1>
	<form method="post" action="">
		<?php
		$tabs->show_tabs();
		?>
	</form>
</div>
