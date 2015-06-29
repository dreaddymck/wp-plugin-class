<?php ?>

<div class="loading" style="text-align: center; width: 100%;">
	<img src="<?php echo plugins_url( 'images/loading-nerd.gif', __FILE__ )?>" /></div>

<form method="post" action="options.php">
<?php settings_fields( $this->plugin_settings_group ); ?>
<?php do_settings_sections( $this->plugin_settings_group ); ?>
	
<div class="container" style="display:none;">

	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">settings</li>
		<li class="tab-link" data-tab="tab-2">license</li>
		<li class="tab-link" data-tab="tab-3">readme</li>
	</ul>

	<div id="tab-1" class="tab-content current">

		<?php submit_button(); ?>
		
		<div>	
			<label><?php _e('favicon href'); ?>:<label>	        
	        <textarea  name="favicon"><?php echo esc_attr( get_option('favicon') ); ?></textarea>
		</div>
          
		<?php submit_button(); ?>
		
	</div>
	<div id="tab-2" class="tab-content"></div>
	<div id="tab-3" class="tab-content"></div>

</div><!-- container -->	

</form>