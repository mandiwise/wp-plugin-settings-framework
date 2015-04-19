<!--
 * INSTRUCTIONS:
 *
 * Find and replace "PLUGIN NAME" with your the name of your plugin
 * Find and replace "PREFIX" with the prefix you used in class-plugin-settings.php
 *
-->

<div class="wrap">
	<h2><?php _e( 'PLUGIN NAME Settings', $this->domain ) ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'PREFIX_options' ); ?>
			<?php do_settings_sections( 'PREFIX-options' ); ?>
			<p class="submit">
            	<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', $this->domain ) ?>" />
            </p>
		</form>
</div>
