<?php
use UdyWfToWp\i18n\i18n;
?>
<div class="wrap">
	<div class="wrap cdg-woo-kit-custom-meta-box" id="udesly_contentmanager_settings">
	<h1><?php _e('Settings', i18n::$textdomain); ?></h1>
	<form method="post" action="">
		<?php
		$tabs->show_tabs();
		?>
		<?php submit_button( __('Save', i18n::$textdomain) ); ?>
	</form>
</div>
