<!--
 *
 * Instructions:
 * Find and replace "PLUGIN NAME" with your plugin name
 * Find and replace "PREFIX" with the prefix you used in admin.php
 * You may want to delete these comments when you're done.
 * 
-->

<div class="wrap">
	<?php screen_icon(); ?>
	<h2>PLUGIN NAME Settings</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'PREFIX_options' ); ?>
			<?php do_settings_sections( 'PREFIX-options' ); ?>
			<p class="submit">
            	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
		</form>
</div>