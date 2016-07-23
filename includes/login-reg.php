<?php
global $wpdb;
// Detect Ajax

if (!function_exists('rd_is_ajax')) {
	function rd_is_ajax() {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
		return false;
	}
}

// Get Current URL
if (!function_exists('rd_login_current_url')) {
	function rd_login_current_url() {
		$pageURL = 'http://';
		$pageURL .= $_SERVER['HTTP_HOST'];
		$pageURL .= $_SERVER['REQUEST_URI'];
		if ( force_ssl_login() || force_ssl_admin() ) $pageURL = str_replace( 'http://', 'https://', $pageURL );
		return $pageURL;
	}
}

// Update user data upon logging in
if (!function_exists('rd_update_user_meta')) {
	function rd_update_user_meta( $user_id ) {
		update_user_meta( $user_id, 'rd_login_time', current_time('timestamp') );
		update_user_meta( $user_id, 'rd_num_comments', wp_count_comments()->approved );
		update_user_meta( $user_id, 'rd_num_posts', wp_count_posts('post')->publish );
	}
}

// Update user data upon viewing post
if (!function_exists('rd_update_user_view_meta')) {
	function rd_update_user_view_meta() {
		if (is_user_logged_in() && is_single()) :
			
			global $post;
			$user_id = get_current_user_id();
			$posts = get_user_meta( $user_id, 'rd_viewed_posts', true );
			if (!is_array($posts)) $posts = array();
			if (sizeof($posts)>4) array_shift($posts);
			if (!in_array($post->ID, $posts)) $posts[] = $post->ID;
			update_user_meta( $user_id, 'rd_viewed_posts', $posts );
			
		endif;
	}
}
add_action('wp_head', 'rd_update_user_view_meta');


// Proccess Login/Register
if (!function_exists('rd_login_process')) {
	function rd_login_process() {
		
		global $rd_login_errors, $rd_reg_errors, $rd_lost_pass_errors;
		
		if (isset($_POST['rd_login']) && $_POST['rd_login']) :
			$rd_login_errors = rd_handle_login();
		elseif ( get_option('users_can_register') && isset($_POST['rd_register']) && $_POST['rd_register'] ) :
			$rd_reg_errors = rd_handle_register();
		elseif (isset($_POST['rd_lostpass']) && $_POST['rd_lostpass']) :
			$rd_lost_pass_errors = rd_handle_lost_password();
		endif;
		
	}
}
add_action('init', 'rd_login_process');

if (!function_exists('rd_handle_login')) {
	function rd_handle_login() {
		
		if ( isset( $_REQUEST['redirect_to'] ) ) $redirect_to = $_REQUEST['redirect_to'];
		else $redirect_to = admin_url();
			
		if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) ) $secure_cookie = false;
		else $secure_cookie = '';

		$user = wp_signon('', $secure_cookie);
		
		// Check the username
		if ( !$_POST['log'] ) :
			$user = new WP_Error();
			$user->add('empty_username', __('<strong>ERROR</strong>: Please enter a username.', 'abomb'));
		elseif ( !$_POST['pwd'] ) :
			$user = new WP_Error();
			$user->add('empty_username', __('<strong>ERROR</strong>: Please enter your password.', 'abomb'));
		endif;

		$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);
		
		$redirect_to = apply_filters('rd_login_redirect', $redirect_to );
		
		if ( !is_wp_error($user) ) rd_update_user_meta( $user->ID );
		
		if (rd_is_ajax()) :
			if ( !is_wp_error($user) ) :
				echo 'SUCCESS';
			else :
				foreach ($user->errors as $error) {
					echo $error[0];
					break;
				}
			endif;
			exit;
		else :
			if ( !is_wp_error($user) ) :
				wp_redirect($redirect_to);
				exit;
			endif;
		endif;
		return $user;
	}
}

if (!function_exists('rd_handle_register')) {
	function rd_handle_register() {
		
		$posted = array();
		$errors = new WP_Error();
		$user_pass = wp_generate_password();
			
		//require_once( ABSPATH . WPINC . '/registration.php');
			
		// Get (and clean) data
		$fields = array(
			'username',
			'email',
			'password',
			'password2'
		);
		foreach ($fields as $field) {
			if (isset($_POST[$field])) $posted[$field] = wp_unslash(trim($_POST[$field])); else $posted[$field] = '';
		}
			
		$user_login = sanitize_user( $posted['username'] );
		$user_email = apply_filters( 'user_registration_email', $posted['email'] );
				
		// Check the username
		if ( $posted['username'] == '' )
			$errors->add('empty_username', __('<strong>ERROR</strong>: Please enter a username.', 'abomb'));
		elseif ( !validate_username( $posted['username'] ) )
			$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.', 'abomb'));
		elseif ( username_exists( $posted['username'] ) )
			$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.', 'abomb'));
			
		// Check the e-mail address
		if ($posted['email'] == '')
			$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.', 'abomb'));
		elseif ( !is_email( $posted['email'] ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address is incorrect.', 'abomb'));
		elseif ( email_exists( $posted['email'] ) )
			$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.', 'abomb'));
				
		// Check Passwords match
		if ($posted['password'] == '')
			$errors->add('empty_password', __('<strong>ERROR</strong>: Please enter a password.', 'abomb'));
		elseif ($posted['password'] !== $posted['password2'])
			$errors->add('wrong_password', __('<strong>ERROR</strong>: Passwords do not match.', 'abomb'));
		else
			$user_pass = $posted['password'];
		
		if ( zerospam_is_valid() )
			$errors->add('looks_like_spam', __('<strong>ERROR</strong>: We can\'t process your manual registration at the moment. Please try to register through one of the social networks above.', 'abomb'));
				
		do_action('register_post', $posted['username'], $posted['email'], $errors);
		$errors = apply_filters( 'registration_errors', $errors, $posted['username'], $posted['email'] );
	
		
		if ( !$errors->get_error_code() ) :
			$user_id = wp_create_user(  $posted['username'], $user_pass, $posted['email'] );
			if ( !$user_id ) :
				$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'abomb'), get_option('admin_email')));
			else :
				$secure_cookie = is_ssl() ? true : false;
				wp_set_auth_cookie($user_id, true, $secure_cookie);
				wp_new_user_notification( $user_id, $user_pass );
				rd_update_user_meta( $user_id );
				if (function_exists('mongabay_login_cookies')) mongabay_login_cookies($posted['username']);
				
			endif;
		endif;
		
		if (rd_is_ajax()) :
			if ( !$errors->get_error_code() ) :
				echo 'SUCCESS';
			else :
				foreach ($errors->errors as $error) {
					echo $error[0];
					break;
				}
			endif;
			exit;
		else :
			if ( !is_wp_error($user) ) :
				wp_redirect( rd_login_current_url() );
				exit;
			endif;
		endif;
		return $errors;
	}
}

if (!function_exists('rd_handle_lost_password')) {
	function rd_handle_lost_password() {
		
		global $wpdb, $current_site;

		$errors = new WP_Error();

		if ( empty( $_POST['username_or_email'] ) ) $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.', 'abomb'));

		if ( strpos($_POST['username_or_email'], '@') ) {
			$user_data = get_user_by_email(trim($_POST['username_or_email']));
			if ( empty($user_data) ) $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.', 'abomb'));
		} else {
			$login = trim($_POST['username_or_email']);
			$user_data = get_userdatabylogin($login);
		}

		do_action('lostpassword_post');
		
		if ( !$user_data ) $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.', 'abomb'));

		if (rd_is_ajax()) :
			if ( $errors->get_error_code() ) :
				foreach ($errors->errors as $error) {
					echo $error[0];
					break;
				}
				exit;
			endif;
		else :
			if ( $errors->get_error_code() ) return $errors;
		endif;

		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

		do_action('retrieve_password', $user_login);

		$allow = apply_filters('allow_password_reset', true, $user_data->ID);
		
		if ( !$allow ) $errors->add('no_password_reset', __('Password reset is not allowed for this user', 'abomb'));
		else if ( is_wp_error($allow) ) $errors = $allow;
		
		if (rd_is_ajax()) :
			if ( $errors->get_error_code() ) :
				foreach ($errors->errors as $error) {
					echo $error[0];
					break;
				}
				exit;
			endif;
		else :
			if ( $errors->get_error_code() ) return $errors;
		endif;

		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if ( empty($key) ) {
			// Generate something random for a key...
			$key = wp_generate_password(20, false);
			do_action('retrieve_password_key', $user_login, $key);
			// Now insert the new md5 key into the db
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
		}
		$message = __('Someone has asked to reset the password for the following site and username.', 'abomb') . "\r\n\r\n";
		$message .= network_site_url() . "\r\n\r\n";
		$message .= sprintf(__('Username: %s', 'abomb'), $user_login) . "\r\n\r\n";
		$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.', 'abomb') . "\r\n\r\n";
		$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

		if ( is_multisite() ) $blogname = $GLOBALS['current_site']->site_name;
		else $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$title = sprintf( __('[%s] Password Reset', 'abomb'), $blogname );

		$title = apply_filters('retrieve_password_title', $title);
		$message = apply_filters('retrieve_password_message', $message, $key);

		wp_mail(sanitize_email($user_email), sanitize_text_field($title), wp_unslash($message));
		
		if (rd_is_ajax()) :
			echo 'SUCCESS:'.__('Check your e-mail for the confirmation link.', 'abomb');
			exit;
		endif;
		
		return true;
	}
}