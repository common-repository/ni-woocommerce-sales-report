<?php
if (!defined('ABSPATH')) {
	exit;
}
include_once ('report-function.php');
class Ni_Category_Report extends ReportFunction
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
							<?php esc_html_e('Category Report', 'nisalesreport'); ?>
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
								<input type="hidden" name="ajax_function" value="category_report">
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
		$query[] = "	date_format( posts.post_date, '%Y-%m-%d') as order_date  ";
		$query[] = "	,product_id.meta_value as product_id";
		$query[] = "	,SUM(line_total.meta_value) as line_total";
		//$query .= "	,order_items.order_item_name as product_name";
		$query[] = "	,terms.name as product_category";
		$query[] = " FROM {$wpdb->prefix}posts as posts ";
		$query[] = "LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";
		$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";

		$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";



		/*Cat*/
		$query[] = " LEFT JOIN  {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=product_id.meta_value";
		$query[] = " LEFT JOIN  {$wpdb->prefix}term_taxonomy as taxonomy ON taxonomy.term_taxonomy_id=relationships.term_taxonomy_id";
		$query[] = " LEFT JOIN  {$wpdb->prefix}terms as terms ON terms.term_id=taxonomy.term_id";
		/*End Cat*/



		$query[] = " WHERE 1=1 ";

		$query[] = " AND posts.post_type ='shop_order'  ";
		$query[] = " AND order_items.order_item_type ='line_item'  ";
		$query[] = " AND product_id.meta_key ='_product_id'";

		$query[] = " AND line_total.meta_key ='_line_total'";


		$query[] = " AND taxonomy.taxonomy ='product_cat'";

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


		$query[] = " GROUP BY terms.slug";

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$rows = $wpdb->get_results(implode(' ', $query));
		return $rows;
	}
	function get_query_hpos()
	{
		global $wpdb;
		$today = date_i18n("Y-m-d");

		$select_order = $this->get_request("select_order", "today");

		$query = array();
		$query[] = "SELECT ";
		$query[] = "	date_format( posts.date_created_gmt, '%Y-%m-%d') as order_date  ";
		$query[] = "	,product_id.meta_value as product_id";
		$query[] = "	,SUM(posts.total_amount) as line_total";
		//$query .= "	,order_items.order_item_name as product_name";
		$query[] = "	,terms.name as product_category";
		$query[] = " FROM {$wpdb->prefix}wc_orders as posts ";
		$query[] = "LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id=posts.ID ";
		$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as product_id ON product_id.order_item_id=order_items.order_item_id ";

		$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as line_total ON line_total.order_item_id=order_items.order_item_id ";



		/*Cat*/
		$query[] = " LEFT JOIN  {$wpdb->prefix}term_relationships as relationships ON relationships.object_id=product_id.meta_value";
		$query[] = " LEFT JOIN  {$wpdb->prefix}term_taxonomy as taxonomy ON taxonomy.term_taxonomy_id=relationships.term_taxonomy_id";
		$query[] = " LEFT JOIN  {$wpdb->prefix}terms as terms ON terms.term_id=taxonomy.term_id";
		/*End Cat*/



		$query[] = " WHERE 1=1 ";

		$query[] = " AND posts.type ='shop_order'  ";
		$query[] = " AND order_items.order_item_type ='line_item'  ";
		$query[] = " AND product_id.meta_key ='_product_id'";

		$query[] = " AND line_total.meta_key ='_line_total'";


		$query[] = " AND taxonomy.taxonomy ='product_cat'";

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
				$query[] = $wpdb->prepare(" AND  date_format( posts.post_date,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
				//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 10 DAY), '%Y-%m-%d') AND   '{$today}' ";
				break;
			case "last_30_days":
				$query[] = $wpdb->prepare(" AND  date_format( posts.date_created_gmt,%s) BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY),%s) AND  %s ", '%Y-%m-%d', '%Y-%m-%d', $today);
			//$query[] = $wpdb->prepare( " AND  date_format( posts.post_date, '%Y-%m-%d') BETWEEN date_format(DATE_SUB(CURDATE(), INTERVAL 30 DAY), '%Y-%m-%d') AND   '{$today}' ";
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


		$query[] = " GROUP BY terms.slug";

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$rows = $wpdb->get_results(implode(' ', $query));
		return $rows;
	}

	function get_ajax()
	{
		$this->get_table();
	}
	function get_table()
	{

		if ($this->is_hpos_enable == true) {
			$row = $this->get_query_hpos();
		} else {
			$row = $this->get_query();
		}

		?>

		<table class="table table-striped table-hover">
			<thead class="shadow-sm p-3 mb-5 bg-white rounded">
				<tr>
					<th><?php esc_html_e("Category Name", "nisalesreport") ?></th>
					<th style="text-align:right"><?php esc_html_e("Category Total", "nisalesreport") ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($row) == 0): ?>
					<tr>
						<td colspan="2"><?php esc_html_e("No record found", "nisalesreport") ?></td>
					</tr>
					<?php return; ?>
				<?php endif; ?>
				<?php foreach ($row as $key => $value): ?>
					<tr>
						<td><?php echo esc_html($value->product_category); ?></td>
						<td style="text-align:right"><?php echo esc_html(wp_strip_all_tags(wc_price($value->line_total))); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php
	}
}
?>