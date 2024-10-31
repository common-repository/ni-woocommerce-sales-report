<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
include_once('report-function.php');  
if( !class_exists( 'Ni_Order_Status_Report' ) ) {
		class Ni_Order_Status_Report extends ReportFunction{
			var $is_hpos_enable = false;
  		public function __construct(){
			 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
		}
		function page_init(){
			//echo $this->get_tables();
		?>
	 	<div class="container-fluid" id="niwoosalesreport">
		 <div class="row">
				
				<div class="col-md-12"  style="padding:0px;">
					<div class="card" style="max-width:70% ">
						<div class="card-header niwoosr-bg-c-purple">
							<?php esc_html_e('Order Status Report', 'nisalesreport'); ?>
						</div>
						<div class="card-body">
							  <form id="frmOrderItem" method="post" >
								<div class="form-group row">
								<div class="col-sm-2">
									<label for="select_order"><?php esc_html_e('Select order period', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									<select name="select_order"  id="select_order" class="form-control">
										  <option value="today"><?php esc_html_e('Today', 'nisalesreport'); ?></option>
										  <option value="yesterday"><?php esc_html_e('Yesterday', 'nisalesreport'); ?></option>
										  <option value="last_7_days"><?php esc_html_e('Last 7 days', 'nisalesreport'); ?></option>
										  <option value="last_10_days"><?php esc_html_e('Last 10 days', 'nisalesreport'); ?></option>
                                           <option value="last_15_days"><?php esc_html_e('Last 15 days', 'nisalesreport'); ?></option>
										  <option value="last_30_days"><?php esc_html_e('Last 30 days', 'nisalesreport'); ?></option>
										  <option value="last_60_days"><?php esc_html_e('Last 60 days', 'nisalesreport'); ?></option>
										  <option value="this_year"><?php esc_html_e('This year', 'nisalesreport'); ?></option>
									</select>
								</div>
								
							</div>
								
							<div class="form-group row">
								<div class="col-sm-12 text-right">
									<input type="submit" class="niwoosalesreport_button_form niwoosalesreport_button" value="Search">
								</div>
								
								
							</div>
								
								 <input type="hidden"  name="action" id="action" value="sales_order"/>
                 				 <input type="hidden"  name="ajax_function" id="ajax_function" value="order_item"/>
                 				<input type="hidden" name="page" id="page" value="<?php echo esc_attr( isset($_REQUEST["page"]) ? $_REQUEST["page"] : '' ); ?>" />		
							</form>
					
						</div>
					</div>
				</div>
				

			</div>
		 <div class="row" >
            	<div class="col-md-12"  style="padding:0px;">
         			<div class="card">
                      
                      <div class="card-body "> 
                        <div class="row">
                        	<div class="table-responsive niwoosr-table">
								<div class="ajax_content"></div>
                            </div>
                           
                        </div>
						</div>
                      
                    </div>       	
                </div>
            </div> 
			 
	 </div>
    	<?php	
		}
		function get_ajax(){
			$this->get_tables();
		}
		function get_query(){
			global $wpdb;
			
			$select_order = $this->get_request("select_order","today");
			
			$today = date_i18n("Y-m-d");
			
			$query   = array();
			$query[] = " SELECT   ";    
			$query[] =  "  posts.post_status  order_status ";    
			$query[] = ",  COUNT(*) as order_count ";    
			$query[] = ", ROUND(SUM(order_total.meta_value),2) as order_total ";
			$query[] = ", ROUND(SUM(order_tax.meta_value),2) as order_tax ";
			$query[] = ", ROUND(SUM(order_shipping_tax.meta_value),2) as order_shipping_tax ";
			$query[] = ", ROUND(SUM(order_shipping.meta_value),2) as order_shipping ";
			$query[] = ", ROUND(SUM(cart_discount_tax.meta_value),2) as cart_discount_tax ";
			$query[] = ", ROUND(SUM(cart_discount.meta_value),2) as cart_discount ";
			$query[] = " FROM {$wpdb->prefix}posts as posts    ";    
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_tax ON order_tax.post_id=posts.ID ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping_tax ON order_shipping_tax.post_id=posts.ID ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping ON order_shipping.post_id=posts.ID ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount_tax ON cart_discount_tax.post_id=posts.ID ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount ON cart_discount.post_id=posts.ID ";
			$query[] = "  WHERE 1 = 1";  
			$query[] = " AND    posts.post_type ='shop_order' ";
			$query[] = " AND    order_total.meta_key ='_order_total' ";
			$query[] = " AND    order_tax.meta_key ='_order_tax' ";
			$query[] = " AND    order_shipping_tax.meta_key ='_order_shipping_tax' ";
			$query[] = " AND    order_shipping.meta_key ='_order_shipping' ";
			$query[] = " AND    cart_discount_tax.meta_key ='_cart_discount_tax' ";
			$query[] = " AND    cart_discount.meta_key ='_cart_discount' ";
			
			switch ($select_order) {
				case "today":
					$query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
					break;
				case "yesterday":
					$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY),%s)",'%Y-%m-%d', '%Y-%m-%d');
					break;
				case "last_7_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_10_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "last_30_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_60_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "this_year":
					$query[] = $wpdb->prepare( " AND  YEAR(date_format( posts.post_date, %s)) = YEAR(date_format(CURDATE(),%s))", '%Y-%m-%d', '%Y-%m-%d');           
					break;      
				default:
					$query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
			}
			
			$query[] = " GROUP BY posts.post_status ";
			
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));
			return $rows;
		}
		function get_query_hpos2(){
			global $wpdb;
			
			$select_order = $this->get_request("select_order","today");
			
			$today = date_i18n("Y-m-d");
			
			$query   = array();
			$query[] = " SELECT   ";    
			$query[] =  "  posts.status  order_status ";    
			$query[] = ",  COUNT(posts.status) as order_count ";    
			$query[] = ", ROUND(SUM(posts.total_amount),2) as order_total ";
			$query[] = ", ROUND(SUM(posts.tax_amount),2) as order_tax ";
			$query[] = ", ROUND(SUM(shipping_total_tax.meta_value),2) as order_shipping_tax ";
			$query[] = ", ROUND(SUM(order_stats.shipping_total),2) as order_shipping ";
			$query[] = ", ROUND(SUM(discount_amount_tax.meta_value),2) as cart_discount_tax ";
			$query[] = ", ROUND(SUM(discount_amount.meta_value),2) as cart_discount ";
			$query[] = " FROM {$wpdb->prefix}wc_orders as posts    ";    
			$query[] = "  LEFT JOIN  {$wpdb->prefix}wc_order_stats as order_stats ON order_stats.order_id=posts.ID ";

			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as counpon_order_items ON counpon_order_items.order_id=posts.ID ";

			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items_shipping ON order_items_shipping.order_id=posts.ID ";

			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as discount_amount ON discount_amount.order_item_id=counpon_order_items.order_item_id ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as discount_amount_tax ON discount_amount_tax.order_item_id=counpon_order_items.order_item_id ";
			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as shipping_total_tax ON shipping_total_tax.order_item_id=order_items_shipping.order_item_id ";

			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_tax ON order_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping_tax ON order_shipping_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping ON order_shipping.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount_tax ON cart_discount_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount ON cart_discount.post_id=posts.ID ";
			$query[] = "  WHERE 1 = 1";  
			$query[] = " AND    posts.type ='shop_order' ";
			//$query[] = " AND    order_total.meta_key ='_order_total' ";
			//$query[] = " AND    order_tax.meta_key ='_order_tax' ";
			//$query[] = " AND    order_shipping_tax.meta_key ='_order_shipping_tax' ";
			//$query[] = " AND    order_shipping.meta_key ='_order_shipping' ";
			//$query[] = " AND    cart_discount_tax.meta_key ='_cart_discount_tax' ";
			//$query[] = " AND    cart_discount.meta_key ='_cart_discount' ";
			$query[] = "	AND counpon_order_items.order_item_type ='coupon' ";
			$query[] = "	AND order_items_shipping.order_item_type ='shipping' ";

			$query[] = "	AND discount_amount.meta_key ='discount_amount' ";
			$query[] = "	AND discount_amount_tax.meta_key ='discount_amount_tax' ";
			$query[] = "	AND shipping_total_tax.meta_key ='total_tax' ";
			switch ($select_order) {
				case "today":
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
					break;
				case "yesterday":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY),%s)",'%Y-%m-%d', '%Y-%m-%d');
					break;
				case "last_7_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_10_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "last_30_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_60_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "this_year":
					$query[] = $wpdb->prepare( " AND  YEAR(date_format( posts.date_created_gmt, %s)) = YEAR(date_format(CURDATE(),%s))", '%Y-%m-%d', '%Y-%m-%d');           
					break;      
				default:
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
			}
			
			$query[] = " GROUP BY posts.status  ";
			
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));

			//$this->print_data($wpdb );
			return $rows;
		}

		function get_query_hpos(){
			global $wpdb;
			
			$select_order = $this->get_request("select_order","today");
			
			$today = date_i18n("Y-m-d");
			
			$query   = array();
			$query[] = " SELECT   ";    
			$query[] =  "  posts.status  order_status ";    
			$query[] = ",  COUNT(posts.status) as order_count ";    
			$query[] = ", ROUND(SUM(posts.total_amount),2) as order_total ";
			$query[] = ", ROUND(SUM(order_stats.tax_total),2) as order_tax ";
			//$query[] = ", ROUND(SUM(shipping_total.shipping_total),2) as order_shipping_tax ";
			$query[] = ", ROUND(SUM(order_stats.shipping_total),2) as order_shipping ";
			//$query[] = ", ROUND(SUM(discount_amount_tax.meta_value),2) as cart_discount_tax ";
			//$query[] = ", ROUND(SUM(discount_amount.meta_value),2) as cart_discount ";
			$query[] = " FROM {$wpdb->prefix}wc_orders as posts    ";    
			$query[] = "  LEFT JOIN  {$wpdb->prefix}wc_order_stats as order_stats ON order_stats.order_id=posts.ID ";

			//$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as counpon_order_items ON counpon_order_items.order_id=posts.ID ";

			//$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items_shipping ON order_items_shipping.order_id=posts.ID ";

			//$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as discount_amount ON discount_amount.order_item_id=counpon_order_items.order_item_id ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as discount_amount_tax ON discount_amount_tax.order_item_id=counpon_order_items.order_item_id ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as shipping_total_tax ON shipping_total_tax.order_item_id=order_items_shipping.order_item_id ";

			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_tax ON order_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping_tax ON order_shipping_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_shipping ON order_shipping.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount_tax ON cart_discount_tax.post_id=posts.ID ";
			//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as cart_discount ON cart_discount.post_id=posts.ID ";
			$query[] = "  WHERE 1 = 1";  
			$query[] = " AND    posts.type ='shop_order' ";
			//$query[] = " AND    order_total.meta_key ='_order_total' ";
			//$query[] = " AND    order_tax.meta_key ='_order_tax' ";
			//$query[] = " AND    order_shipping_tax.meta_key ='_order_shipping_tax' ";
			//$query[] = " AND    order_shipping.meta_key ='_order_shipping' ";
			//$query[] = " AND    cart_discount_tax.meta_key ='_cart_discount_tax' ";
			//$query[] = " AND    cart_discount.meta_key ='_cart_discount' ";
			//$query[] = "	AND counpon_order_items.order_item_type ='coupon' ";
			//$query[] = "	AND order_items_shipping.order_item_type ='shipping' ";

			//$query[] = "	AND discount_amount.meta_key ='discount_amount' ";
			//$query[] = "	AND discount_amount_tax.meta_key ='discount_amount_tax' ";
			//$query[] = "	AND shipping_total_tax.meta_key ='total_tax' ";
			switch ($select_order) {
				case "today":
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
					break;
				case "yesterday":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY),%s)",'%Y-%m-%d', '%Y-%m-%d');
					break;
				case "last_7_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_10_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "last_30_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;
				case "last_60_days":
					$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
					break;  
				case "this_year":
					$query[] = $wpdb->prepare( " AND  YEAR(date_format( posts.date_created_gmt, %s)) = YEAR(date_format(CURDATE(),%s))", '%Y-%m-%d', '%Y-%m-%d');           
					break;      
				default:
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d',$today,$today);
			}
			
			$query[] = " GROUP BY posts.status  ";
			
				// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));

			//$this->print_data($wpdb );
			return $rows;
		}

		
		function get_columns(){
			$columns = array();
			$columns["order_status"] = esc_html__("Order Status","nisalesreport");
			$columns["order_count"] = esc_html__("Order Count","nisalesreport");
			
			
			$columns["order_shipping"] = esc_html__("Order Shipping","nisalesreport");
			$columns["order_shipping_tax"] = esc_html__("Order Shipping Tax","nisalesreport");
			
			
			$columns["cart_discount"] = esc_html__("Cart Discount","nisalesreport");
			$columns["cart_discount_tax"] = esc_html__("Cart Discount Tax","nisalesreport");
			
			
			$columns["order_tax"] = esc_html__("Order Tax","nisalesreport");
			
			$columns["order_total"] = esc_html__("Order Total","nisalesreport");
			
			return $columns;
		}
		function get_columns_hpos(){
			$columns = array();
			$columns["order_status"] = esc_html__("Order Status","nisalesreport");
			$columns["order_count"] = esc_html__("Order Count","nisalesreport");
			
			
			$columns["order_shipping"] = esc_html__("Order Shipping","nisalesreport");
		//	$columns["order_shipping_tax"] = esc_html__("Order Shipping Tax","nisalesreport");
			
			
		//	$columns["cart_discount"] = esc_html__("Cart Discount","nisalesreport");
		//	$columns["cart_discount_tax"] = esc_html__("Cart Discount Tax","nisalesreport");
			
			
			$columns["order_tax"] = esc_html__("Order Tax","nisalesreport");
			
			$columns["order_total"] = esc_html__("Order Total","nisalesreport");
			
			return $columns;
		}
		function get_tables(){
		//	$rows = $this->get_query();

		$rows =  array();
		if ($this->is_hpos_enable == true) {
			$rows = $this->get_query_hpos();
		} else {
			$rows = $this->get_query();
		}


		if ($this->is_hpos_enable == true) {
			$columns = $this->get_columns_hpos();
		}else{
			$columns = $this->get_columns();
		}

		
			//$this->print_data($rows);	
			//$this->print_data($columns);	
			$td_value = '';
			?>
            <table class="table table-striped table-hover">
            	 <thead class="shadow-sm p-3 mb-5 bg-white rounded">
                	<tr>
                        <?php foreach($columns  as $key=>$value): ?>
                        <th><?php echo esc_html($value); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
         
            <?php foreach($rows  as $row_key=>$row_value): ?>
            	<tr>
                    <?php 
					
					foreach($columns  as $col_key=>$col_value): ?>
                        <?php switch($col_key): case 1: break; ?>
                        
                        	
                            <?php case "order_status": ?>
                            <?php $td_vale =  ucfirst ( str_replace("wc-","", $row_value->order_status));   ?>
                            <?php break; ?>
                            
                        
                            <?php case "order_tax": ?>
							<?php case "cart_discount": ?>
                            <?php case "order_shipping_tax": ?>
                            <?php case "order_total": ?>
                            <?php case "order_shipping": ?>
                            <?php case "cart_discount_tax": ?>
                            <?php $td_class = "style=\"text-align:right\""; ?>
                            <?php $td_vale = wp_strip_all_tags(  wc_price(isset($row_value->$col_key)?$row_value->$col_key:"0")); ?>
                            <?php break; ?>
                            
                            <?php default; ?>
                             <?php $td_vale = isset($row_value->$col_key)?$row_value->$col_key:""; ?>
                        <?php endswitch; ?>
                         <?php $td_class = ""; ?>
                   <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                    <?php endforeach; ?>
                   
                </tr>
            <?php endforeach; ?>	
            </tbody>
              </table>
            <?php
		}
	}
}
?>