<?php
/**
 * Plugin Name: WooCommerce Citcon Payment
 * Plugin URI: http://pthnyc.com
 * Version: 1.0.0
 * Description: Citcon Payment Gateway for WooCommerce
 * Author: MH
 * Tested up to: 4.9.1
 * Author URI: http://crevinno.com
 * Text Domain: woocommerce-citcon-payment

 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package woocommerce-citcon-payment
 */

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) : 

// Include our Gateway Class and register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'citcon_payment_init', 0 );
function citcon_payment_init() {
	// If the parent WC_Payment_Gateway class doesn't exist
	// it means WooCommerce is not installed on the site
	// so do nothing
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
	
	// If we made it this far, then include our Gateway Class
	include_once( 'woocommerce-citcon-wechatpay.php' );
	include_once( 'woocommerce-citcon-alipay.php' );
	include_once( 'woocommerce-citcon-credit-card.php' );

	// Now that we have successfully included our class,
	// Lets add it too WooCommerce
	add_filter( 'woocommerce_payment_gateways', 'mjm_add_citcon_payment_wechatpay' );
	function mjm_add_citcon_payment_wechatpay( $methods ) {
		$methods[] = 'CitconPayWeChatPay_Payment';
		return $methods;
	}
	add_filter( 'woocommerce_payment_gateways', 'mjm_add_citcon_payment_alipay' );
	function mjm_add_citcon_payment_alipay( $methods ) {
		$methods[] = 'CitconPayAliPay_Payment';
		return $methods;
	}
	add_filter( 'woocommerce_payment_gateways', 'mjm_add_citcon_payment_cc' );
	function mjm_add_citcon_payment_cc( $methods ) {
		$methods[] = 'CitconPayCCPay_Payment';
		return $methods;
	}
}

// Add custom action links
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'citcon_payment_action_links' );
function citcon_payment_action_links( $links ) {
	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '">' . __( 'Settings', 'mjm-citconpay-wechatpay' ) . '</a>',
	);

	// Merge our new link with the default ones
	return array_merge( $plugin_links, $links );	
}



endif;
