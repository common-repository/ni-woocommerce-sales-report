<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
include_once('report-function.php');
if( !class_exists( 'Ni_Top_Product_Report' ) ) { 
	class Ni_Top_Product_Report extends ReportFunction{
		var $is_hpos_enable = false;
		public function __construct(){
			 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
		}
		function page_init(){
			
			$product_type =	isset($_REQUEST["top_product"])?$_REQUEST["top_product"] : 'today_top_product';
			$page =	isset($_REQUEST["page"])?$_REQUEST["page"] : '';
			$page_titles 				= array(
					'today_top_product'			=> __('Today Top Product',		'nisalesreportpro')
					,'yesterday_top_product'		 	=> __('Yesterday Top Product',	'nisalesreportpro')
					,'last_7_days_top_product'		=> __('Last 7 Days Top Product',	'nisalesreportpro')				
			);
			?>
              <div class="container-fluid" id="niwoosalesreport">
            <h2 class="nav-tab-wrapper woo-nav-tab-wrapper hide_for_print">
			<div class="responsive-menu"><a href="#" id="menu-icon"></a></div>
			<?php            	
foreach ($page_titles as $key => $value) {
    echo '<a href="' . esc_url(admin_url('admin.php?page=' . $page . '&top_product=' . urlencode($key))) . '" class="nav-tab ';
    if ($product_type == $key) echo 'nav-tab-active';
    echo '">' . esc_html($value) . '</a>';
}
?>
			</h2>
			<div style="margin:5px;">
            
            	<?php //$this->get_top_product(); ?>
            </div>
            <div class="row" >
            	<div class="col-md-12"  style="padding:0px;">
         			<!-- <div class="card"> -->
                      
                      <div class="card-body "> 
                        <div class="row">
                        	<div class="table-responsive niwoosr-table">
								<?php $this->get_top_product(); ?>
                            </div>
                           
                        </div>
						</div>
                      
                    </div>       	
                </div>
            </div>
            </div>
			<?php
			
			
		}
		function get_top_product_columns(){
			$column = array();
			$column["order_item_name"] = __('Product Name', 'nisalesreport');
			$column["qty"] = __('Product Quantity', 'nisalesreport');
			$column["line_total"] = __('Line Total', 'nisalesreport');
			return $column;
		}
		function get_top_product_query(){
			global $wpdb;	
			 $product_type =	isset($_REQUEST["top_product"])?$_REQUEST["top_product"] : 'today_top_product';
			 $today 				 = date_i18n("Y-m-d");
		     $yesterday			 	 = date_i18n("Y-m-d",strtotime("-1 days"));
			 $last_7_days 		 	 = date_i18n('Y-m-d', strtotime('-7 days'));
			
			$query   = array();
			 $query[] =  " SELECT ";
 		
			 $query[] =  "		order_items.order_item_name";
			 $query[] =  "		,product_id.meta_value as  product_id";
			 $query[] =  "		,variation_id.meta_value as  variation_id";
			 $query[] =  "		,SUM(line_total.meta_value) as  line_total";
			 $query[] =  "		,SUM(qty.meta_value) as  qty";
			 $query[] =  "		FROM {$wpdb->prefix}posts as posts	";		
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  WHERE 1 = 1";  
				 $query[] =  " AND	posts.post_type ='shop_order' ";
				 $query[] =  "	AND order_items.order_item_type ='line_item' ";
				
				 $query[] =  "	AND product_id.meta_key ='_product_id' ";
				 $query[] =  "	AND variation_id.meta_key ='_variation_id' ";
				 $query[] =  "	AND line_total.meta_key ='_line_total' ";
				 $query[] =  "	AND qty.meta_key ='_qty' ";
				
				if ("today_top_product" == $product_type ){
					$query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ",'%Y-%m-%d',$today,$today);
					 $query[] = " GROUP BY 	 product_id.meta_value, variation_id.meta_value	 ";
				}
				if ("yesterday_top_product" == $product_type ){
					$query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN  %s AND  %s ",'%Y-%m-%d',$yesterday,$yesterday);
					 $query[] =  " GROUP BY product_id.meta_value, variation_id.meta_value	 ";
				}
				if ("last_7_days_top_product" == $product_type ){
					  $query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ",'%Y-%m-%d',$last_7_days,$today);
					 $query[] =  " GROUP BY 	product_id.meta_value, variation_id.meta_value	 ";
				}
				 $query[] =  "order by SUM(line_total.meta_value) DESC ";	
				 $query[] =  " LIMIT 10";
				
				
				 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
					$rows = $wpdb->get_results( implode( ' ', $query ));
				
				//$this->print_data($results);
				return $rows;
		}
		function get_top_product_query_hpos(){
			global $wpdb;	
			 $product_type =	isset($_REQUEST["top_product"])?$_REQUEST["top_product"] : 'today_top_product';
			 $today 				 = date_i18n("Y-m-d");
		     $yesterday			 	 = date_i18n("Y-m-d",strtotime("-1 days"));
			 $last_7_days 		 	 = date_i18n('Y-m-d', strtotime('-7 days'));
			
			$query   = array();
			 $query[] =  " SELECT ";
 		
			 $query[] =  "		order_items.order_item_name";
			 $query[] =  "		,product_id.meta_value as  product_id";
			 $query[] =  "		,variation_id.meta_value as  variation_id";
			 $query[] =  "		,SUM(line_total.meta_value) as  line_total";
			 $query[] =  "		,SUM(qty.meta_value) as  qty";
			 $query[] =  "		FROM {$wpdb->prefix}wc_orders as posts	";		
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";
				
				 $query[] =  "  WHERE 1 = 1";  
				 $query[] =  " AND	posts.type ='shop_order' ";
				 $query[] =  "	AND order_items.order_item_type ='line_item' ";
				
				 $query[] =  "	AND product_id.meta_key ='_product_id' ";
				 $query[] =  "	AND variation_id.meta_key ='_variation_id' ";
				 $query[] =  "	AND line_total.meta_key ='_line_total' ";
				 $query[] =  "	AND qty.meta_key ='_qty' ";
				
				if ("today_top_product" == $product_type ){
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ",'%Y-%m-%d',$today,$today);
					 $query[] = " GROUP BY 	 product_id.meta_value, variation_id.meta_value	 ";
				}
				if ("yesterday_top_product" == $product_type ){
					$query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN  %s AND  %s ",'%Y-%m-%d',$yesterday,$yesterday);
					 $query[] =  " GROUP BY product_id.meta_value, variation_id.meta_value	 ";
				}
				if ("last_7_days_top_product" == $product_type ){
					  $query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ",'%Y-%m-%d',$last_7_days,$today);
					 $query[] =  " GROUP BY 	product_id.meta_value, variation_id.meta_value	 ";
				}
				 $query[] =  "order by SUM(line_total.meta_value) DESC ";	
				 $query[] =  " LIMIT 10";
				
				
				 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
					$rows = $wpdb->get_results( implode( ' ', $query ));
				
				//$this->print_data($results);
				return $rows;
		}


		function get_top_product(){
			$rows =array();
			$columns = $this->get_top_product_columns();
			//$rows = $this->get_top_product_query();

			if ($this->is_hpos_enable == true) {
				$rows = $this->get_top_product_query_hpos();
			} else {
				$rows = $this->get_top_product_query();
			}

			
			?>
           
            
             <table class="table table-striped table-hover">
    <thead class="shadow-sm p-3 mb-5 bg-white rounded">
        <tr>
            <?php foreach($columns as $col_key => $col_value): ?>
                <th><?php echo esc_html($col_value); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (count($rows) == 0): ?>
            <tr>
                <td colspan="<?php echo count($columns); ?>" style="text-align:left; font-size:16px"><?php esc_html_e('No product found', 'nisalesreport'); ?></td>
            </tr>
        <?php endif; ?>
        <?php foreach($rows as $row_key => $row_value): ?>
           <tr>
				<?php foreach($columns as $col_key => $col_value): ?>
                    <?php 
                    $td_value = isset($row_value->$col_key) ? $row_value->$col_key : ""; 
                    ?>
                    <td>
                    	<?php if ("line_total" === $col_key): ?>
                        	
                            <?php echo esc_html(wp_strip_all_tags( wc_price( $td_value))); ?>
                        <?php else: ?>
                            <?php echo esc_html($td_value); ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>
            <?php
		}
	}
}
