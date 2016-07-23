<?php if(rd_options_array('abomb_menu_element','login') || rd_options_array('abomb_menu_element','register')): ?>
	<span class="header-links-logged-in">
    		<a href="<?php echo esc_url(mongabay_url('my-account')); ?>"><?php _e('My Account','abomb'); ?></a>
           <a href="<?php echo esc_url(mongabay_url('cart')); ?>"><?php _e('Cart','abomb'); ?></a>
		<?php if(rd_options_array('abomb_menu_element','login')): ?>
			<a href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><?php _e('Logout','abomb'); ?></a>
        <?php endif; ?>
	</span>
	<span class="header-links-logged-out">
		<?php if(rd_options_array('abomb_menu_element','login')): ?>
			<a class="showbox" href="#login-modal" rel="modal:open"><?php _e('Signin','abomb')?></a>
		<?php endif; ?>
		<?php if(rd_options_array('abomb_menu_element','register')): ?>
			<?php if (get_option('users_can_register')) : ?>
				<a class="showbox" href="#register-modal" rel="modal:open"><?php _e('Register','abomb')?></a>
			<?php endif; ?>
		<?php endif; ?>
	</span> 
<?php endif; ?>
<?php if(rd_options_array('abomb_menu_element','subscribe')): ?>
	<?php if(rd_options('abomb_header_subscribe_opt')=='mailchimp' && rd_options('abomb_header_mailchimp_api') && rd_options('abomb_header_mailchimp_list')): ?>
		<a class="showbox" href="#subscribe-modal" rel="modal:open"><?php _e('Subscribe','abomb')?></a>
	<?php elseif(rd_options('abomb_header_subscribe_opt')=='feedburner' && rd_options('abomb_header_feedburner')): ?>
		<a href="<?php echo rd_ssl(); ?>://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr(rd_options('abomb_header_feedburner')); ?>" target="_blank"><?php _e('Subscribe','abomb')?></a>
	<?php endif; ?>
<?php endif; ?>