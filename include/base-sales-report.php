<?php 
if ( ! defined( 'ABSPATH' ) ) { exit;}

if( !class_exists( 'BaseSalesReport' ) ) {
include_once('report-function.php'); 
class BaseSalesReport extends ReportFunction{
	
	var $vars = array();
	
 	 public function __construct($vars = array()){
	 	
		$this->vars = $vars;
	 	
		//$this->print_data( $_REQUEST["page"] );
	 	add_action( 'admin_menu',  array(&$this,'admin_menu' ),100);
		$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : '';
		
		$admin_pages = $this->get_admin_pages();
		if (in_array($page,$admin_pages)){
			
			add_action( 'admin_enqueue_scripts',  array(&$this,'admin_enqueue_scripts' ));
		}
		add_action( 'wp_ajax_sales_order',  array(&$this,'ajax_sales_order' )); /*used in form field name="action" value="my_action"*/
		add_action('admin_init', array( &$this, 'admin_init' ) );
		add_filter( 'plugin_row_meta',  array(&$this,'plugin_row_meta' ), 10, 2 );
		add_filter( 'admin_footer_text',  array(&$this,'admin_footer_text' ),101);
		//add_filter( 'gettext', array($this, 'get_text'),20,3);
		
	}
	function get_admin_pages(){
		$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : '';
		$admin_pages = array();
		$admin_pages[] = 'ni-sales-report';
		$admin_pages[] = 'ni-order-product';
		$admin_pages[] = 'ni-sales-report-addons';
		$admin_pages[] = 'ni-category-report';
		$admin_pages[] = 'ni-top-product-report';
		$admin_pages[] = 'ni-summary-report';
		$admin_pages[] = 'ni-monthly-sales-report';
		$admin_pages[] = 'ni-analytical-sales-report';
		$admin_pages[] = 'ni-order-status-report';
		$admin_pages[] = 'ni-product-analysis-report';
		$admin_pages = apply_filters('ni_sales_report_admin_enqueue_script_pages',$admin_pages, $page);
		return $admin_pages;
	}
	
	function get_text($translated_text, $text, $domain){
		if($domain == 'nisalesreport'){
			return '['.$translated_text.']';
		}		
		return $translated_text;
	}
	function admin_footer_text($text){
		$page = isset($_REQUEST["page"]) ? sanitize_text_field($_REQUEST["page"]) : '';
		$admin_pages = $this->get_admin_pages();
		if (in_array($page, $admin_pages)){
			//if ($page == "ni-sales-report" || $page  =="ni-order-product" || $page =="ni-sales-report-addons" || $page == "ni-top-product-report"){
			$text = sprintf(
				/* translators: 1: link to Naziinfotech website */
				__( 'Thank you for using our plugins <a href="%s" target="_blank">naziinfotech</a>', 'nisalesreport' ),
				__( 'http://naziinfotech.com/', 'nisalesreport' )
			);
			$text = "<span id=\"footer-thankyou\">" . $text . "</span>";
			//}
		}
		return $text;
	}
	function plugin_row_meta($links, $file){
		if ( $file == "ni-woocommerce-sales-report/ni-woocommerce-sales-report.php" ) {
			$row_meta = array(
			
			'ni_pro_version'=> '<a target="_blank" href="http://naziinfotech.com/product/ni-woocommerce-sales-report-pro">Buy Pro Version</a>',
			
			'ni_pro_review'=> '<a target="_blank" href="https://wordpress.org/support/plugin/ni-woocommerce-sales-report/reviews/">Write a Review</a>'	);
				

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
	function admin_enqueue_scripts($hook) {
   		 if (isset($_REQUEST["page"])){
			$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : '';
			$admin_pages = $this->get_admin_pages();
			if (in_array($page,$admin_pages)){
		 	
				wp_enqueue_script( 'ni-sales-report-ajax-script', plugins_url( '../assets/js/script.js', __FILE__ ), array('jquery') );
		 		wp_enqueue_script( 'jquery-ui', plugins_url( '../assets/js/jquery-ui.js', __FILE__ ), array('jquery') );
		 		
				/*Start bootstrap*/
				wp_register_style('niwoosalesreport-bootstrap-css', plugins_url( '../assets/css/bootstrap/bootstrap.min.css', __FILE__ ) );
				wp_enqueue_style('niwoosalesreport-bootstrap-css');
				
				wp_enqueue_script('niwoosalesreport-bootstrap-popper', plugins_url( '../assets/js/bootstrap/popper.min.js', __FILE__ ));
				wp_enqueue_script('niwoosalesreport-bootstrap-js', plugins_url( '../assets/js/bootstrap/bootstrap.min.js', __FILE__ ));
				
				
				wp_register_style('niwoosalesreport-new-style',  plugins_url( '../assets/css/niwoosalesreport-style-new.css', __FILE__ ) );
				wp_enqueue_style('niwoosalesreport-new-style'); 
				
				/*End bootstrap*/
				
			
				if ($page == "ni-sales-report"){
					
					wp_register_style( 'ni-font-awesome-css', plugins_url( '../assets/css/font-awesome.css', __FILE__ ));
		 			wp_enqueue_style( 'ni-font-awesome-css' );
					
					wp_register_script( 'ni-amcharts-script', plugins_url( '../assets/js/amcharts/amcharts.js', __FILE__ ) );
					wp_enqueue_script('ni-amcharts-script');
				
		
					wp_register_script( 'ni-light-script', plugins_url( '../assets/js/amcharts/light.js', __FILE__ ) );
					wp_enqueue_script('ni-light-script');
				
					wp_register_script( 'ni-pie-script', plugins_url( '../assets/js/amcharts/pie.js', __FILE__ ) );
					wp_enqueue_script('ni-pie-script');
				
					
				}
				if ($page == "ni-product-analysis-report"){
					wp_register_style( 'ni-font-awesome-css', plugins_url( '../assets/css/font-awesome.css', __FILE__ ));
					wp_enqueue_style( 'ni-font-awesome-css' );
					
					wp_enqueue_script( 'ni-product-analysis-report-ajax-script', plugins_url( '../assets/js/ni-product-analysis.js', __FILE__ ), array('jquery') );
				}
				
		 		//wp_localize_script( 'ni-sales-report-ajax-script','ni_sales_report_ajax_object',array('ni_sales_report_ajaxurl'=>admin_url('admin-ajax.php')));
				
				 $nonce = wp_create_nonce('ajax_sales_order_nonce');
				// Localize script with AJAX URL and nonce
				wp_localize_script('ni-sales-report-ajax-script', 'ni_sales_report_ajax_object', array(
					'ni_sales_report_ajaxurl' => admin_url('admin-ajax.php'),
					'nonce' => $nonce // Include nonce in the object
				));
				do_action('ni_sales_report_admin_enqueue_scripts',$page, $this->vars);	
			}
		 }
		
    }
	
	/*Ajax Call*/
	function ajax_sales_order()
	{
		
		 // Check user capability
		if (!current_user_can('manage_woocommerce')) {
			wp_send_json_error('Unauthorized access');
		}

		 // Verify nonce
		$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
		if (!wp_verify_nonce($nonce, 'ajax_sales_order_nonce')) {
			wp_send_json_error('Invalid nonce');
		}
		
		
		$page= $this->get_request("page");
		
		do_action('ni_sales_report_ajax_action',$page, $this->vars);		
		
		if($page=="ni-order-product")
		{	include_once('order-item.php');
			$obj = new OrderItem();  
			$obj->ajax_call();
		}
		if($page=="ni-category-report")
		{	include_once('ni-category-report.php');
			$obj = new Ni_Category_Report();  
			$obj->get_ajax();
		}
		if($page=="ni-summary-report")
		{	include_once('ni-summary-report.php');
			$obj = new Ni_Summary_Report();  
			$obj->get_ajax();
		}
		if ($page=="ni-monthly-sales-report"){
			include_once('ni-monthly-sales-report.php');
			$initialize = new Ni_Monthly_Sales_Report(); 
			$initialize->get_ajax(); 
		}
		if ($page=="ni-analytical-sales-report"){
			include_once('ni-analytical-sales-report.php');
			$initialize = new Ni_Analytical_Sales_Report(); 
			$initialize->get_ajax(); 
		}
		if ($page=="ni-order-status-report"){
			include_once('ni-order-status-report.php');
			$initialize = new Ni_Order_Status_Report(); 
			$initialize->get_ajax(); 
		}
		if ($page=="ni-product-analysis-report"){
			include_once('ni-product-analysis-report.php');
			$initialize = new Ni_Product_Analysis_Report(); 
			$initialize->get_ajax(); 
		}
		die;
	}
	function admin_menu(){
   		add_menu_page(__(  'Sales Report', 'nisalesreport')
		,__(  'Ni Sales Report', 'nisalesreport')
		,'manage_options'
		,'ni-sales-report'
		,array(&$this,'AddMenuPage')
		,'dashicons-media-document'
		,57.981);
    	add_submenu_page('ni-sales-report'
		,__( 'Dashboard', 'nisalesreport' )
		,__( 'Dashboard', 'nisalesreport' )
		,'manage_options'
		,'ni-sales-report' 
		,array(&$this,'AddMenuPage'));
    	add_submenu_page('ni-sales-report'
		,__( 'Order Product', 'nisalesreport' )
		,__( 'Order Product', 'nisalesreport' )
		, 'manage_options', 'ni-order-product' 
		, array(&$this,'AddMenuPage'));
		
		add_submenu_page('ni-sales-report'
		,__( 'Category Report', 'nisalesreport' )
		,__( 'Category Report', 'nisalesreport' )
		, 'manage_options', 'ni-category-report' 
		, array(&$this,'AddMenuPage'));
		
		add_submenu_page('ni-sales-report'
		,__( 'Top Product', 'nisalesreport' )
		,__( 'Top Product', 'nisalesreport' )
		, 'manage_options', 'ni-top-product-report' 
		, array(&$this,'AddMenuPage'));
		
		add_submenu_page('ni-sales-report'
		,__( 'Summary Report', 'nisalesreport' )
		,__( 'Summary Report', 'nisalesreport' )
		, 'manage_options', 'ni-summary-report' 
		, array(&$this,'AddMenuPage'));
		
		
			add_submenu_page('ni-sales-report'
		,__( 'Monthly Sales Report', 'nisalesreport' )
		,__( 'Monthly Sales Report', 'nisalesreport' )
		, 'manage_options', 'ni-monthly-sales-report' 
		, array(&$this,'AddMenuPage'));
		
		
		add_submenu_page('ni-sales-report'
		,__( 'Analytical Sales Report', 'nisalesreport' )
		,__( 'Analytical Sales Report', 'nisalesreport' )
		, 'manage_options', 'ni-analytical-sales-report' 
		, array(&$this,'AddMenuPage'));
		
		add_submenu_page('ni-sales-report'
		,__( 'Order Status Report', 'nisalesreport' )
		,__( 'Order Status Report', 'nisalesreport' )
		, 'manage_options', 'ni-order-status-report' 
		, array(&$this,'AddMenuPage'));

		add_submenu_page('ni-sales-report'
		,__( 'Product Analysis', 'nisalesreport' )
		,__( 'Product Analysis', 'nisalesreport' )
		, 'manage_options', 'ni-product-analysis-report' 
		, array(&$this,'AddMenuPage'));
		
		
		//ni-product-analysis-report
		
		
		do_action('ni_sales_report_menu','ni-sales-report',$this->vars);
		
		add_submenu_page('ni-sales-report'
		,__( 'Other Plugins', 'nisalesreport' )
		,__( 'Other Plugins', 'nisalesreport' )
		, 'manage_options'
		, 'ni-sales-report-addons' , array(&$this,'AddMenuPage'));
		
		
		
		
	}
	function AddMenuPage()
	{
		$page= $this->get_request("page");
		
		do_action('ni_sales_report_admin_page',$page, $this->vars);
		
		/*Order Item*/
		if($page=="ni-order-product")
		{	include_once('order-item.php');
			$initialize = new OrderItem();  
			$initialize->create_form();
		}
		/*Order Item*/
		if($page=="ni-sales-report")
		{	include_once('order-summary.php');
			$initialize = new Summary();  
			$initialize->init();
		}
		
		/*Order Item*/
		if($page=="ni-sales-report-addons")
		{	include_once('ni-sales-report-addons.php');
			$initialize = new ni_sales_report_addons(); 
			$initialize->page_init(); 
		}
		if($page=="ni-category-report")
		{	include_once('ni-category-report.php');
			$initialize = new Ni_Category_Report(); 
			$initialize->page_init(); 
		}
		
		if ($page=="ni-top-product-report"){
			include_once('ni-top-product-report.php');
			$initialize = new Ni_Top_Product_Report(); 
			$initialize->page_init(); 
		}
		if ($page=="ni-summary-report"){
			include_once('ni-summary-report.php');
			$initialize = new Ni_Summary_Report(); 
			$initialize->page_init(); 
		}
		if ($page=="ni-monthly-sales-report"){
			include_once('ni-monthly-sales-report.php');
			$initialize = new Ni_Monthly_Sales_Report(); 
			$initialize->page_init(); 
		}
		
		
		
		if ($page=="ni-analytical-sales-report"){
			include_once('ni-analytical-sales-report.php');
			$initialize = new Ni_Analytical_Sales_Report(); 
			$initialize->page_init(); 
		}
		
		if ($page=="ni-order-status-report"){
			include_once('ni-order-status-report.php');
			$initialize = new Ni_Order_Status_Report(); 
			$initialize->page_init(); 
		}
		if ($page =="ni-product-analysis-report"){
			include_once('ni-product-analysis-report.php');
			$initialize = new Ni_Product_Analysis_Report(); 
			$initialize->page_init(); 

		}
		
	}
	function admin_init()
	{
		
		do_action('ni_sales_report_admin_init',$this->vars);
		if(isset($_REQUEST['btn_print'])){
			include_once('order-item.php');
			$obj = new OrderItem();
			$obj->get_print_content();
			die;
		}
		
		
		
	}
	public function activation() {
      // To override
    }	
	 // Called when the plugin is deactivated
    public function deactivation() {
      // To override
    }
	 // Called when the plugin is loaded
    public function loaded() {
      // To override
    }
}
}
?>