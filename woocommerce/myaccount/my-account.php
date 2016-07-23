<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices(); ?>

<h3><?php _e('My Account','woocommerce'); ?></h3>
<div class="myaccount_user">
	<table>
		<tr><th><?php  _e('Your Name','woocommerce'); ?></th><td><?php echo $current_user->display_name; ?></td></tr>
       <tr><th><?php  _e('Your Username','woocommerce'); ?></th><td><?php echo $current_user->user_login; ?></td></tr>
       <tr><th><?php  _e('Your E-mail address','woocommerce'); ?></th><td><?php echo $current_user->user_email; ?></td></tr>
   </table>
   <a href="<?php echo wc_customer_edit_account_url() ?>" class="button">Edit User Details</a>
</div>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>


<?php do_action( 'woocommerce_after_my_account' ); ?>
