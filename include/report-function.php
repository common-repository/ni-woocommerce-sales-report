<?php
if (!class_exists('ReportFunction')) {
	class ReportFunction
	{

		public function __construct()
		{

		}
		function get_request($request, $default = NULL)
		{
			//$v = $_REQUEST[$request];
			$v = isset($_REQUEST[$request]) ? $_REQUEST[$request] : $default;
			$r = isset($v) ? $v : $default;
			return $r;
		}
		function print_data($r)
		{
			echo '<pre>' . esc_html(print_r($r, true)) . '</pre>';
		}
		function get_price($price)
		{
			//echo '<pre>',print_r($r,1),'</pre>';	
			return wc_price($price);
		}
		function get_country_name($code)
		{
			$name = "";
			if (strlen($code) > 0) {
				$name = isset(WC()->countries->countries[$code]) ? WC()->countries->countries[$code] : '';
				$name = isset($name) ? $name : $code;
			}
			return $name;
		}
		function get_currency($default = "SYMBOL")
		{
			$r = '';
			$currency_name = get_woocommerce_currency();
			$symbol = get_woocommerce_currency_symbol($currency_name);

			if ($default == "NAME")
				$r = $currency_name;
			if ($default == "SYMBOL")
				$r = $symbol;

			return $r;
		}
		/*Dashboard function*/
		function get_customer_report()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$query[] = "SELECT
					SUM(order_total.meta_value)as 'order_total'
					,COUNT(*)as 'order_count'
					,billing_first_name.meta_value as billing_first_name
					,billing_email.meta_value as billing_email
					FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID 
					LEFT JOIN  {$wpdb->prefix}postmeta as billing_first_name ON billing_first_name.post_id=posts.ID 
					LEFT JOIN  {$wpdb->prefix}postmeta as billing_email ON billing_email.post_id=posts.ID 
					
					WHERE 1=1
					AND posts.post_type ='shop_order' 
					AND order_total.meta_key='_order_total' 
					AND billing_first_name.meta_key='_billing_first_name' 
					AND billing_email.meta_key='_billing_email' 
					AND  posts.post_status NOT IN ('trash')
					GROUP BY  billing_email.meta_value 
					
					ORDER BY SUM(order_total.meta_value) DESC
					
					LIMIT 5
					";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_results(implode(' ', $query));


			return $row;
		}
		function get_customer_report_hpos()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$query[] = "SELECT
					SUM(posts.total_amount)as 'order_total'
					,COUNT(*)as 'order_count'
					,order_addresses.first_name as billing_first_name
					,order_addresses.email as billing_email
					FROM {$wpdb->prefix}wc_orders as posts			
					LEFT JOIN  {$wpdb->prefix}wc_order_addresses as order_addresses ON order_addresses.order_id=posts.id
					
					
					WHERE 1=1
					AND posts.type ='shop_order' 
					
					AND  posts.status NOT IN ('trash') ";

			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";

			$query[] = "AND order_addresses.address_type ='billing' 

					GROUP BY  order_addresses.email 
					
					ORDER BY SUM(posts.total_amount) DESC
					
					LIMIT 5
					";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_results(implode(' ', $query));


			return $row;
		}
		function get_country_report()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$query[] = "SELECT
					SUM(order_total.meta_value)as 'order_total'
					,COUNT(*)as 'order_count'
					,billing_country.meta_value as billing_country
					FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID 
					LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id=posts.ID 
		
					
					WHERE 1=1
					AND posts.post_type ='shop_order' 
					AND order_total.meta_key='_order_total' 
					AND billing_country.meta_key='_billing_country' 
					AND  posts.post_status NOT IN ('trash')
					
					GROUP BY  billing_country.meta_value 
					
					ORDER BY SUM(order_total.meta_value) DESC
					
					LIMIT 5
					";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared		
			$row = $wpdb->get_results(implode(' ', $query));

			return $row;
		}
		function get_country_report_hpos()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$query[] = "SELECT
					SUM(posts.total_amount)as 'order_total'
					,COUNT(*)as 'order_count'
					,order_addresses.country  as billing_country
					FROM {$wpdb->prefix}wc_orders as posts			
					LEFT JOIN  {$wpdb->prefix}wc_order_addresses as order_addresses ON order_addresses.order_id=posts.id 
					
		
					
					WHERE 1=1
					AND posts.type ='shop_order' 
				
					AND  posts.status NOT IN ('trash') ";

				$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";

				$query[] = "AND order_addresses.address_type ='billing' 


		
					
					GROUP BY  order_addresses.country 
					
					ORDER BY SUM(posts.total_amount) DESC
					
					LIMIT 5
					";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared		
			$row = $wpdb->get_results(implode(' ', $query));

			return $row;
		}
		function get_low_in_stock()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$stock = absint(max(get_option('woocommerce_notify_low_stock_amount'), 1));
			$nostock = absint(max(get_option('woocommerce_notify_no_stock_amount'), 0));

			$query[] = "SELECT COUNT( DISTINCT posts.ID ) as low_in_stock  FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes' ";
			$query[] = $wpdb->prepare(" AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <=  %d ", $stock);
			$query[] = $wpdb->prepare(" AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) >   %d ", $nostock);


			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;

		}
		function get_out_of_stock()
		{
			global $wpdb;
			$row = array();
			$query = array();
			$stock = absint(max(get_option('woocommerce_notify_no_stock_amount'), 0));

			$query[] = "SELECT COUNT( DISTINCT posts.ID ) as out_of_stock FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'";
			$query[] = $wpdb->prepare(" AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value =  %d ", 'yes');
			$query[] = $wpdb->prepare(" AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) <= %d ", $stock);

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;

		}
		function get_most_stock()
		{
			global $wpdb;
			$row = array();
			$query = "";
			$stock = absint(max(get_option('woocommerce_notify_low_stock_amount'), 0));

			$query = array();
			$query[] = " SELECT COUNT( DISTINCT posts.ID ) FROM {$wpdb->prefix}posts as posts
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta ON posts.ID = postmeta.post_id
			INNER JOIN {$wpdb->prefix}postmeta AS postmeta2 ON posts.ID = postmeta2.post_id
			WHERE 1=1
			AND posts.post_type IN ( 'product', 'product_variation' )
			AND posts.post_status = 'publish'
			AND postmeta2.meta_key = '_manage_stock' AND postmeta2.meta_value = 'yes' ";
			$query[] = $wpdb->prepare(" AND postmeta.meta_key = '_stock' AND CAST(postmeta.meta_value AS SIGNED) > %d ", $stock);

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;

		}
		function get_sales_year()
		{
			global $wpdb;

			$years = array();

			$rows = array();
			$query = array();
			$query[] = " SELECT ";
			$query[] = " date_format( posts.post_date, '%Y') as order_year";
			$query[] = " FROM {$wpdb->prefix}posts as posts	";
			$query[] = "  WHERE 1 = 1";
			$query[] = " AND	posts.post_type ='shop_order' ";
			$query[] = $wpdb->prepare(" Order By date_format( posts.post_date, %s)  DESC ", '%Y');

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	 
			$rows = $wpdb->get_results(implode(' ', $query));

			foreach ($rows as $key => $value) {
				$years[$value->order_year] = $value->order_year;
			}

			return $years;
		}
		function is_hpos_enabled(){
			
			/*$enabled_hpos = get_option('woocommerce_custom_orders_table_enabled','no');
			
			if(!isset($this->vers['enabled_hpos'])){
				$enabled_hpos = get_option('woocommerce_custom_orders_table_enabled','no');
				$enabled_hpos = $enabled_hpos == 'yes' ? true : false;
				$this->vers['enabled_hpos'] = $enabled_hpos;
			}else{
				$enabled_hpos = $this->vers['enabled_hpos'];
			}
			*/
			
			 $enabled_hpos = false;
			
			if (  class_exists( '\Automattic\WooCommerce\Utilities\OrderUtil' ) ) {
				if ( \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled() ) {
					 $enabled_hpos = true;
				} else {
					 $enabled_hpos= false;
				}
			}
			
			
			return $enabled_hpos;
		}
		function get_sales_year_hpos()
		{
			global $wpdb;

			$years = array();

			$rows = array();
			$query = array();
			$query[] = " SELECT ";
			$query[] = " date_format( posts.date_created_gmt, '%Y') as order_year";
			$query[] = " FROM {$wpdb->prefix}wc_orders as posts	";
			$query[] = "  WHERE 1 = 1";
			$query[] = " AND	posts.type ='shop_order' ";
			$query[] = $wpdb->prepare(" Order By date_format( posts.date_created_gmt, %s)  DESC ", '%Y');

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	 
			$rows = $wpdb->get_results(implode(' ', $query));

			foreach ($rows as $key => $value) {
				$years[$value->order_year] = $value->order_year;
			}

			return $years;
		}




		/*End Dashbaord function*/
	}
}
//new ReportFunction();  
?>