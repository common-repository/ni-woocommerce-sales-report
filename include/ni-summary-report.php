<?php
if (!defined('ABSPATH')) {
	exit;
}
include_once ('report-function.php');
class Ni_Summary_Report extends ReportFunction
{
	var $is_hpos_enable = false;

	public function __construct()
	{
		 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
	}
	function page_init()
	{

		?>
		<div class="container-fluid" id="niwoosalesreport">

			<div class="row">
				<div class="col-md-12" style="padding:0px;">
					<div class="card" style="max-width:60%">
						<div class="card-header niwoosr-bg-c-purple">
							<?php esc_html_e('Summary Report', 'nisalesreport'); ?>
						</div>
						<div class="card-body">
							<form id="frmOrderItem" method="post">
								<div class="form-group row">
									<div class="col-sm-4">
										<label
											for="select_order"><?php esc_html_e('Select order period', 'nisalesreport'); ?></label>
									</div>
									<div class="col-sm-8">
										<select name="select_order" id="select_order" class="form-control">
											<option value="today"><?php esc_html_e('Today', 'nisalesreport'); ?></option>
											<option value="yesterday"><?php esc_html_e('Yesterday', 'nisalesreport'); ?>
											</option>
											<option value="last_7_days"><?php esc_html_e('Last 7 days', 'nisalesreport'); ?>
											</option>
											<option value="last_10_days"><?php esc_html_e('Last 10 days', 'nisalesreport'); ?>
											</option>
											<option value="last_30_days"><?php esc_html_e('Last 30 days', 'nisalesreport'); ?>
											</option>
											<option value="last_60_days"><?php esc_html_e('Last 60 days', 'nisalesreport'); ?>
											</option>
											<option value="this_year"><?php esc_html_e('This year', 'nisalesreport'); ?>
											</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-12 text-right">
										<input type="submit" class="niwoosalesreport_button_form niwoosalesreport_button"
											value="<?php esc_attr_e('Search', 'nisalesreport'); ?>">
									</div>
								</div>
								<input type="hidden" name="action" value="sales_order">
								<input type="hidden" name="ajax_function" value="summary_report">
								<input type="hidden" name="page" id="page"
									value="<?php echo esc_attr(isset($_REQUEST["page"]) ? $_REQUEST["page"] : ''); ?>" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding:0px;">
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
	function get_query()
	{
		global $wpdb;
		$today = date_i18n("Y-m-d");

		$select_order = $this->get_request("select_order", "today");



		$query = array();
		$query[] = "SELECT ";
		$query[] = " sum(postmeta.meta_value) meta_value";
		$query[] = " ,postmeta.meta_key ";
		$query[] = " FROM {$wpdb->prefix}posts as posts ";

		$query[] = " LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID ";

		$query[] = " WHERE 1=1 ";
		$query[] = " AND posts.post_type ='shop_order'  ";
		$query[] = " AND postmeta.meta_key IN ('_order_shipping','_order_shipping_tax','_order_tax','_order_total','_cart_discount','_cart_discount_tax')  ";


		//$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";	

		switch ($select_order) {
			case "today":
				$query[] = $wpdb->prepare(" AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ", '%Y-%m-%d', $today, $today);
				break;
			case "yesterday":
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY),%s)", '%Y-%m-%d', '%Y-%m-%d');
				break;
			case "last_7_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				break;
			case "last_10_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			case "last_30_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
			//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
			case "last_60_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
				break;
			case "this_year":
				$query[] = $wpdb->prepare(" AND  YEAR(date_format( posts.post_date, %s)) = YEAR(date_format(CURDATE(),%s))", '%Y-%m-%d', '%Y-%m-%d');
				break;
			default:
				$query[] = $wpdb->prepare(" AND   date_format( posts.post_date, %s) BETWEEN %s AND %s ", '%Y-%m-%d', $today, $today);
		}


		$query[] = " GROUP BY postmeta.meta_key  ";

		$data = array();
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$row = $wpdb->get_results(implode(' ', $query));

		foreach ($row as $key => $value) {
			$data[ltrim($value->meta_key, "_")] = $value->meta_value;
		}

		return $data;
	}
	function get_query_hpos()
	{
		global $wpdb;
		$today = date_i18n("Y-m-d");

		$select_order = $this->get_request("select_order", "today");



		$query = array();
		$query[] = "SELECT ";
		$query[] = " sum(posts.tax_amount) as tax_amount";
		$query[] = ", sum(posts.total_amount) as total_amount";
		//$query[] = ", sum(order_stats.num_items_sold) as num_items_sold";
		$query[] = ", sum(order_stats.total_sales) as total_sales";
		$query[] = ", sum(order_stats.tax_total) as tax_total";
		$query[] = ", sum(order_stats.shipping_total) as shipping_total";
		$query[] = ", sum(order_stats.net_total) as net_total";

		//$query[] = " ,postmeta.meta_key ";
		$query[] = " FROM {$wpdb->prefix}wc_orders as posts ";

		$query[] = " LEFT JOIN  {$wpdb->prefix}wc_order_stats as order_stats ON order_stats.order_id=posts.ID ";

		$query[] = " WHERE 1=1 ";
		$query[] = " AND posts.type ='shop_order'  ";
		//$query[] = " AND postmeta.meta_key IN ('_order_shipping','_order_shipping_tax','_order_tax','_order_total','_cart_discount','_cart_discount_tax')  ";


		//$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";	

		switch ($select_order) {
			case "today":
				$query[] = $wpdb->prepare(" AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d', $today, $today);
				break;
			case "yesterday":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt, %s) = date_format( DATE_SUB(CURDATE(), INTERVAL 1 DAY),%s)", '%Y-%m-%d', '%Y-%m-%d');
				break;
			case "last_7_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 7 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				break;
			case "last_10_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			case "last_30_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			case "last_60_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 60 DAY), '%Y-%m-%d') AND   '{$today}' ";		
				break;
			case "this_year":
				$query[] = $wpdb->prepare(" AND  YEAR(date_format( posts.date_created_gmt, %s)) = YEAR(date_format(CURDATE(),%s))", '%Y-%m-%d', '%Y-%m-%d');
				break;
			default:
				$query[] = $wpdb->prepare(" AND   date_format( posts.date_created_gmt, %s) BETWEEN %s AND %s ", '%Y-%m-%d', $today, $today);
		}


		// $query[] = " GROUP BY posts.total_amount 
		// ,posts.tax_amount 
		// ,order_stats.num_items_sold 
		// ,order_stats.total_sales
		// ,order_stats.tax_total
		// ,order_stats.shipping_total
		// ,order_stats.net_total
		// ";

		$data = array();
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$rows = $wpdb->get_results(implode(' ', $query));

		//$this->print_data($row);

		// foreach($row as $key=>$value){
		// 	//$data [ltrim($value->meta_key,"_")] = $value->meta_value;
		// 	$data [ltrim($key,"_")] = $value;
		// }

		// $this->print_data($data);

		if (!empty($rows)) {
			foreach ($rows as $row) {
				foreach ($row as $key => $value) {
					// Dynamically populate the $data array
					$data[$key] = $value;
				}
			}
		}
		return $data;

	}
	function get_ajax()
	{
		$this->get_table();
	}
	function get_table()
	{
		$row = array();
		//$row =  $this->get_query();

		if ($this->is_hpos_enable == true) {
			$row = $this->get_query_hpos();

		} else {
			$row = $this->get_query();

		}
		//$this->print_data($row);

		?>

		<table class="table table-striped table-hover">
			<thead class="shadow-sm p-3 mb-5 bg-white rounded">
				<tr>
					<th><?php esc_html_e("Name", "nisalesreport") ?></th>
					<th style="text-align:right"><?php esc_html_e("Total", "nisalesreport") ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($row) == 0): ?>
					<tr>
						<td colspan="2"><?php esc_html_e("No record found", "nisalesreport") ?></td>
					</tr>
					<?php return; ?>
				<?php endif; ?>
				<?php if (!empty($row)): ?>
					<?php foreach ($row as $key => $value): ?>
						<tr>
							<td><?php echo esc_html(ucwords(str_replace("_", " ", $key))); ?></td>
							<td style="text-align:right"><?php echo esc_html(wp_strip_all_tags(wc_price($value))); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="2">No record found.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>

		<?php
	}

}
?>