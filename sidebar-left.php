<?php
	$sidewoo='';
	if ( is_woocommerce()){
		$sidewoo = ' woo-sidebar';
	}
?>
<?php if (!is_page_template( 'templates/template-weather.php' )): ?>
	<aside role="complementary" class="main-grid left-sidebar sidebar deskview<?php echo $sidewoo; ?>" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WPSideBar">
		<?php 
			$sidebar_left = rd_field( 'abomb_left_sidebar');
			$sidebar_cat_left = rd_field( 'abomb_cat_left_sidebar', 'category_' . get_query_var('cat'));
			if (is_category()){
				if (rd_field( 'abomb_override_sidebar_cat', 'category_' . get_query_var('cat'))=='yes' && $sidebar_cat_left!='0' && !empty($sidebar_cat_left)){
					dynamic_sidebar($sidebar_cat_left); 
				}
				else {
					dynamic_sidebar( 'left-sidebar' );
				}
			}
			else {
				if (rd_field( 'abomb_override_sidebar')=='yes' && $sidebar_left!='0' && !empty($sidebar_left)){
					dynamic_sidebar($sidebar_left); 
				}
				else{
					if ( is_single() && !is_woocommerce()){
						if (is_active_sidebar( 'single-left-sidebar' )) {
							dynamic_sidebar( 'single-left-sidebar' );
						}
						else {
							dynamic_sidebar( 'left-sidebar' );
						}	
					}
					else if (is_woocommerce()) {
						if (is_active_sidebar( 'woo-left-sidebar' )) {
							dynamic_sidebar( 'woo-left-sidebar' );
						}
						else {
							dynamic_sidebar( 'left-sidebar' );
						}	
					}
					else {
						dynamic_sidebar( 'left-sidebar' );
					}
				}
			}
		?>
	</aside>
<?php endif; ?>