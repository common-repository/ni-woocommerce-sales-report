<?php
/*
Plugin Name: Ni WooCommerce Sales Report
Description: Enhance WooCommerce sales report beautifully and provide complete solutions for WooCommerce reporting.
Author: 	 anzia
Version: 	 3.8.0
Author URI:  http://naziinfotech.com/
Plugin URI:  https://wordpress.org/plugins/ni-woocommerce-sales-report/
License:	 GPLv3 or later
License URI: http://www.gnu.org/licenses/agpl-3.0.html
Text Domain: nisalesreport
Domain Path: /languages/
Requires at least: 4.7
Tested up to: 6.6.2
WC requires at least: 3.0.0
WC tested up to: 9.3.3
Last Updated Date: 12-October-2024
Requires PHP: 7.0
*/
if ( !class_exists( 'Ni_WooCommerce_Sales_Report' ) ) {
	
	class Ni_WooCommerce_Sales_Report {

		function __construct() {
			if ( is_admin() ) {
				$vars = array();
				$vars['__FILE__'] = __FILE__;
				add_action( 'plugins_loaded',  array(&$this,'plugins_loaded') );
				add_action( 'before_woocommerce_init',  array(&$this,'before_woocommerce_init') );
					add_filter( 'plugin_action_links', array( $this, 'plugin_action_links_sales_report' ), 10, 2);
				include_once('include/base-sales-report.php'); 
				$obj = new BaseSalesReport($vars);
			}
		 }
		 function plugin_action_links_sales_report($actions, $plugin_file){
		 	static $plugin;

			if (!isset($plugin))
				$plugin = plugin_basename(__FILE__);
				
			if ($plugin == $plugin_file) {
					$buy_pro = array('buypro' => '<a href="http://naziinfotech.com/product/ni-woocommerce-sales-report-pro/" target="_blank">' . __('Buy Pro', 'nisalesreport') . '</a>');
					$site_link = array('support' => '<a href="http://naziinfotech.com" target="_blank">' . __('Support', 'nisalesreport') . '</a>');
					$email_link = array('email' => '<a href="mailto:support@naziinfotech.com" target="_top">' . __('Email', 'nisalesreport') . '</a>');
					
					$actions = array_merge($site_link, $actions);
					$actions = array_merge($email_link, $actions);
					$actions = array_merge($buy_pro, $actions);
			}
				
			return $actions;
		 }
		 function before_woocommerce_init(){
			if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			}	 
		 }
		 function plugins_loaded(){
			//load_plugin_textdomain('nisalesreport', WP_PLUGIN_DIR.'/ni-woocommerce-sales-report/languages','ni-woocommerce-sales-report/languages');
			//load_plugin_textdomain('nisalesreport', '', 'ni-woocommerce-sales-report/languages');
			
			 load_plugin_textdomain( 'nisalesreport', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

		 }	
		 
	}
	$obj  = new Ni_WooCommerce_Sales_Report();
}