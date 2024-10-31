<?php
if (!defined('ABSPATH')) {
    exit;
}
include_once('report-function.php');
if (!class_exists('Ni_Product_Analysis_Report')) {
    class Ni_Product_Analysis_Report extends ReportFunction
    {
        var $is_hpos_enable = false;
        public function __construct()
        {
			 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
        }
        function get_ajax()
        {
            $product_id  = $_REQUEST["product_id"];
            $variation_id  = $_REQUEST["variation_id"];


            $ajax_function = $_REQUEST["ajax_function"];
            if ($ajax_function==="display_order_product_info"){
                $this->get_product_data($product_id, $variation_id);
 
              die;
            }

          
        }
        function page_init()
        {
            $current_year = wp_date("Y");
            $previous_year = wp_date("Y", strtotime("-1 year"));

         //   $current_rows =  $this->get_query($current_year);
           // $previous_rows =  $this->get_query($previous_year);

            if ($this->is_hpos_enable == true) {
                $current_rows =  $this->get_query_hpos($current_year);
                $previous_rows =  $this->get_query_hpos($previous_year);
            } else {
                $current_rows =  $this->get_query($current_year);
                $previous_rows =  $this->get_query($previous_year);
            }
            
            //$this->print_data(  $current_rows );
            ?>
            <div class="container-fluid" id="niwoosalesreport">
                <div class="row">

                    <div class="col-md-12" style="padding:0px;">
                        <div class="card" style="max-width:70% ">
                            <div class="card-header niwoosr-bg-c-purple">
                                <?php esc_html_e('Product Analysis Report', 'nisalesreport'); ?>
                            </div>
                            <div class="card-body" style="display: none">

                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12" style="padding:0px;">
                        <div class="card">

                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="table-responsive niwoosr-table">
                                            <?php $this->get_table($previous_rows, $current_rows,$current_year,$previous_year); ?>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="table-responsive niwoosr-table">
                                            <div class="_data_product_information"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        <?php
        }
       
        function get_table($previous_rows = array(), $current_rows = array(),$current_year_no=0, $previous_year_no=0)
        {

        
            $data_previous = array();
            $data_current = array();
            foreach ($previous_rows   as $pre_key => $pre_value) {
                // $this->print_data($pre_value);

                $uniq_id = $pre_value->product_id . "_" . $pre_value->variation_id;
                $data_previous[$uniq_id] = $pre_value;
            }
            



            /* Current*/
            foreach ($current_rows   as $cur_key => $cur_value) {
                // $this->print_data($pre_value);

                $uniq_id = $cur_value->product_id . "_" . $cur_value->variation_id;
                $data_current[$uniq_id] = $cur_value;
            }
            // $this->print_data($current_rows);


        ?>
           <table class="table">
    <thead>
        <tr>
            <td>Product Name</td>
            <td>Current Year (<?php echo esc_html($current_year_no); ?>)</td>
            <td>Previous Year (<?php echo esc_html($previous_year_no); ?>)</td>
            <td>Percentage (%)</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_current as $cur_key => $cur_value): ?>
            <?php
            $cur_year_total = isset($cur_value->line_total) ? $cur_value->line_total : 0;
            $current_year_object = $this->get_current_year_data($data_previous, $cur_key);
            $pre_year_total = isset($current_year_object->line_total) ? $current_year_object->line_total : 0;

            if ($pre_year_total > 0) {
                $percentage_total = (($cur_year_total - $pre_year_total) / $pre_year_total) * 100;
            } else {
                $percentage_total = 0;
            }

            $arrow = ($percentage_total < -1) ? '<i class="fa fa-arrow-down text-danger" aria-hidden="true"></i>' : '<i class="fa fa-arrow-up text-success" aria-hidden="true"></i>';
            ?>
            <tr>
                <td><a href="#" class="_display_order_product_info" data-product_id="<?php echo esc_attr($cur_value->product_id); ?>" data-variation_id="<?php echo esc_attr($cur_value->variation_id); ?>"><?php echo esc_html($cur_value->order_item_name); ?></a></td>
                <td><?php echo esc_html(wp_strip_all_tags( $this->get_price($cur_year_total))); ?></td>
                <td><?php echo esc_html(wp_strip_all_tags( $this->get_price($pre_year_total))); ?></td>
               <td><?php echo esc_html(round($percentage_total, 2)) . " " . esc_html(wp_strip_all_tags( $arrow)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        <?php


        }
        function get_current_year_data($current_year_data = array(), $pre_key = '')
        {
            $found_object =   new stdClass();
            if (array_key_exists($pre_key, $current_year_data)) {
                $found_object  =   $current_year_data[$pre_key];
            }

            return $found_object;
        }
       	function get_query($year_no = '')
        {
            global $wpdb;

			$query   = array();
            $query[] = " SELECT ";
            $query[] = "	order_items.order_item_name";
            $query[] = "	,product_id.meta_value as  product_id";
            $query[] = "	,variation_id.meta_value as  variation_id";
            $query[] = "	,Round(SUM(line_total.meta_value),2) as  line_total";
            $query[] = "		,SUM(qty.meta_value) as  qty";
            $query[] = "	FROM {$wpdb->prefix}posts as posts	";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";

            $query[] = "  WHERE 1 = 1";
            $query[] = " AND	posts.post_type ='shop_order' ";
            $query[] = "	AND order_items.order_item_type ='line_item' ";

           $query[] = "	AND product_id.meta_key ='_product_id' ";
            $query[] = "	AND variation_id.meta_key ='_variation_id' ";
            $query[] = "	AND line_total.meta_key ='_line_total' ";
           $query[] = "	AND qty.meta_key ='_qty' ";

            if ($year_no !== '') {
               $query[] = $wpdb->prepare( " AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ",'%Y',$year_no,$year_no);
            }


           $query[] = "  GROUP By  product_id ,  variation_id ";
           $query[] = " order by SUM(line_total.meta_value) DESC ";
           $query[] = " LIMIT 20 ";
           

           // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));
			return $rows;
        }
        function get_query_hpos($year_no = '')
        {
            global $wpdb;

			$query   = array();
            $query[] = " SELECT ";
            $query[] = "	order_items.order_item_name";
            $query[] = "	,product_id.meta_value as  product_id";
            $query[] = "	,variation_id.meta_value as  variation_id";
            $query[] = "	,Round(SUM(line_total.meta_value),2) as  line_total";
            $query[] = "		,SUM(qty.meta_value) as  qty";
            $query[] = "	FROM {$wpdb->prefix}wc_orders as posts	";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";

            $query[] = "  WHERE 1 = 1";
            $query[] = " AND	posts.type ='shop_order' ";
            $query[] = "	AND order_items.order_item_type ='line_item' ";

           $query[] = "	AND product_id.meta_key ='_product_id' ";
            $query[] = "	AND variation_id.meta_key ='_variation_id' ";
            $query[] = "	AND line_total.meta_key ='_line_total' ";
           $query[] = "	AND qty.meta_key ='_qty' ";

            if ($year_no !== '') {
               $query[] = $wpdb->prepare( " AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ",'%Y',$year_no,$year_no);
            }


           $query[] = "  GROUP By  product_id ,  variation_id ";
           $query[] = " order by SUM(line_total.meta_value) DESC ";
           $query[] = " LIMIT 20 ";
           

           // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));
			return $rows;
        }
        function get_product_sales_query($product_id = 0, $variation_id = 0)
        {
            $rows  = array();
            global $wpdb;
			$query   = array();
            $query[] = "SELECT ";
            $query[] = "		order_items.order_item_name";
            $query[] = "	,product_id.meta_value as  product_id";
            $query[] = "		,variation_id.meta_value as  variation_id";
            // $query .= "		,Round(SUM(line_total.meta_value),2) as  line_total";
            // $query .= "		,SUM(qty.meta_value) as  qty";
            $query[] = "	, date_format( posts.post_date, '%Y-%m-%d') as order_date ";
            $query[] = "		, date_format( posts.post_date, '%Y') as order_year ";
            $query[] = "		, date_format( posts.post_date, '%m') as order_month ";
            $query[] = "		,line_total.meta_value as  line_total";
            $query[] = "		,qty.meta_value as  qty";
            $query[] = "		,posts.post_status as  order_status";

            $query[] = "	FROM {$wpdb->prefix}posts as posts	";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";

            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
            $query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";

             $query[] = "  WHERE 1 = 1";
            $query[] = " AND	posts.post_type ='shop_order' ";
              $query[] = "	AND order_items.order_item_type ='line_item' ";

              $query[] = "	AND product_id.meta_key ='_product_id' ";
             $query[] = "	AND variation_id.meta_key ='_variation_id' ";
              $query[] = "	AND line_total.meta_key ='_line_total' ";
              $query[] = "AND qty.meta_key ='_qty' ";


            $query[] = $wpdb->prepare( " AND   product_id.meta_value = %s", $product_id);
            $query[] = $wpdb->prepare( " AND   variation_id.meta_value = %s",$variation_id);


           // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results( implode( ' ', $query ));
			return $rows;
        }
		function get_product_sales_query1($product_id = 0, $variation_id = 0)
        {
            $rows  = array();
            global $wpdb;
            $query = " SELECT ";
            $query .= "		order_items.order_item_name";
            $query .= "		,product_id.meta_value as  product_id";
            $query .= "		,variation_id.meta_value as  variation_id";
            // $query .= "		,Round(SUM(line_total.meta_value),2) as  line_total";
            // $query .= "		,SUM(qty.meta_value) as  qty";
            $query .= "		, date_format( posts.post_date, '%Y-%m-%d') as order_date ";
            $query .= "		, date_format( posts.post_date, '%Y') as order_year ";
            $query .= "		, date_format( posts.post_date, '%m') as order_month ";
            $query .= "		,line_total.meta_value as  line_total";
            $query .= "		,qty.meta_value as  qty";
            $query .= "		,posts.post_status as  order_status";

            $query .= "		FROM {$wpdb->prefix}posts as posts	";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";
            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as variation_id ON variation_id.order_item_id=order_items.order_item_id ";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";

            $query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=order_items.order_item_id ";

            $query .= "  WHERE 1 = 1";
            $query .= " AND	posts.post_type ='shop_order' ";
            $query .= "	AND order_items.order_item_type ='line_item' ";

            $query .= "	AND product_id.meta_key ='_product_id' ";
            $query .= "	AND variation_id.meta_key ='_variation_id' ";
            $query .= "	AND line_total.meta_key ='_line_total' ";
            $query .= "	AND qty.meta_key ='_qty' ";


            $query .= " AND   product_id.meta_value = '{$product_id}'";
            $query .= " AND   variation_id.meta_value = '{$variation_id}'";


           // $rows = $wpdb->get_results($query);

            //$this->print_data($rows);

            return $rows;
        }
        public function get_product_data($product_id, $variation_id)
        {
            $rows = $this->get_product_sales_query($product_id, $variation_id);

            $product_order_status = $this->get_product_order_status($rows);
            // $this->print_data($product_order_status);

            $product_order_year = $this->get_product_by_order_year($rows);
            //  $this->print_data($product_order_year);



        ?>
            <div class="row">
    <div class="col-5">
        <table class="table table-striped table-hover">
            <thead class="shadow-sm p-3 mb-5 bg-white rounded">
                <tr>
                    <td>Status</td>
                    <td>Order Count</td>
                    <td>Product Total</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_order_status as $key => $value): ?>
                    <tr>
                        <td><?php echo esc_html($value["order_status"]); ?></td>
                        <td><?php echo esc_html($value["order_count"]); ?></td>
                        <td><?php echo esc_html($this->get_price($value["line_total"])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-7">
        <table class="table table-striped table-hover">
            <thead class="shadow-sm p-3 mb-5 bg-white rounded">
                <tr>
                    <td>year</td>
                    <td>Order Count</td>
                    <td>Product Total</td>
                    <td>Quantity Sold</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_order_year as $key => $value): ?>
                    <tr>
                        <td><?php echo esc_html($value["year"]); ?></td>
                        <td><?php echo esc_html($value["order_count"]); ?></td>
                        <td><?php echo esc_html($this->get_price($value["line_total"])); ?></td>
                        <td><?php echo esc_html($value["qty"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php

            //$product_order_year = $this->get_product_by_order_year( $rows);
            //$this->print_data($product_order_year);
        }
        public function get_product_order_status($rows = array())
        {
            $order_status_group = array();

            foreach ($rows as $key => $item) {
                $order_status_group[$item->order_status][$key] = $item;
            }

            ksort($order_status_group, SORT_NUMERIC);

            // $this->print_data($order_status_group);

            $order_status_data = array();
            foreach ($order_status_group as $key => $value) {

                //  echo $key . count($value);
                // echo "<br>" ;

                $order_status_data[$key]["order_status"]  =    ucfirst(str_replace("wc-", "", $key));;
                $order_status_data[$key]["order_count"]  =  count($value);
                $order_status_data[$key]["line_total"]  =   array_sum(array_column($value, 'line_total'));
            }
            return  $order_status_data;
        }
        public function get_product_by_order_year($rows = array())
        {
            $order_status_group = array();

            foreach ($rows as $key => $item) {
                $order_status_group[$item->order_year][$key] = $item;
            }

            ksort($order_status_group, SORT_NUMERIC);

            //  $this->print_data($order_status_group);

            $order_status_data = array();
            foreach ($order_status_group as $key => $value) {

                //  echo $key . count($value);
                // echo "<br>" ;

                $order_status_data[$key]["year"]  =  $key;
                $order_status_data[$key]["order_count"]  =  count($value);
                $order_status_data[$key]["line_total"]  =   array_sum(array_column($value, 'line_total'));
                $order_status_data[$key]["qty"]  =   array_sum(array_column($value, 'qty'));
            }
            return $order_status_data;
        }
    }
}
?>