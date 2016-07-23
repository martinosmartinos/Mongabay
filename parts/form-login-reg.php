		<div id="login-modal" class="modalhide">
			<div class="form">
			    <div class="header">
					<h4><?php _e('Sign In','abomb'); ?></h4>		
				</div>
              <div class="sociallogin">
              		<div class="sociallogin-text sociallogin-text-pre"><?php _e('Connect with','mongabay-theme'); ?></div>
              		<?php do_action( 'wordpress_social_login' ); ?>
                  <div class="sociallogin-text sociallogin-text-post"><?php _e('Or','mongabay-theme'); ?></div>
              </div>
				<div class="section">
				    <form action="<?php echo rd_login_current_url(); ?>" method="post" class="rd_form" id="rd_login_form">
						<div class="rd_form_inner">
							<?php
								global $rd_login_errors;
								if (isset($rd_login_errors) && sizeof($rd_login_errors)>0 && $rd_login_errors->get_error_code()) :
									echo '<ul class="errors">';
									foreach ($rd_login_errors->errors as $error) {
										echo '<li>'.$error[0].'</li>';
										break;
									}
									echo '</ul>';
								endif; 
							?>
							<div class="input-group focus">
								<label for="rd_email"><i class="fa fa-user"></i></label>
								<input type="text" name="log" id="rd_email" placeholder="<?php _e('Your E-mail','abomb'); ?>">					
							</div>
							<div class="input-group focus">
								<label for="rd_password"><i class="fa fa-key"></i></label>
								<input type="password" name="pwd" id="rd_password" placeholder="<?php _e('Enter your Password','abomb'); ?>">				
							</div>
							
							<div class="buttons half-right el-right">
								<button type="submit" class="button button-login el-right"><?php _e('Sign In','abomb'); ?></button>
								<input name="rd_login" type="hidden" value="true"  />
							</div>
							<div class="checkbox half-left el-left">
								<input type="checkbox" name="rememberme" >
								<label><span></span><?php _e('Keep me Logged in','abomb'); ?></label>
							</div>
						</div>
					</form>
				</div>	
				<div class="footer">
					<?php //if(rd_options_array('abomb_menu_element','register')): ?>
						<?php if (get_option('users_can_register')) : ?>
							<a class="showbox" href="#register-modal" rel="modal:open"><?php _e('Do not have an Account yet','abomb'); ?> </a>
						<?php endif; ?>
					<?php // endif; ?>
					<a class="showbox" href="#lost-password-modal" rel="modal:open"><?php _e('Forgot your Password','abomb'); ?></a>
				</div>
			</div>
		</div>
		<?php //if(rd_options_array('abomb_menu_element','register')): ?>
			<?php if (get_option('users_can_register')) : ?>
				<!-- Register Form -->
				<div id="register-modal" class="modalhide">
					<div class="form"> 
						<div class="header">
							<h4><?php _e('Register','abomb'); ?></h4>		
						</div>
                     <div class="sociallogin">
              				<div class="sociallogin-text sociallogin-text-pre"><?php _e('Connect with','mongabay-theme'); ?></div>
              				<?php do_action( 'wordpress_social_login' ); ?>
                  		<div class="sociallogin-text sociallogin-text-post"><?php _e('Or','mongabay-theme'); ?></div>
              			</div>
						<div class="section">
							<form action="<?php echo rd_login_current_url(); ?>" method="post" class="rd_form zerospam" id="rd_register_form">
								<div class="rd_form_inner">
									<?php
										global $rd_reg_errors;
										if (isset($rd_reg_errors) && sizeof($rd_reg_errors)>0 && $rd_reg_errors->get_error_code()) :
											echo '<ul class="errors">';
											foreach ($rd_reg_errors->errors as $error) {
												echo '<li>'.$error[0].'</li>';
												break;
											}
											echo '</ul>';
										endif; 
									?>
									<div class="input-group focus">
										<label for="rd_reg_username"><i class="fa fa-user"></i></label>
										<input type="text" name="username" id="rd_reg_username" placeholder="<?php _e('Username','abomb'); ?>">					
									</div>
									<div class="input-group focus">
										<label for="rd_reg_email"><i class="fa fa-envelope"></i></label>
										<input type="text" name="email" id="rd_reg_email" placeholder="<?php _e('Email Address','abomb'); ?>">					
									</div>
									<div class="input-group focus">
										<label for="rd_reg_password"><i class="fa fa-key"></i></label>
										<input type="password" name="password" id="rd_reg_password" placeholder="<?php _e('Enter Password','abomb'); ?>">				
									</div>
									<div class="input-group focus">
										<label for="rd_reg_password_2"><i class="fa fa-key"></i></label>
										<input type="password" name="password2" id="rd_reg_password_2" placeholder="<?php _e('Repeat Password','abomb'); ?>">				
									</div>
									<div class="buttons">
										<button type="submit" class="button button-login el-right"><?php _e('Register','abomb'); ?></button>
										<input name="rd_register" type="hidden" value="true"  />
									</div>
									
								</div>
							</form>
						</div>	
						<div class="footer">
							<a class="showbox" href="#login-modal" rel="modal:open"><?php _e('Already have an Account','abomb'); ?> </a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php //endif; ?>
		<div id="lost-password-modal" class="modalhide">
			<div class="form">
			    <div class="header">
					<h4><?php _e('Reset Your Password','abomb'); ?></h4>		
				</div>
				<div class="section">
				    <form action="<?php echo rd_login_current_url(); ?>" method="post" class="rd_form" id="rd_lost_password_form">
						<div class="rd_form_inner">
							<?php
								global $rd_lost_pass_errors;
								if (isset($rd_lost_pass_errors) && sizeof($rd_lost_pass_errors)>0 && $rd_lost_pass_errors->get_error_code()) :
									echo '<ul class="errors">';
									foreach ($rd_lost_pass_errors->errors as $error) {
										echo '<li>'.$error[0].'</li>';
										break;
									}
									echo '</ul>';
								endif; 
							?>
							<div class="input-group focus">
								<label for="rd_lost_username"><i class="fa fa-user"></i></label>
								<input type="text" name="username_or_email" id="rd_lost_username" placeholder="<?php _e('Username or Email','abomb'); ?>">					
							</div>
							<div class="buttons">
								<button type="submit" class="button button-login el-right"><?php _e('Get New Password','abomb'); ?></button>
								<input name="rd_lostpass" type="hidden" value="true"  />
							</div>
							
						</div>
					</form>
				</div>	
				<div class="footer">
					<a class="showbox" href="#login-modal" rel="modal:open"><?php _e('Already have an Account','abomb'); ?> </a>
				</div>
			</div>
		</div>
	