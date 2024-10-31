<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
include_once('report-function.php');  
	if( !class_exists( 'Ni_Analytical_Sales_Report' ) ) {
		class Ni_Analytical_Sales_Report extends ReportFunction{
			var $is_hpos_enable = false;
  			function __construct(){
				 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
			}
			
			function page_init(){
				
			$today = date_i18n("Y-m-d");
			//$sales_year =  $this->get_sales_year();

			if ($this->is_hpos_enable == true) {
				$sales_year =  $this->get_sales_year_hpos();
			} else {
				$sales_year =  $this->get_sales_year();
			}

			//$this->print_data($sales_year);
			?>
			<div class="container-fluid" id="niwoosalesreport">
			 <div class="row">
					
					<div class="col-md-12"  style="padding:0px;">
						<div class="card" style="max-width:70% ">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Current Year vs Previous Year Sales', 'nisalesreport'); ?>
							</div>
							<div class="card-body">
								  <form id="frmOrderItem" method="post" >
									<div class="form-group row">
									<div class="col-sm-2">
										<label for="selected_year"><?php esc_html_e('Year', 'nisalesreport'); ?></label>
									</div>
									<div class="col-sm-4">
										<select name="selected_year" id="selected_year" class="form-control">
											<?php foreach($sales_year as $key => $value): ?>
												<option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($value, 'nisalesreport'); ?></option>
											<?php endforeach; ?>
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
									<input type="hidden" name="page" id="page" value="<?php echo esc_attr(isset($_REQUEST["page"]) ? $_REQUEST["page"] : ''); ?>" />	
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
			
			function get_query_hpos(){
				//$current_year = 2022;
			    //$previous_year = $current_year -1;
				
				$current_year		 = $this->get_request("selected_year",date_i18n("Y"));
				$previous_year = $current_year -1;
				
				global $wpdb;	
				$query   = array();
				$query[] = " SELECT ";
				$query[] = $wpdb->prepare( " date_format( posts.date_created_gmt, %s) as order_date", '%Y-%m');
				$query[] = $wpdb->prepare(", ROUND(SUM(posts.total_amount),2) as order_total ");
				
				
				$query[] = " FROM {$wpdb->prefix}wc_orders as posts	";
				
				//$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
				
				$query[] = "  WHERE 1 = 1";  
				$query[] = " AND	posts.type ='shop_order' ";
				//$query[] = " AND	order_total.meta_key ='_order_total' ";
				
				$query[] = $wpdb->prepare( " AND date_format( posts.date_created_gmt, %s) BETWEEN  %s AND  %s",'%Y',$previous_year,$current_year);
				
				$query[] = "  GROUP By  date_format( posts.date_created_gmt, '%Y-%m') ";
					
					// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$rows = $wpdb->get_results( implode( ' ', $query ));
				return $rows;
			}
			function get_query(){
				//$current_year = 2022;
			    //$previous_year = $current_year -1;
				
				$current_year		 = $this->get_request("selected_year",date_i18n("Y"));
				$previous_year = $current_year -1;
				
				global $wpdb;	
				$query   = array();
				$query[] = " SELECT ";
				$query[] = $wpdb->prepare( " date_format( posts.post_date, %s) as order_date", '%Y-%m');
				$query[] = $wpdb->prepare(", ROUND(SUM(order_total.meta_value),2) as order_total ");
				
				
				$query[] = " FROM {$wpdb->prefix}posts as posts	";
				
				$query[] = "  LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
				
				$query[] = "  WHERE 1 = 1";  
				$query[] = " AND	posts.post_type ='shop_order' ";
				$query[] = " AND	order_total.meta_key ='_order_total' ";
				
				$query[] = $wpdb->prepare( " AND date_format( posts.post_date, %s) BETWEEN  %s AND  %s",'%Y',$previous_year,$current_year);
				
				$query[] = "  GROUP By  date_format( posts.post_date, '%Y-%m') ";
					
					// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$rows = $wpdb->get_results( implode( ' ', $query ));
				return $rows;
			}
			
			
			function get_month_name(){
				$month_name = array(); 
				$month_name["01"] = esc_html__("January","nisalesreport");
				$month_name["02"] = esc_html__("February","nisalesreport");
				$month_name["03"] = esc_html__("March","nisalesreport");
				$month_name["04"] = esc_html__("April","nisalesreport");
				$month_name["05"] = esc_html__("May","nisalesreport");
				$month_name["06"] = esc_html__("June","nisalesreport");
				$month_name["07"] = esc_html__("July","nisalesreport");
				$month_name["08"] = esc_html__("August","nisalesreport");
				$month_name["09"] = esc_html__("September","nisalesreport");
				$month_name["10"] = esc_html__("October","nisalesreport");
				$month_name["11"] = esc_html__("November","nisalesreport");
				$month_name["12"] = esc_html__("December","nisalesreport");
				
				return $month_name;
	
			}
			function get_columns(){
				$current_year		 = $this->get_request("selected_year",date_i18n("Y"));
				$previous_year = $current_year -1;
				
				$column["month"] = esc_html__("Month","nisalesreport");
				$column[$current_year] =$current_year;
				$column[$previous_year] =$previous_year;
				
				return $column;
			}
			function get_tables(){
				$rows 	= array();
				$columns 		= $this->get_columns();


				//$rows 			= $this->get_query();
				if ($this->is_hpos_enable == true) {
					$rows 			= $this->get_query_hpos();
				} else {
					$rows 			= $this->get_query();
				}
				
				$month_name 	= $this->get_month_name();
				
				$rows_month_year = array();
				
				foreach($rows as $key=>$value){
					$rows_month_year[$value->order_date] = $value;
				}
				
				//echo $rows_month_year["2021-01"]->order_total;
				
				//$this->print_data($rows);
				//$this->print_data($rows_month_year);
				//$this->print_data($month_name);
				//$this->print_data($columns);
				
				
				?>
                <table class="table">
               		<thead>
    <tr>
        <?php foreach($columns as $col_key => $col_value): ?>
            <th><?php echo esc_html($col_value); ?></th>
        <?php endforeach; ?>
    </tr>
</thead>
               		<tbody>
    <?php foreach($month_name as $row_key => $row_value): ?>
        <tr>
            <?php foreach($columns as $col_key => $col_value): ?>
                <?php switch($col_key): case 1: break; ?>

                    <?php case "month": ?>
                        <td><?php echo esc_html($row_value); ?></td>
                    <?php break; ?>

                    <?php default: ?>
                        <?php $year_month_key = $col_key.'-'.$row_key; ?>     
                        <td><?php echo esc_html(wp_strip_all_tags( wc_price(isset($rows_month_year[$year_month_key]) ? $rows_month_year[$year_month_key]->order_total : 0))); ?></td>
                <?php endswitch; ?>   
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