<?php 
	$showLeftSide = $leftSide = $responsive= $deskview = ''; $sticky = ' no-sticky';
	$right = 'right'; $left = 'left';
	if ( $GLOBALS['sidebar_layout'] == 'left' || $GLOBALS['sidebar_layout'] == 'double' ){
		$showLeftSide = true;
	}
	if(rd_options('abomb_responsive')==1 && $showLeftSide == false){
		$leftSide = ' leftLogo';
	}
	else if(rd_options('abomb_responsive')==1 && $showLeftSide == true){
		$leftSide = ' noleftLogo';
	}
	
	if(rd_options('abomb_responsive')==1){
		$responsive = 'nav-res';
		$deskview = ' deskview';
	}
	else{
		$responsive = 'nav-nores';
	}
	if (is_rtl()){$left = 'right'; $right = 'left';}
	
	if ((rd_options('abomb_header1_sticky') == 1 && $GLOBALS['header_style'] == 'header1') || (rd_options('abomb_header2_sticky') == 1 && $GLOBALS['header_style'] == 'header2') || (rd_options('abomb_header3_sticky') == 1 && $GLOBALS['header_style'] == 'header3')) {
		$sticky = ' show-sticky';
	}
	$uploads = wp_upload_dir();
	$logopath = $uploads['baseurl'].'/2015/06/map-logo.png';
	 
?>			
				<div class="main-header header-one<?php echo $sticky; ?>">
					<div class="row clearfix">
						<div class="main-row clearfix">
							<div class="logo<?php echo $leftSide; ?> el-left">
								<img class="logo-img" src="<?php echo $logopath; ?>" alt="Mongabay Enviromental News" width="143" height="46" data-logoretina="<?php echo $logopath; ?>">
							</div>
							<?php if(rd_options_array('abomb_menu_element','search')): ?>
								<div class="menu-reg-log menu-search righttog deskview">
									<i class="fa fa-search"></i>
								</div>
								<div class="menu-form">
									<div class="search-box el-left">
										<form class="el-left" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
											<input type="text" name="s" id="s" value="<?php _e('Typing Here and Press Enter ...','abomb'); ?>" placeholder="<?php _e('Typing Here and Press Enter ...','abomb'); ?>" />
											<i class="fa fa-close close-search"></i>
										</form>	      
									</div>
								</div>
							<?php endif; ?>
							<?php if(rd_options_array('abomb_menu_element','login') || rd_options_array('abomb_menu_element','register') || rd_options_array('abomb_menu_element','subscribe')): ?>
								<div class="menu-reg-log righttog deskview">
									<?php get_template_part('parts/header-reg'); ?>
								</div>
							<?php endif; ?>
							<nav role="navigation" class="main-menu<?php echo $deskview; ?> el-right" itemscope="itemscope" itemtype="<?php echo rd_ssl(); ?>://schema.org/SiteNavigationElement">
								<?php if ( has_nav_menu( 'main_menu' ) ): ?>
									<?php 
										$arg = array(
											'container' =>false, 
											'theme_location' => 'main_menu', 
											'menu_id' => 'mainnav',
											'menu_class' => 'bombnav '.$responsive,
											'walker' => new rd_mega_walker()
										);
										wp_nav_menu( $arg );
									?>
								<?php else: ?>
									<?php
									echo '<div class="no-menu"><a href="' . esc_url(admin_url('nav-menus.php?action=locations')).'">'.__('Click here - to select or create a menu','abomb').'</a></div>';
									?>
								<?php endif; ?>
							</nav>
							<?php if($leftSide == ' noleftLogo'): ?>
								<div class="sb-toggle sb-toggle-<?php echo $left; ?> lefttog mobview"><i class="fa fa-ellipsis-h"></i></div>
							<?php endif; ?>
							<?php if($responsive == 'nav-res'): ?>
								<div class="sb-toggle sb-toggle-<?php echo $right; ?> righttog mobview"><i class="fa fa-bars el-left"></i><span class="togtext deskview el-right"><?php _e('Menu','abomb')?></span></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			