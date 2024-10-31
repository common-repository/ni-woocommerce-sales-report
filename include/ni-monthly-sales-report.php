<?php
if (!defined('ABSPATH')) {
	exit;
}
include_once ('report-function.php');
if (!class_exists('Ni_Monthly_Sales_Report')) {
	class Ni_Monthly_Sales_Report extends ReportFunction
	{
		var $is_hpos_enable = false;
		function __construct()
		{
			 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
		}
		function page_init()
		{
			$today = date_i18n("Y-m-d");
			$current_year = date_i18n("Y");
			?>
			<div class="container-fluid" id="niwoosalesreport">
				<div class="row">

					<div class="col-md-12" style="padding:0px;">
						<div class="card" style="max-width:70% ">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Monthly Sales Report', 'nisalesreport'); ?>
							</div>
							<div class="card-body">
								<form id="frmOrderItem" method="post">
									<div class="form-group row">
										<div class="col-sm-2">
											<label for="selected_year"><?php esc_html_e('Year', 'nisalesreport'); ?></label>
										</div>
										<div class="col-sm-4">

											<select name="selected_year" id="selected_year" class="form-control">
												<?php
												// Get the current year
												$currentYear = date_i18n("Y");

												// Loop through the current year and the previous year
												for ($year = $currentYear; $year >= $currentYear - 1; $year--) {
													// Display each year as an option with its value
													echo '<option value="' . esc_html($year) . '">' . esc_html($year) . '</option>';
												}
												?>
											</select>

										</div>
										<div class="col-sm-2">
											<label for="selected_month"><?php esc_html_e('Month', 'nisalesreport'); ?></label>
										</div>
										<div class="col-sm-4">
											<select name="selected_month" id="selected_month" class="form-control">
												<option value="-1"><?php esc_html_e('Select Month', 'nisalesreport'); ?></option>
												<option value="01"><?php esc_html_e('January', 'nisalesreport'); ?></option>
												<option value="02"><?php esc_html_e('February', 'nisalesreport'); ?></option>
												<option value="03"><?php esc_html_e('March', 'nisalesreport'); ?></option>
												<option value="04"><?php esc_html_e('April', 'nisalesreport'); ?></option>
												<option value="05"><?php esc_html_e('May', 'nisalesreport'); ?></option>
												<option value="06"><?php esc_html_e('June', 'nisalesreport'); ?></option>
												<option value="07"><?php esc_html_e('July', 'nisalesreport'); ?></option>
												<option value="08"><?php esc_html_e('August', 'nisalesreport'); ?></option>
												<option value="09"><?php esc_html_e('September', 'nisalesreport'); ?></option>
												<option value="10"><?php esc_html_e('October', 'nisalesreport'); ?></option>
												<option value="11"><?php esc_html_e('November', 'nisalesreport'); ?></option>
												<option value="12"><?php esc_html_e('December', 'nisalesreport'); ?></option>
											</select>
										</div>

									</div>

									<div class="form-group row">
										<div class="col-sm-12 text-right">
											<input type="submit" class="niwoosalesreport_button_form niwoosalesreport_button"
												value="Search">
										</div>


									</div>

									<input type="hidden" name="action" id="action" value="sales_order" />
									<input type="hidden" name="ajax_function" id="ajax_function" value="order_item" />
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
		function get_ajax()
		{
			$this->get_tables();
		}
		function get_tables()
		{
			$columns = $this->get_columns();
			//$rows = $this->get_query();

			if ($this->is_hpos_enable == true) {
				$rows = $this->get_query_hpos();

			} else {
				$rows = $this->get_query();

			}



			?>
			<table class="table table-striped table-hover">
				<thead class="shadow-sm p-3 mb-5 bg-white rounded">
					<tr>
						<?php foreach ($columns as $key => $value): ?>
							<th><?php echo esc_html($value); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($rows)): ?>
						<?php foreach ($rows as $row_key => $row_value): ?>
							<tr>
								<?php foreach ($columns as $col_key => $col_value): ?>
									<?php
									switch ($col_key):
										case 1:
											break; ?>
										<?php case "line_tax": ?>
										<?php case "order_total": ?>
										<?php case "line_total": ?>
											<?php $td_class = "style=\"text-align:right\""; ?>
											<?php $td_value = wc_price(isset($row_value->$col_key) ? $row_value->$col_key : "0"); ?>
											<?php break; ?>
										<?php default: ?>
											<?php $td_value = isset($row_value->$col_key) ? $row_value->$col_key : ""; ?>
									<?php endswitch; ?>
									<?php $td_class = ""; ?>
									<td <?php echo esc_html($td_class); ?>><?php echo esc_html(wp_strip_all_tags($td_value)); ?></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="<?php echo count($columns); ?>">No records found.</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>

			<?php


		}
		function get_columns()
		{
			$columns = array();
			$columns["display_name"] = esc_html__("Month Name", "nisalesreport");
			$columns["order_count"] = esc_html__("Order Count", "nisalesreport");
			$columns["order_total"] = esc_html__("Order Total", "nisalesreport");
			return $columns;
		}
		function get_query_hpos()
		{
			global $wpdb;


			$selected_year = $this->get_request("selected_year", date_i18n("Y"));
			$selected_month = $this->get_request("selected_month", -1);

			$year_month = $selected_year . "-" . $selected_month;

			$query = array();
			$query[] = "SELECT ";
			$query[] = "CONCAT(date_format(posts.date_created_gmt, '%Y-%m'),' (',MONTHNAME(date_format(posts.date_created_gmt, '%Y-%m-01')),')') as display_name";
			$query[] = ", MONTHNAME(date_format(posts.date_created_gmt, '%Y-%m-01')) as month_name";
			$query[] = ", date_format(posts.date_created_gmt, '%Y-%m') as order_date";
			$query[] = ", ROUND(SUM(posts.total_amount),2) as order_total ";

			$query[] = ", COUNT(*) as order_count ";

			$query[] = "FROM {$wpdb->prefix}wc_orders as posts	";
			//$query[] = "LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query[] = "WHERE 1 = 1";
			$query[] = "AND	posts.type ='shop_order' ";
			//$query[] = "AND	order_total.meta_key ='_order_total' ";

			if (($selected_month + 0) > 0) {
				//$query []= " AND	 date_format( posts.post_date, '%Y-%m')  ='{$year_month}'";
				$query[] = $wpdb->prepare("AND  date_format( posts.date_created_gmt, %s) = %s", '%Y-%m', $year_month);
			}

			$query[] = " GROUP By date_format( posts.date_created_gmt, '%Y-%m')";
			$query[] = " ORDER  By date_format( posts.date_created_gmt, '%m') +0";


			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));

			//$this->print_data(	$wpdb);

			return $rows;

		}
		function get_query()
		{
			global $wpdb;


			$selected_year = $this->get_request("selected_year", date_i18n("Y"));
			$selected_month = $this->get_request("selected_month", -1);

			$year_month = $selected_year . "-" . $selected_month;

			$query = array();
			$query[] = "SELECT ";
			$query[] = "CONCAT(date_format(posts.post_date, '%Y-%m'),' (',MONTHNAME(date_format(posts.post_date, '%Y-%m-01')),')') as display_name";
			$query[] = ", MONTHNAME(date_format(posts.post_date, '%Y-%m-01')) as month_name";
			$query[] = ", date_format(posts.post_date, '%Y-%m') as order_date";
			$query[] = ", ROUND(SUM(order_total.meta_value),2) as order_total ";
			$query[] = ", COUNT(*) as order_count ";
			$query[] = "FROM {$wpdb->prefix}posts as posts	";
			$query[] = "LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";
			$query[] = "WHERE 1 = 1";
			$query[] = "AND	posts.post_type ='shop_order' ";
			$query[] = "AND	order_total.meta_key ='_order_total' ";

			if (($selected_month + 0) > 0) {
				//$query []= " AND	 date_format( posts.post_date, '%Y-%m')  ='{$year_month}'";
				$query[] = $wpdb->prepare("AND  date_format( posts.post_date, %s) = %s", '%Y-%m', $year_month);
			}

			$query[] = " GROUP By date_format( posts.post_date, '%Y-%m')";
			$query[] = " ORDER  By date_format( posts.post_date, '%m') +0";


			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));
			return $rows;

		}
		
	}
}