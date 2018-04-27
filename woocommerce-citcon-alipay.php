<?php
/* Citcon Payment Gateway Class */
class CitconPayAliPay_Payment extends WC_Payment_Gateway {

	// Setup our Gateway's id, description and other values
	function __construct() {

		// The global ID for this Payment method
		$this->id = "mjm_citcon_pay_alipay";

		// The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
		$this->method_title = __( "Citcon AliPay", 'mjm_citcon_pay_alipay' );

		// The description for this Payment Gateway, shown on the actual Payment options page on the backend
		$this->method_description = __( "CitconPay AliPay Payment Gateway Plug-in for WooCommerce", 'mjm_citcon_pay_alipay' );

		// The title to be used for the vertical tabs that can be ordered top to bottom
		$this->title = __( "Citcon AliPay", 'mjm_citcon_pay_alipay' );

		// If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
		$this->icon = plugin_dir_url( __FILE__ ).'images/alipay.png';

		// Bool. Can be set to true if you want payment fields to show on the checkout 
		// if doing a direct integration, which we are doing in this case
		$this->has_fields = true;

		// Supports the default credit card form
		//$this->supports = array( 'default_credit_card_form' );

		// This basically defines your settings which are then loaded with init_settings()
		$this->init_form_fields();

		// After init_settings() is called, you can get the settings and load them into variables, e.g:
		//$this->title = $this->get_option( 'title' );
		$this->init_settings();
		$this->title = $this->get_option( 'title' );
		// Turn these settings into variables we can use
		foreach ( $this->settings as $setting_key => $value ) {
			$this->$setting_key = $value;
		}
		
		// Lets check for SSL
		//add_action( 'admin_notices', array( $this,	'do_ssl_check' ) );
		
		// Save settings
		if ( is_admin() ) {
			// Versions over 2.0
			// Save our administration options. Since we are not going to be doing anything special
			// we have not defined 'process_admin_options' in this class so the method in the parent
			// class will be used instead
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}		
	} // End __construct()

	// Build the administration fields for this specific Gateway
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'		=> __( 'Enable / Disable', 'mjm_citcon_pay_alipay' ),
				'label'		=> __( 'Enable this payment gateway', 'mjm_citcon_pay_alipay' ),
				'type'		=> 'checkbox',
				'default'	=> 'yes',
			),
			'title' => array(
				'title'		=> __( 'Title', 'mjm_citcon_pay_alipay' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Payment title the customer will see during the checkout process.', 'mjm_citcon_pay_alipay' ),
				'default'	=> __( 'CitconPay AliPay', 'mjm_citcon_pay_alipay' ),
			),
			'description' => array(
				'title'		=> __( 'Description', 'mjm_citcon_pay_alipay' ),
				'type'		=> 'textarea',
				'desc_tip'	=> __( 'Payment description the customer will see during the checkout process.', 'mjm_citcon_pay_alipay' ),
				'default'	=> __( 'Pay securely using your AliPay.', 'mjm_citcon_pay_alipay' ),
				'css'		=> 'max-width:350px;'
			),
			'api_token' => array(
				'title'		=> __( 'Citcon API Token', 'mjm_citcon_pay_alipay' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'This is the API Token provided by Citcon when you signed up for an account.', 'mjm_citcon_pay_alipay' ),
			),
			'successURL' => array(
				'title'		=> __( 'Payment Success Page URL', 'mjm_citcon_pay_wechatpay' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Success Page URL after completed the payment.', 'mjm_citcon_pay_wechatpay' ),
			),
			// 'mobileURL' => array(
			// 	'title'		=> __( 'Payment Success Page URL for Mobile', 'mjm_citcon_pay_wechatpay' ),
			// 	'type'		=> 'text',
			// 	'desc_tip'	=> __( 'Success Page URL for mobile view after completed the payment.', 'mjm_citcon_pay_wechatpay' ),
			// ),
			'failURL' => array(
				'title'		=> __( 'Payment Fail Page URL', 'mjm_citcon_pay_wechatpay' ),
				'type'		=> 'text',
				'desc_tip'	=> __( 'Fail Page URL after completed the payment.', 'mjm_citcon_pay_wechatpay' ),
			),
			'environment' => array(
				'title'		=> __( 'Citcon Test Mode', 'mjm_citcon_pay_alipay' ),
				'label'		=> __( 'Enable Test Mode', 'mjm_citcon_pay_alipay' ),
				'type'		=> 'checkbox',
				'description' => __( 'Place the payment gateway in test mode.', 'mjm_citcon_pay_alipay' ),
				'default'	=> 'no',
			)
		);		
	}
	
	// Submit payment and handle response
	public function process_payment( $order_id ) {
		global $woocommerce;
		
		// Get this Order's information so that we know
		// who to charge and how much
		$customer_order = new WC_Order( $order_id );
		
		// Are we testing right now or is it a real transaction
		$environment = ( $this->environment == "yes" ) ? 'TRUE' : 'FALSE';

		// Decide which URL to post to
		$environment_url = ( "FALSE" == $environment ) 
						   ? 'http://citconpay.com/chop/chop'
						   : 'http://dev.citconpay.com/chop/chop';

		$amount = $customer_order->order_total*100; // hardcode to 1 cent for testing
	    $payment_method = "alipay";
	    $currency = "USD";
	    $reference = str_replace( "#", "", $customer_order->get_order_number() );
	    $callback_url_success = $this->successURL;
	    //$ipn_url = ipnUrl;
	    //$mobile_result_url = $this->mobileURL."?reference=$reference";
	    $callback_url_fail = $this->failURL;
	    // no need to change below this line
	    $params = "payment_method=".urlencode($payment_method).
	              "&currency=".urlencode($currency).
	              "&amount=$amount".
	              "&reference=".urlencode($reference).
	              //"&ipn_url=''".
	              //"&mobile_result_url=".urlencode($mobile_result_url).
	              "&callback_url_success=".urlencode($callback_url_success).
	              "&callback_url_fail=".urlencode($callback_url_fail);
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $environment_url);
	    curl_setopt($curl, CURLOPT_POST, 8);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	        'Authorization: Bearer '.$this->api_token
	    ));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
	    $result = curl_exec($curl);
	    curl_close($curl);
	    $response = json_decode($result);

		if ($response->{'result'} == 'success') {
			$customer_order->add_order_note( __( 'Citcon payment completed.', 'mjm_citcon_pay_alipay' ) ); 
		  
			$customer_order->payment_complete();
			$woocommerce->cart->empty_cart();
			
			return array(
				'result'   => 'success',
				'redirect' => $response->{'url'},
			);

		} else {
			wc_add_notice( $response->{'error'} , 'error' );
			$customer_order->add_order_note( 'Error: '. $response->{'error'} );
		  //echo $response->{'error'};
		}

	}
	
	// Validate fields
	public function validate_fields() {
		return true;
	}
	
	// Check if we are forcing SSL on checkout pages
	// Custom function not required by the Gateway
	public function do_ssl_check() {
		if( $this->enabled == "yes" ) {
			if( get_option( 'woocommerce_force_ssl_checkout' ) == "no" ) {
				echo "<div class=\"error\"><p>". sprintf( __( "<strong>%s</strong> is enabled and WooCommerce is not forcing the SSL certificate on your checkout page. Please ensure that you have a valid SSL certificate and that you are <a href=\"%s\">forcing the checkout pages to be secured.</a>" ), $this->method_title, admin_url( 'admin.php?page=wc-settings&tab=checkout' ) ) ."</p></div>";	
			}
		}		
	}

} // End of CitconPay_Payment