							</main>
							<?php 
								get_sidebar( 'stat-right' );
							?>
						</div>
                      <?php if (is_single() && !is_page()) : if (have_posts()) : while (have_posts()) : the_post(); comments_template();  endwhile; endif; endif; ?>
			
					</div>
				</div>
			</div>
			<div class="footer-wrap <?php echo $GLOBALS['theme_ver'];?> clearfix">
			<footer role="contentinfo" class="main-grid dark grid-12" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/WPFooter">
           	<div class="footer-left grid-3">
            		<?php get_template_part('parts/social'); ?>
                  <div id="footer-logo"></div>
                  <div id="copyright"><?php _e('Copyright © 2015 Mongabay.com') ?></div>
            	</div>
            	<div class="footer-right grid-9">
                	<div class="footer-top">
						<?php
                            $arg = array(
                                'container' =>false, 
                                'theme_location' => 'footer_menu', 
                                'menu_id' => 'footnav',
                                'menu_class' => 'footnav',
                                'depth' => 1,
                                'walker' => new rd_mega_walker()
                            );
                            wp_nav_menu( $arg ); 
                        ?>
                       
                     </div>
                     <div class="footer-static-menus">
                     		<div class="menu-information-wrap">
                         		<h4><?php _e('Information'); ?></h4>
                     			<?php wp_nav_menu( array( 'theme_location' => 'footer-left-menu' )); ?>
                         </div>
                         <div class="menu-other-wrap">
                         		<h4><?php _e('Other Mongabay Sites'); ?></h4>
                     			<?php wp_nav_menu( array( 'theme_location' => 'footer-right-menu' )); ?>
                         </div>
                     </div>
                  </div>
					
           </footer>
			</div>
		</div>
      </div>
	<div class="toTop"><i class="fa fa-angle-up"></i></div>
	<?php 
		if(rd_options_array('abomb_menu_element','login') || rd_options_array('abomb_menu_element','register')) {
				get_template_part('parts/form-login-reg'); 
		}
		if(rd_options_array('abomb_menu_element','subscribe') && rd_options('abomb_header_subscribe_opt')=='mailchimp' && rd_options('abomb_header_mailchimp_api') && rd_options('abomb_header_mailchimp_list')) {
			get_template_part('parts/form-mailchimp'); 
		}
	?>
<?php wp_footer(); ?>

   

</body>
</html>