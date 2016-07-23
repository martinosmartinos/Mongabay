<?php
	$sidewoo='';
	if ( is_woocommerce()){
		$sidewoo = ' woo-sidebar';
	}
?>
<?php if (!is_page_template( 'templates/template-weather.php' )): ?>
	<aside role="complementary" class="main-grid right-sidebar sidebar<?php echo $sidewoo; ?>" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WPSideBar">
		<?php
			$sidebar_right = rd_field( 'abomb_right_sidebar');
			$sidebar_cat_right = rd_field( 'abomb_cat_right_sidebar', 'category_' . get_query_var('cat'));
			if (is_page_template ( 'templates/template-simple.php' )) {
				dynamic_sidebar('custom-simplepagesidebar');
			}
			elseif (mongabay_sub()=='images') {
				dynamic_sidebar('custom-imagesrightsidebar');
			} 
			elseif (is_category()){
				if (rd_field( 'abomb_override_sidebar_cat', 'category_' . get_query_var('cat'))=='yes' && $sidebar_cat_right!='0' && !empty($sidebar_cat_right)){
					dynamic_sidebar($sidebar_cat_right); 
				}
				else {
					dynamic_sidebar( 'right-sidebar' );
				}
			}
			else {
				if (rd_field( 'abomb_override_sidebar')=='yes' && $sidebar_right!='0' && !empty($sidebar_right)){
					dynamic_sidebar($sidebar_right); 
				}
				else{
					if ( is_single() && !is_woocommerce()){
						if (is_active_sidebar( 'single-right-sidebar' )) {
							echo '<div class="licence-widget-left"><span>'.__('Published under').'</span><b>'.__('Creative Commons BY-NC-ND').'</b></div><div class="license-widget-right" style="background-image: url(\'/wp-content/themes/mongabay/img/license_cc.jpg\')"></div>';
							dynamic_sidebar( 'single-right-sidebar' );
						}
						else {
							dynamic_sidebar( 'right-sidebar' );
						}	
					}
					else if (is_woocommerce()) {
						if (is_active_sidebar( 'woo-right-sidebar' )) {
							dynamic_sidebar( 'woo-right-sidebar' );
						}
						else {
							dynamic_sidebar( 'right-sidebar' );
						}	
					}
					else {
						dynamic_sidebar( 'right-sidebar' );
					}
				}
			}
		?>
	</aside>
<?php endif;?>