<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
include_once('report-function.php');  
if( !class_exists( 'OrderItem' ) ) {
	class OrderItem extends ReportFunction{
	var $is_hpos_enable = false;
  	public function __construct(){
		
	 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
	 
	
	}
	
	function ajax_call()
	{
		$ajax_function= $this->get_request("ajax_function");
		if($ajax_function=="order_item")
		{ ?>
          <div class="wrap">
          	<?php $this->display_order_item();?>
          </div>
          <?php	
		}
	}
	/*On Page Start Create The Form*/
	function create_form(){
	$today = date_i18n("Y-m-d");
	?>
	 <div class="container-fluid" id="niwoosalesreport">
		 <div class="row">
				
				<div class="col-md-12"  style="padding:0px;">
					<div class="card" style="max-width:70% ">
						<div class="card-header niwoosr-bg-c-purple">
							<?php esc_html_e('ORDER PRODUCT SALES REPORT ', 'nisalesreport'); ?>
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
								<div class="col-sm-2">
									<label for="order_no"><?php esc_html_e('Order No.', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									 <input id="order_no" name="order_no" type="text"  class="form-control" >
								</div>
								
							</div>
								<div class="form-group row">
								<div class="col-sm-2">
									<label for="billing_first_name"><?php esc_html_e('Billing First Name', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									<input id="billing_first_name" name="billing_first_name" type="text" class="form-control" >
								</div>
								<div class="col-sm-2">
									<label for="billing_email"><?php esc_html_e('Billing Email', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									 <input id="billing_email" name="billing_email" type="text" class="form-control">
								</div>
								
							</div>
                            
                            	<div class="form-group row">
								<div class="col-sm-2">
									<label for="order_by"><?php esc_html_e('Order By', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									<select id="order_by" name="order_by">
                                    	<option value="order_date"><?php esc_html_e("Order Date","nisalesreport"); ?></option>
                                        <option value="order_id"><?php esc_html_e("Order ID","nisalesreport"); ?></option>
                                        <option value="post_status"><?php esc_html_e("Order Status","nisalesreport"); ?></option>
                                    </select>
								</div>
								<div class="col-sm-2">
									<label for="sort"><?php esc_html_e('Sort', 'nisalesreport'); ?></label>
								</div>
								<div class="col-sm-4">
									<select name="sort" id="sort">
                                		<option value="<?php echo esc_attr("desc"); ?>"><?php esc_html_e("DESC","nisalesreport"); ?></option>
                                    	<option value="asc"><?php esc_html_e("ASC","nisalesreport"); ?></option>
                                    
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
	function display_order_item($content="DEFAULT"){  
		//echo $content;
		$item_total = 0;
		$tax_total  = 0;
		$qty		=0;
		$order_item=$this->get_order_item();
		
		$order_item =  apply_filters('ni_sales_report_order_product_report_rows', $order_item );	
		
		$columns = $this->get_sales_report_columns();
		
		//$billing_first_name  = $this->get_request("billing_first_name",'',true);
		//$billing_email		 = $this->get_request("billing_email",'',true);
		
		//$this->print_data($order_item);
		$columns_total = array();
		if(count($order_item)> 0){
			?>
            <?php if ($content=="DEFAULT"): ?>
            <div style="text-align:right;margin-bottom:10px">
           <form id="ni_frm_sales_order" action="" method="post">
    <input type="submit" value="Print" class="niwoosalesreport_button_form niwoosalesreport_button" name="btn_print" id="btn_print" />
    <input type="hidden" name="select_order" value="<?php echo esc_attr($this->get_request("select_order")); ?>" />
    <input type="hidden" name="order_no" value="<?php echo esc_attr($this->get_request("order_no")); ?>" />
    <input type="hidden" name="billing_first_name" value="<?php echo esc_attr($this->get_request("billing_first_name", '', true)); ?>" />
    <input type="hidden" name="billing_email" value="<?php echo esc_attr($this->get_request("billing_email", '', true)); ?>" />
</form>
            </div>
            <?php endif; ?>
            <?php //echo admin_url("post.php")."?action=edit&post=375"; ?>
           
			<table class="table table-striped table-hover">
            	<thead class="shadow-sm p-3 mb-5 bg-white rounded">
    <tr>
        <?php foreach($columns as $key => $value): ?>
            <th><?php echo esc_html($value); ?></th>
        <?php endforeach; ?>
    </tr>
</thead>
                <tbody>
           <?php
			foreach($order_item as $k => $v){
				
				//$this->print_data($v);
				$td_class = "";
				//$item_total += isset($v->line_total)?$v->line_total:0;
				//$tax_total 	+= isset($v->line_tax)?$v->line_tax:0;
			   // $qty 		+= isset($v->qty)?$v->qty:0;
			
				if (isset($columns_total["qty"])){
					
					$columns_total["qty"] += isset($v->qty)?$v->qty:0;
				}else{
					$columns_total["qty"] = isset($v->qty)?$v->qty:0;
				}
				if (isset($columns_total["line_total"])){
					$columns_total["line_total"] +=isset( $v->line_total)?$v->line_total:0;
				}else{
					$columns_total["line_total"] = isset($v->line_total)?$v->line_total:0;
				}
				if (isset($columns_total["line_tax"])){
					$columns_total["line_tax"] += isset($v->line_tax)?$v->line_tax:0;
				}else{
					$columns_total["line_tax"] = isset($v->line_tax)?$v->line_tax:0;
				}
				
				//$this->print_data($columns_total);
			}
			
			?>
            <?php foreach($order_item  as $row_key=>$row_value): ?>
            	<?php 
				
				$ahref_order_id = isset($row_value->order_id)?$row_value->order_id:0;
				$admin_url = admin_url("post.php")."?action=edit&post=".$ahref_order_id;
				?>
                <tr>
                    <?php foreach($columns  as $col_key=>$col_value): ?>
                        <?php switch($col_key): case 1: break; ?>
                        
                            <?php case "price": ?>
                            <?php $td_class = "style=\"text-align:right\""; ?>
                            <?php $td_vale = wp_strip_all_tags(wc_price($row_value->line_total/$row_value->qty));   ?>
                             <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                            <?php break; ?>
                            
                            <?php case "order_status": ?>
                            <?php $td_vale =  ucfirst ( str_replace("wc-","", $row_value->order_status));   ?>
                             <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                            <?php break; ?>
                            
							<?php case "billing_email": ?>
                            <?php $tmpbilling_email = isset($row_value->billing_email)?$row_value->billing_email:""; ?>
                            <?php $td_vale =  "<a href =\"mailto:{$tmpbilling_email}\">{$tmpbilling_email}</a>";   ?>
                            
                            
                           <td <?php echo esc_attr($td_class); ?>>
                                <a href="mailto:<?php echo esc_attr(sanitize_email($tmpbilling_email)); ?>">
                                    <?php echo esc_html(sanitize_email($tmpbilling_email)); ?>
                                </a>
                            </td>
                             
                             
                            <?php break; ?>
                            
                            <?php case "billing_country": ?>
                            <?php $td_vale = $this->get_country_name(isset($row_value->billing_country)?$row_value->billing_country:"") ;  ?>
                             <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                            <?php break; ?>
                            
                            <?php case "order_id": ?>
                            <?php $td_vale = "<a href=\"". esc_url($admin_url )."\" target=\"_blank\">". $row_value->order_id. "</a>"   ?>
                            
                           
                             <td <?php echo esc_attr($td_class); ?>><a href="<?php  echo esc_url($admin_url ) ?>"><?php  echo esc_attr( $row_value->order_id); ?></a> </td>
                            <?php break; ?>
                            
                            <?php case "line_tax": ?>
                            <?php case "line_total": ?>
                            <?php $td_class = "style=\"text-align:right\""; ?>
                            <?php $td_vale =  wp_strip_all_tags(wc_price(isset($row_value->$col_key)?$row_value->$col_key:"0")); ?>
                             <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                            <?php break; ?>
                            
                            <?php default; ?>
                             <?php $td_vale = isset($row_value->$col_key)?$row_value->$col_key:""; ?>
                              <td <?php echo esc_attr($td_class); ?>><?php echo esc_html($td_vale); ?></td>
                        <?php endswitch; ?>
                         <?php $td_class = ""; ?>
                    
                    <?php endforeach; ?>
                   
                </tr>
            <?php endforeach; ?>	
            </tbody>
              </table>
            	<div style="clear:both; padding-bottom:50px"></div>
                <table class="table table-striped table-hover">
                <thead class="shadow-sm p-3 mb-5 bg-white rounded">
                    <tr>
                        <th><?php esc_html_e('Quantity Total', 'nisalesreport'); ?></th> 
                        <th><?php esc_html_e('Line Tax Total', 'nisalesreport'); ?></th> 
                        <th><?php esc_html_e('Line Total', 'nisalesreport'); ?></th>     
                    </tr>
                </thead>
                <tbody>
                	<tr>
                    	<td><?php echo esc_html(isset($columns_total["qty"]) ? $columns_total["qty"] : 0); ?></td>
                       <td><?php echo esc_html(wp_strip_all_tags(wc_price(isset($columns_total["line_tax"]) ? $columns_total["line_tax"] : 0))); ?></td>
<td><?php echo esc_html(wp_strip_all_tags(wc_price(isset($columns_total["line_total"]) ? $columns_total["line_total"] : 0))); ?></td>
                    </tr>
                </tbody>
                </table>
           	<?php 
		}
	}
	function get_sales_report_columns(){
		$columns  =array();
		$columns["order_id"] =  __('#ID', 'nisalesreport');
		$columns["order_date"]		   =  __('Order Date', 'nisalesreport');
		$columns["billing_first_name"] =  __('First Name', 'nisalesreport');
		$columns["billing_email"] =  __('Email', 'nisalesreport');
		$columns["billing_country"] =  __('Country', 'nisalesreport');
		$columns["order_currency"] =  __('Currency', 'nisalesreport');
		$columns["payment_method_title"] =  __('Payment', 'nisalesreport');
		$columns["order_status"] =  __('Status', 'nisalesreport');
		$columns["order_item_name"] =  __('Product', 'nisalesreport');
		$columns["qty"] =  __('Quantity', 'nisalesreport');
		$columns["price"] =  __('Price', 'nisalesreport');
		$columns["line_tax"] =  __('Line Tax', 'nisalesreport');
		$columns["line_total"] =  __('Line Total', 'nisalesreport');
		
		return  apply_filters('ni_sales_report_order_product_report_columns', $columns );	
	}
	function get_order_item()
	{	
		
		if ($this->is_hpos_enable == true) {
			echo "dsadsa";
			$order_data =$this->get_query_data_hpos("DEFAULT");
		}else{
			echo "rtes";
			$order_data =$this->get_query_data("DEFAULT");
		}
		
		
		if(count($order_data)> 0){
			foreach($order_data as $k => $v){
				
				/*Order Data*/
				$order_id =$v->order_id;
				$order_detail = $this->get_order_detail($order_id);
				foreach($order_detail as $dkey => $dvalue)
				{
						$order_data[$k]->$dkey =$dvalue;
					
				}
				/*Order Item Detail*/
				$order_item_id = $v->order_item_id;
				$order_item_detail= $this->get_order_item_detail($order_item_id );
				foreach ($order_item_detail as $mKey => $mValue){
						$new_mKey = $str= ltrim ($mValue->meta_key, '_');
						$order_data[$k]->$new_mKey = $mValue->meta_value;		
				}
			}
		}
		else
		{
			esc_html_e("no record found","nisalesreport") ;
		}
		return $order_data;
	}
	
	function get_query_data_hpos($type="DEFAULT")
	{
		global $wpdb;	
		$today 				 = date_i18n("Y-m-d");
	    $select_order 		 = $this->get_request("select_order","today");
		$order_no			 = $this->get_request("order_no");
		$order_no 			 = $this->get_request("order_no");
		$billing_first_name  = $this->get_request("billing_first_name",'',true);
		$billing_email		 = $this->get_request("billing_email",'',true);
		
		
		$order_by 			 = $this->get_request("order_by");
		$sort 				 = $this->get_request("sort");
		
		
		$query   = array();
		$query[] = "SELECT
				posts.ID as order_id
				,posts.status as order_status
				,woocommerce_order_items.order_item_id as order_item_id
				, date_format( posts.date_created_gmt, '%Y-%m-%d') as order_date 
				,woocommerce_order_items.order_item_name
				,order_addresses.first_name as billing_first_name
				,order_addresses.email as billing_email
				,order_addresses.country as billing_country
				,posts.currency as order_currency
				,posts.payment_method_title as payment_method_title
				FROM {$wpdb->prefix}wc_orders as posts	";		
				$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID ";
				$query[] = "  LEFT JOIN  {$wpdb->prefix}wc_order_addresses as order_addresses ON order_addresses.order_id=posts.ID ";
				// if (strlen($billing_first_name)>0 && $billing_first_name!="" || strlen($billing_email)>0 && $billing_email!=""  ){
					
				// }
				// if (strlen($billing_email)>0 && $billing_email!="" ){
				// 		$query[] = " LEFT JOIN {$wpdb->prefix}postmeta as billing_email ON billing_email.post_id = posts.ID ";
				// }
				
				$query[] = "  WHERE 1 = 1";  
				$query[] = " AND	posts.type ='shop_order' ";
				$query[] = " AND	order_addresses.address_type ='billing' ";
				$query[] = "	AND woocommerce_order_items.order_item_type ='line_item' ";
				if (strlen($billing_first_name)>0 && $billing_first_name!="" ){
					//$query[] = " AND	billing_first_name.meta_key ='_billing_first_name' ";
					$query[] =" AND order_addresses.first_name LIKE '%{$billing_first_name}%'";	
				}
				if (strlen($billing_email)>0 && $billing_email!="" ){
					//$query[] = " AND billing_email.meta_key = '_billing_email'";	 
					$query[] = " AND order_addresses.email LIKE '%{$billing_email}%'";	
				}
				$query[] ="		AND posts.status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed' ,'wc-cancelled' ,  'wc-refunded' ,'wc-failed')";
						
				if ($order_no){
					$query[] =" AND   posts.ID = '{$order_no}'";
				}		
				//$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";		
					//AND DATE_ADD(CURDATE(), INTERVAL 1 day)	
				 switch ($select_order) {
					case "today":
						//$query[] = " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
						$query[] = $wpdb->prepare( "  AND   date_format( posts.date_created_gmt, %s ) BETWEEN  %s AND %s ",  '%Y-%m-%d',$today, $today);
						break;
					case "yesterday":
						$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), %s)", '%Y-%m-%d','%Y-%m-%d');
						break;
					case "last_7_days":
						$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;
					case "last_10_days":
						//$query[] =" AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
						$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;	
					case "last_15_days":
						//$query[] = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY), '%Y-%m-%d') AND   '{$today}' ";
						$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;		
					case "last_30_days":
							//$query[] = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
							$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
					 case "last_60_days":
							//$query[] =" AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
							$query[] = $wpdb->prepare( " AND  date_format( posts.date_created_gmt, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;	
					case "this_year":
						$query[] = $wpdb->prepare( " AND  YEAR(date_format( posts.date_created_gmt, %s )) = YEAR(date_format(CURDATE(), %s))",'%Y-%m-%d','%Y-%m-%d');			
						break;		
					default:
						$query[] = $wpdb->prepare( "  AND   date_format( posts.date_created_gmt, %s ) BETWEEN  %s AND %s ",  '%Y-%m-%d',$today, $today);
			}
			
			
			switch ($order_by) {
			  case "order_id":
				$query[] = $wpdb->prepare( "  order by posts.ID  %s " , $sort) ;	
				break;
			 case "order_date":
				//$query[] = $wpdb->prepare( "  order by  date_format( posts.post_date, %s ) %s ",  '%Y-%m-%d',  $sort);	
				$query[] = "ORDER BY date_format(posts.date_created_gmt, '%Y-%m-%d') $sort";
				 //$query[] =  $wpdb->prepare( " ORDER BY date_format(posts.post_date, '%Y-%m-%d') %s ", $sort);
				break;	
			  case "post_status":
					$query[] = $wpdb->prepare( "  order by  posts.status %s " , $sort) ;	
				break;
			  default:
			  
			  	$query[] = "order by posts.date_created_gmt DESC ";	
				
			}
			
			
			
				
		 if ($type=="ARRAY_A") /*Export*/{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_results(implode( ' ', $query ), ARRAY_A );
		 }
		 if($type=="DEFAULT") /*default*/{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_results( implode( ' ', $query ));	
		 }
		 if($type=="COUNT") /*Count only*/	{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_var(implode( ' ', $query ));
		 }
			//echo $query;
			//echo mysql_error();
			
			//$this->print_data( $results);
			
		return $results;	
	}
	function get_query_data($type="DEFAULT")
	{
		global $wpdb;	
		$today 				 = date_i18n("Y-m-d");
	    $select_order 		 = $this->get_request("select_order","today");
		$order_no			 = $this->get_request("order_no");
		$order_no 			 = $this->get_request("order_no");
		$billing_first_name  = $this->get_request("billing_first_name",'',true);
		$billing_email		 = $this->get_request("billing_email",'',true);
		
		
		$order_by 			 = $this->get_request("order_by");
		$sort 				 = $this->get_request("sort");
		
		
		$query   = array();
		$query[] = "SELECT
				posts.ID as order_id
				,posts.post_status as order_status
				,woocommerce_order_items.order_item_id as order_item_id
				, date_format( posts.post_date, '%Y-%m-%d') as order_date 
				,woocommerce_order_items.order_item_name
				FROM {$wpdb->prefix}posts as posts	";		
				$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID ";
				
				if (strlen($billing_first_name)>0 && $billing_first_name!="" ){
					$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as billing_first_name ON billing_first_name.post_id=posts.ID ";
				}
				if (strlen($billing_email)>0 && $billing_email!="" ){
						$query[] = " LEFT JOIN {$wpdb->prefix}postmeta as billing_email ON billing_email.post_id = posts.ID ";
				}
				
				$query[] = "  WHERE 1 = 1";  
				$query[] = " AND	posts.post_type ='shop_order' ";
				$query[] = "	AND woocommerce_order_items.order_item_type ='line_item' ";
				if (strlen($billing_first_name)>0 && $billing_first_name!="" ){
					$query[] = " AND	billing_first_name.meta_key ='_billing_first_name' ";
					$query[] =" AND billing_first_name.meta_value LIKE '%{$billing_first_name}%'";	
				}
				if (strlen($billing_email)>0 && $billing_email!="" ){
					$query[] = " AND billing_email.meta_key = '_billing_email'";	 
					$query[] = " AND billing_email.meta_value LIKE '%{$billing_email}%'";	
				}
				$query[] ="		AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed' ,'wc-cancelled' ,  'wc-refunded' ,'wc-failed')";
						
				if ($order_no){
					$query[] =" AND   posts.ID = '{$order_no}'";
				}		
				//$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";		
					//AND DATE_ADD(CURDATE(), INTERVAL 1 day)	
				 switch ($select_order) {
					case "today":
						//$query[] = " AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
						$query[] = $wpdb->prepare( "  AND   date_format( posts.post_date, %s ) BETWEEN  %s AND %s ",  '%Y-%m-%d',$today, $today);
						break;
					case "yesterday":
						$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY), %s)", '%Y-%m-%d','%Y-%m-%d');
						break;
					case "last_7_days":
						$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;
					case "last_10_days":
						//$query[] =" AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
						$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;	
					case "last_15_days":
						//$query[] = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY), '%Y-%m-%d') AND   '{$today}' ";
						$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 15 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;		
					case "last_30_days":
							//$query[] = " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
							$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
					 case "last_60_days":
							//$query[] =" AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
							$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, %s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ",'%Y-%m-%d', '%Y-%m-%d',$today);
						break;	
					case "this_year":
						$query[] = $wpdb->prepare( " AND  YEAR(date_format( posts.post_date, %s )) = YEAR(date_format(CURDATE(), %s))",'%Y-%m-%d','%Y-%m-%d');			
						break;		
					default:
						$query[] = $wpdb->prepare( "  AND   date_format( posts.post_date, %s ) BETWEEN  %s AND %s ",  '%Y-%m-%d',$today, $today);
			}
			
			
			switch ($order_by) {
			  case "order_id":
				$query[] = $wpdb->prepare( "  order by posts.ID  %s " , $sort) ;	
				break;
			 case "order_date":
				//$query[] = $wpdb->prepare( "  order by  date_format( posts.post_date, %s ) %s ",  '%Y-%m-%d',  $sort);	
				$query[] = "ORDER BY date_format(posts.post_date, '%Y-%m-%d') $sort";
				 //$query[] =  $wpdb->prepare( " ORDER BY date_format(posts.post_date, '%Y-%m-%d') %s ", $sort);
				break;	
			  case "post_status":
					$query[] = $wpdb->prepare( "  order by  posts.post_status %s " , $sort) ;	
				break;
			  default:
			  
			  	$query[] = "order by posts.post_date DESC ";	
				
			}
			
			
			
				
		 if ($type=="ARRAY_A") /*Export*/{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_results(implode( ' ', $query ), ARRAY_A );
		 }
		 if($type=="DEFAULT") /*default*/{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_results( implode( ' ', $query ));	
		 }
		 if($type=="COUNT") /*Count only*/	{
			 // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		 	$results = $wpdb->get_var(implode( ' ', $query ));
		 }
			//echo $query;
			//echo mysql_error();
			
			//$this->print_data( $results);
			
		return $results;	
	}
	function get_order_item_detail($order_item_id)
	{
		global $wpdb;
			$query = array();
			$query[] = " SELECT
				* FROM {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta			
				WHERE ";
				
			$query[] = $wpdb->prepare( "   order_item_id = %s ",$order_item_id);
				
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared	
		$results = $wpdb->get_results(implode( ' ', $query ));
		return $results;			
	}
	function get_order_detail($order_id)
	{
		$order_detail	= get_post_meta($order_id);
		$order_detail_array = array();
		foreach($order_detail as $k => $v)
		{
			$k =substr($k,1);
			$order_detail_array[$k] =$v[0];
		}
		return 	$order_detail_array;
	}
	function get_print_content(){
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Print</title>
    <link rel='stylesheet' id='sales-report-style-css-bootstrap'  href='<?php echo esc_url( plugins_url( '../assets/css/bootstrap/bootstrap.min.css', __FILE__ ) ); ?>' type='text/css' media='all' />
    <link rel='stylesheet' id='sales-report-style-css'  href='<?php echo esc_url( plugins_url( '../assets/css/niwoosalesreport-style-new.css', __FILE__ ) ); ?>' type='text/css' media='all' />
</head>
		
		<body>
         <div class="container-fluid" id="niwoosalesreport">
			<?php 
				 $this->display_order_item("PRINT");
			?>
		  <div class="print_hide" style="text-align:right; margin-top:15px"><input type="button" value="Back" onClick="window.history.go(-1)" class="niwoosalesreport_button_form niwoosalesreport_button"> <input type="button" class="niwoosalesreport_button_form niwoosalesreport_button" value="Print this page" onClick="window.print()">	</div>
		 </div>
		</body>
		</html>

	<?php
	}
}
}
?>