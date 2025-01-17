<?php
include_once ('report-function.php');
if (!class_exists('Summary')) {


	class Summary extends ReportFunction
	{
		var $is_hpos_enable = false;
		public function __construct()
		{
			//$this->get_low_in_stock();
			//$this->init();
			//$this->get_yearly_sales();
			//$this->Test();
			//die;
			 $this->is_hpos_enable  = 	$this->is_hpos_enabled();
		}
		function Test($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{


		}
		function get_yearly_sales_hpos()
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				SUM(posts.total_amount) as 'order_total'";
			$query[] = $wpdb->prepare("	,YEAR(date_format( posts.date_created_gmt,%s)) as Year ", '%Y-%m-%d');
			$query[] = " FROM {$wpdb->prefix}wc_orders as posts	";

			//$query[] ="	LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID ";

			$query[] = " WHERE 1=1 ";



			//$query[] = " AND postmeta.meta_key ='_order_total' ";
			$query[] = " AND  posts.status NOT IN ('trash')";
			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			$query[] = $wpdb->prepare("  GROUP BY YEAR(date_format( posts.date_created_gmt, %s)) ", '%Y-%m-%d');

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));


			return $rows;
		}
		function get_yearly_sales()
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				SUM(postmeta.meta_value) as 'order_total'";
			$query[] = $wpdb->prepare("	,YEAR(date_format( posts.post_date,%s)) as Year ", '%Y-%m-%d');
			$query[] = " FROM {$wpdb->prefix}posts as posts	";

			$query[] =
				"	LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID ";

			$query[] = " WHERE 1=1 ";



			$query[] = " AND postmeta.meta_key ='_order_total' ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			$query[] = " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			$query[] = $wpdb->prepare("  GROUP BY YEAR(date_format( posts.post_date, %s)) ", '%Y-%m-%d');

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));


			return $rows;
		}
		function init()
		{


			?>
			<div class="container-fluid" id="niwoosalesreport">
				<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleSlidesOnly" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleSlidesOnly" data-slide-to="1"></li>
						<li data-target="#carouselExampleSlidesOnly" data-slide-to="2"></li>
						<li data-target="#carouselExampleSlidesOnly" data-slide-to="3"></li>
						<li data-target="#carouselExampleSlidesOnly" data-slide-to="4"></li>
					</ol>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<div class="card bg-rgba-green-slight">
								<div class="card-header bg-rgba-salmon-strong">
									<?php esc_html_e('Monitor your sales and grow your online business with naziinfotech plugins', 'niwoopvt'); ?>
								</div>
								<div class="card-body">
									<h2 class="card-title text-center color-rgba-salmon-strong">Buy Ni Display Product Variation
										Table Pro $34.00</h2>
									<div class="row" style="font-size:16px">
										<div class="col-md-6">
											<span class="font-weight-bold color-rgba-black-strong">Show variation product table on
												product detail page</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Show the variation dropdown on
												product page and category page</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Show the variation product on
												shop page and category page</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Add to cart bulk quantity on
												product detail page in variation table</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Set the default quantity in
												variation table</span><br />
										</div>

										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Change the display order for
												table variation columns</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Set columns of product variation
												table</span> <br />

										</div>
										<div class="col-md-3">
											<h5> <span class="font-weight-bold">Coupon Code: <span class="text-warning">ni10</span>
													Get 10% OFF</span></h5>
											<span> <span class="font-weight-bold">Email at:</span><a
													href="mailto:support@naziinfotech.com"
													target="_blank">support@naziinfotech.com</a></span><br />
											<span> <span class="font-weight-bold">Website: </span><a href="http://naziinfotech.com/"
													target="_blank">www.naziinfotech.com</a></span> <br />
										</div>
									</div>
									<div class="text-center">
										<br />
										<br />
										<a href="http://demo.naziinfotech.com?demo_login=woo_sales_report"
											class="btn btn-rgba-salmon-strong btn-lg" target="_blank">View Demo</a>
										<a href="http://naziinfotech.com/?product=ni-woocommerce-sales-report-pro" target="_blank"
											class="btn btn-rgba-salmon-strong btn-lg">Buy Now</a>
										<br />
										<br />
										<br />
										<br />
									</div>

								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="card bg-rgba-green-slight">
								<div class="card-header bg-rgba-green-strong">
									<?php esc_html_e('Monitor your sales and grow your online business with naziinfotech plugins', 'niwoopvt'); ?>
								</div>
								<div class="card-body">
									<h2 class="card-title text-center color-rgba-green-strong">Buy Ni WooCommerce Sales Report Pro
										$24.00</h2>
									<div class="row" style="font-size:16px">
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Dashboard order
												Summary</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Order List - Display order
												list</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Order Detail - Display Product
												information</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Sold Product variation
												Report</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Customer Sales
												Report</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Payment Gateway Sales
												Report</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Country Sales Report</span>
											<br />
											<span class="font-weight-bold color-rgba-black-strong">Coupon Sales Report</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Order Export To CSV</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Custom Date Filter, Start Date
												and End Date</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Product Center</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Customer center </span> <br />
										</div>
										<div class="col-md-3">
											<h5> <span class="font-weight-bold">Coupon Code: <span class="text-warning">ni10</span>
													Get 10% OFF</span></h5>
											<span> <span class="font-weight-bold">Email at:</span><a
													href="mailto:support@naziinfotech.com"
													target="_blank">support@naziinfotech.com</a></span><br />
											<span> <span class="font-weight-bold">Website: </span><a href="http://naziinfotech.com/"
													target="_blank">www.naziinfotech.com</a></span> <br />
										</div>
									</div>
									<div class="text-center">
										<br />
										<br />
										<a href="http://demo.naziinfotech.com?demo_login=woo_sales_report"
											class="btn btn-green-strong btn-lg" target="_blank">View Demo</a>
										<a href="http://naziinfotech.com/?product=ni-woocommerce-sales-report-pro" target="_blank"
											class="btn btn-green-strong btn-lg">Buy Now</a>
										<br />
										<br />
										<br />
										<br />
									</div>

								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="card bg-rgba-cyan-slight">
								<div class="card-header bg-rgba-cyan-strong">
									<?php esc_html_e('Monitor your sales and grow your online business with naziinfotech plugins', 'niwoopvt'); ?>
								</div>
								<div class="card-body">
									<h2 class="card-title text-center color-rgba-cyan-strong">Buy Ni WooCommerce cost of goods Pro @
										$34.00</h2>

									<div class="row" style="font-size:16px">
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Sales Profit Report</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Dashboard order
												Summary</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Daily profit Report</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Monthly profit Report</span>
											<br />

										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Add Cost of goods for simple
												product</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Add Cost of goods for variation
												product</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Top Profit Product</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Stock valuation</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Order Export To CSV</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Custom Date Filter, Start Date
												and End Date</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Ajax pagination </span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Easy to use </span> <br />
										</div>
										<div class="col-md-3">
											<h5> <span class="font-weight-bold">Coupon Code: <span class="text-warning">ni10</span>
													Get 10% OFF</span></h5>
											<span> <span class="font-weight-bold">Email at:</span><a
													href="mailto:support@naziinfotech.com"
													target="_blank">support@naziinfotech.com</a></span><br />
											<span> <span class="font-weight-bold">Website: </span><a href="http://naziinfotech.com/"
													target="_blank">www.naziinfotech.com</a></span> <br />
										</div>
									</div>
									<div class="text-center">
										<br />
										<br />
										<a href="http://demo.naziinfotech.com/?demo_login=woo_cost_of_goods"
											class="btn btn-rgba-cyan-strong btn-lg" target="_blank">View Demo</a>
										<a href="http://naziinfotech.com/product/ni-woocommerce-cost-of-good-pro/" target="_blank"
											class="btn btn-rgba-cyan-strong btn-lg">Buy Now</a>
										<br />
										<br />
										<br />
										<br />
									</div>

								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="card bg-rgba-indigo-slight">
								<div class="card-header bg-rgba-indigo-strong">
									<?php esc_html_e('Monitor your sales and grow your online business with naziinfotech plugins', 'niwoopvt'); ?>
								</div>
								<div class="card-body">
									<h2 class="card-title text-center color-rgba-indigo-strong">
										<?php esc_html_e('Buy Ni WooCommerce Product Enquiry Pro @ $24.00', 'niwoopvt'); ?>
									</h2>
									<div class="row" style="font-size:16px">
										<div class="col-md-3">
											<span
												class="font-weight-bold color-rgba-black-strong"><?php esc_html_e('Dashboard Summary (Today, Total Enquiry)', 'niwoopvt'); ?></span><br />
											<span class="font-weight-bold color-rgba-black-strong">Monthly Enquiry Graph</span>
											<br />
											<span class="font-weight-bold color-rgba-black-strong">Recent Enquiry</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Last Enquiry Date</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Enquiry List</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Enquiry Export</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Top Enquiry Product</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Top Enquiry Visitor</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Order Export To CSV</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Custom Date Filter, Start Date
												and End Date</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Ajax pagination </span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Easy to use </span> <br />
										</div>
										<div class="col-md-3">
											<h5> <span class="font-weight-bold">Coupon Code: <span class="text-warning">ni10</span>
													Get 10% OFF</span></h5>
											<span> <span class="font-weight-bold">Email at:</span><a
													href="mailto:support@naziinfotech.com"
													target="_blank">support@naziinfotech.com</a></span><br />
											<span> <span class="font-weight-bold">Website: </span><a href="http://naziinfotech.com/"
													target="_blank">www.naziinfotech.com</a></span> <br />
										</div>
									</div>
									<div class="text-center">
										<br />
										<br />
										<a href="http://demo.naziinfotech.com/enquiry-demo/"
											class="btn btn-rgba-indigo-strong btn-lg" target="_blank">View Demo</a>
										<a href="http://naziinfotech.com/product/ni-woocommerce-product-enquiry-pro/"
											target="_blank" class="btn btn-rgba-indigo-strong btn-lg">Buy Now</a>
										<br />
										<br />
										<br />
										<br />
									</div>

								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="card bg-rgba-blue-slight">
								<div class="card-header bg-rgba-blue-strong">
									<?php esc_html_e('Monitor your sales and grow your online business with naziinfotech plugins', 'niwoopvt'); ?>
								</div>
								<div class="card-body">
									<h2 class="card-title text-center color-rgba-blue-strong">
										<?php esc_html_e('Ni One Page Inventory Management System For WooCommerce', 'niwoopvt'); ?>
									</h2>
									<div class="row" style="font-size:16px">
										<div class="col-md-3">
											<span
												class="font-weight-bold color-rgba-black-strong"><?php esc_html_e('Dashboard Summary stock status', 'niwoopvt'); ?></span><br />
											<span class="font-weight-bold color-rgba-black-strong">Manage Purchase order</span>
											<br />
											<span class="font-weight-bold color-rgba-black-strong">Multi location inventory
												management</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Stock Center</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Purchase History</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Mange product</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Vendor management</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Product Vendor</span> <br />
										</div>
										<div class="col-md-3">
											<span class="font-weight-bold color-rgba-black-strong">Order Export To CSV</span><br />
											<span class="font-weight-bold color-rgba-black-strong">Custom Date Filter, Start Date
												and End Date</span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Ajax pagination </span> <br />
											<span class="font-weight-bold color-rgba-black-strong">Easy to use </span> <br />
										</div>
										<div class="col-md-3">
											<span> <span class="font-weight-bold">Email at:</span><a
													href="mailto:support@naziinfotech.com"
													target="_blank">support@naziinfotech.com</a></span><br />
											<span> <span class="font-weight-bold">Website: </span><a href="http://naziinfotech.com/"
													target="_blank">www.naziinfotech.com</a></span> <br />
										</div>
									</div>
									<div class="text-center">
										<br />
										<br />
										<a href="https://wordpress.org/plugins/ni-one-page-inventory-management-system-for-woocommerce/"
											class="btn btn-rgba-blue-strong btn-lg" target="_blank">View</a>
										<a href="https://downloads.wordpress.org/plugin/ni-one-page-inventory-management-system-for-woocommerce.zip"
											target="_blank" class="btn btn-rgba-blue-strong btn-lg">Download</a>
										<br />
										<br />
										<br />
										<br />
									</div>

								</div>
							</div>
						</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				<div class="row" style="display:none">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Monitor your sales and grow your online business', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-xl-12 col-md-12 col-lg-12">
										<h1 class="text-center text-success">Buy Ni WooCommerce Sales Report Pro $24.00</h1>
										<h2 class="text-info">Feature List</h2>
										<div class="row">
											<div class="col-xl-6">
												<ul class="list-group" style="font-size:14px">
													<li class="list-group-item font-weight-bold box1">Dashboard order Summary</li>
													<li class="list-group-item font-weight-bold box2">Order List - Display order
														list</li>
													<li class="list-group-item font-weight-bold box3">Order Detail - Display Product
														information</li>
													<li class="list-group-item font-weight-bold box4">Sold Product variation Report
													</li>
													<li class="list-group-item font-weight-bold box5">Customer Sales Report</li>
													<li class="list-group-item font-weight-bold box6">Payment Gateway Sales Report
													</li>
													<li class="list-group-item font-weight-bold box7">Country Sales Report</li>
													<li class="list-group-item font-weight-bold box8">Coupon Sales Report</li>
													<li class="list-group-item font-weight-bold box9">Order Status Sales Report</li>
													<li class="list-group-item font-weight-bold box10">Stock Report(Simple, Variable
														and Variation Product)</li>
												</ul>
											</div>
											<div class="col-xl-6">
												<ul class="list-group" style="font-size:14px">
													<li class="list-group-item font-weight-bold box1"> Email at: <a
															href="mailto:support@naziinfotech.com">support@naziinfotech.com</a></li>
													<li class="list-group-item font-weight-bold box2"><a
															href="http://demo.naziinfotech.com?demo_login=woo_sales_report"
															target="_blank">View Demo</a></li>
													<li class="list-group-item font-weight-bold box3"><a
															href="http://naziinfotech.com/?product=ni-woocommerce-sales-report-pro"
															target="_blank">Buy Now</a></li>
													<li class="list-group-item font-weight-bold box5">Coupon Code: ni10 Get 10% OFF
													</li>
												</ul>

											</div>
											<div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-body">
								<h5> We will develop a <span class="text-success" style="font-size:26px;">New</span> WordPress and
									WooCommerce <span class="text-success" style="font-size:26px;">plugin</span> and customize or
									modify  the <span class="text-success" style="font-size:26px;">existing</span> plugin, if
									yourequire any <span class="text-success" style="font-size:26px;"> customization</span>  in
									WordPress and WooCommerce then please <span class="text-success" style="font-size:26px;">contact
										us</span> at: <a href="mailto:support@naziinfotech.com">support@naziinfotech.com</a>.</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Dashboard - Sales Analysis', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-xl-3 col-md-6 col-lg-4   box10">
										<div class="card card-border-top card-border-top-box10  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Total Sales', 'nisalesreport'); ?></strong></h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php

													if ($this->is_hpos_enable == true) {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales_hpos("ALL"))));
													} else {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales("ALL"))));
													}



													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box1">
										<div class="card card-border-top card-border-top-box1  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Year Sales', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales_hpos("YEAR"))));
													} else {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales("YEAR"))));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box4  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Month Sales', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php

													if ($this->is_hpos_enable == true) {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales_hpos("MONTH"))));
													} else {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales("MONTH"))));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box6">
										<div class="card card-border-top card-border-top-box6  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Week Sales', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php





													if ($this->is_hpos_enable == true) {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales_hpos("WEEK"))));
													} else {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales("WEEK"))));
													}



													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box8">
										<div class="card card-border-top card-border-top-box8  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Yesterday Sales', 'nisalesreport'); ?></strong></h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php




													if ($this->is_hpos_enable == true) {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales_hpos("YESTERDAY"))));
													} else {
														echo esc_html(wp_strip_all_tags(wc_price($this->get_total_sales("YESTERDAY"))));
													}

													?></span></h3>
												</div>
											</div>
										</div>
									</div>


									<div class="col-xl-3 col-md-6 col-lg-4   box10">
										<div class="card card-border-top card-border-top-box10  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Total Sales Count', 'nisalesreport'); ?></strong></h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("ALL"));
													} else {
														echo esc_html($this->get_total_sales_count("ALL"));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box1">
										<div class="card card-border-top card-border-top-box1  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Year Sales Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php




													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("YEAR"));
													} else {
														echo esc_html($this->get_total_sales_count("YEAR"));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box4  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Month Sales Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php

													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("MONTH"));
													} else {
														echo esc_html($this->get_total_sales_count("MONTH"));
													}

													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box6">
										<div class="card card-border-top card-border-top-box6  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('This Week Sales Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php




													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("WEEK"));
													} else {
														echo esc_html($this->get_total_sales_count("WEEK"));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box8">
										<div class="card card-border-top card-border-top-box8  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Yesterday Sales Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php


													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("YESTERDAY"));
													} else {
														echo esc_html($this->get_total_sales_count("YESTERDAY"));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>


								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Customer Analysis', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-xl-3 col-md-6 col-lg-4   box10">
										<div class="card card-border-top card-border-top-box10  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Total Customer Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right">
															<?php
															//echo esc_html($this->get_customer());
												

															if ($this->is_hpos_enable == true) {

																echo esc_html($this->get_customer_hpos());
															} else {
																echo esc_html($this->get_customer());
															}
															?>
														</span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box1">
										<div class="card card-border-top card-border-top-box1  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Customer Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_customer_hpos(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													} else {
														echo esc_html($this->get_customer(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													}

													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box4  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Total Guest Customer Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_guest_customer_hpos());
													} else {
														echo esc_html($this->get_guest_customer());
													}



													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box6">
										<div class="card card-border-top card-border-top-box6  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Guest Cust. Count', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php

													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_guest_customer_hpos(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													} else {
														echo esc_html($this->get_guest_customer(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>




								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Today  Sales Analysis', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-xl-3 col-md-6 col-lg-4   box10">
										<div class="card card-border-top card-border-top-box10  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Today Order Count', 'nisalesreport'); ?></strong></h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php

													//echo esc_html($this->get_total_sales_count("DAY")); 
										
													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_total_sales_count_hpos("DAY"));
													} else {
														echo esc_html($this->get_total_sales_count("DAY"));
													}

													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box1">
										<div class="card card-border-top card-border-top-box1  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Sales', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php




													if ($this->is_hpos_enable == true) {

														echo esc_html(
															wp_strip_all_tags(
																wc_price($this->get_total_sales_hpos("DAY"))
															)
														);

													} else {
														echo esc_html(
															wp_strip_all_tags(
																wc_price($this->get_total_sales("DAY"))
															)
														);

													}


													?></span></h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box8  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Total Product Sold', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_sold_product_count_hpos());
													} else {
														echo esc_html($this->get_sold_product_count());
													}


													?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box4  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Product Sold', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><?php



													if ($this->is_hpos_enable == true) {

														echo esc_html($this->get_sold_product_count_hpos(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													} else {
														echo esc_html($this->get_sold_product_count(date_i18n("Y-m-d"), date_i18n("Y-m-d")));
													}


													?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box6">
										<div class="card card-border-top card-border-top-box6  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Discount', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span
															class="f-right"><?php
															
															
															//echo esc_html(wp_strip_all_tags(wc_price($this->get_total_discount(date_i18n("Y-m-d"), date_i18n("Y-m-d"))))); 
															
															if ($this->is_hpos_enable == true) {

																echo esc_html(wp_strip_all_tags(wc_price($this->get_total_discount_hpos(date_i18n("Y-m-d"), date_i18n("Y-m-d"))))); 
															} else {
																echo esc_html(wp_strip_all_tags(wc_price($this->get_total_discount(date_i18n("Y-m-d"), date_i18n("Y-m-d"))))); 
															}
		
															
															
															?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box6">
										<div class="card card-border-top card-border-top-box6  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Today Tax', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span
															class="f-right"><?php
															
															
															//echo esc_html(wp_strip_all_tags(wc_price($this->get_total_tax(date_i18n("Y-m-d"), date_i18n("Y-m-d")))));
															

															if ($this->is_hpos_enable == true) {

																echo esc_html(wp_strip_all_tags(wc_price($this->get_total_tax_hpos(date_i18n("Y-m-d"), date_i18n("Y-m-d")))));
															} else {
																echo esc_html(wp_strip_all_tags(wc_price($this->get_total_tax(date_i18n("Y-m-d"), date_i18n("Y-m-d")))));
															}
		

															
															?></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Stock Analysis', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-xl-3 col-md-6 col-lg-4   box10">
										<div class="card card-border-top card-border-top-box10  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase"><strong>
															<?php esc_html_e('Low in stock', 'nisalesreport'); ?></strong></h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"> <a
																href="<?php echo esc_url(admin_url("admin.php") . "?page=wc-reports&tab=stock&report=low_in_stock"); ?>"><?php echo esc_html($this->get_low_in_stock()); ?></a></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box1">
										<div class="card card-border-top card-border-top-box1  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Out of stock', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><a
																href="<?php echo esc_url(admin_url("admin.php") . "?page=wc-reports&tab=stock&report=out_of_stock"); ?>"><?php echo esc_html($this->get_out_of_stock()); ?></a></span>
													</h3>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 col-lg-4   box4">
										<div class="card card-border-top card-border-top-box4  shadow p-3 mb-5 bg-white rounded">
											<div class="card-body card-body-padding">
												<div class="card-block">
													<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
														<strong><?php esc_html_e('Most Stocked', 'nisalesreport'); ?></strong>
													</h6>
													<p class="text-right"><span>&nbsp;</span></p>
													<h3 class="m-b-0"><span class="f-right"><a
																href="<?php echo esc_url(admin_url("admin.php") . "?page=wc-reports&tab=stock&report=most_stocked"); ?>"><?php echo esc_html($this->get_most_stock()); ?></a></span>
													</h3>
												</div>
											</div>
										</div>
									</div>

									<?php do_action("ni_sales_report_dashboard_after_today_summary"); ?>
								</div>
							</div>

						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Yearly Sales', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<?php 
									
									$yearly = $this->get_yearly_sales();
									
									if ($this->is_hpos_enable == true) {
										$yearly = $this->get_yearly_sales_hpos();
									} else {
										$yearly = $this->get_yearly_sales();
									}
									
									?>


									<?php $i = 2; ?>
									<?php foreach ($yearly as $key => $value): ?>

										<div class="col-xl-3 col-md-6 col-lg-4 box<?php echo esc_attr($i); ?>">
											<div
												class="card card-border-top card-border-top-box<?php echo esc_attr($i); ?> shadow p-3 mb-5 bg-white rounded">
												<div class="card-body card-body-padding">
													<div class="card-block">
														<h6 class="m-b-20" style="font-size: 14px; text-transform: uppercase">
															<strong><?php echo esc_html($value->Year); ?></strong>
														</h6>
														<p class="text-right"><span>&nbsp;</span></p>
														<h3 class="m-b-0"><span class="f-right"> <a
																	href="<?php echo esc_url(admin_url("admin.php") . "?page=wc-reports&tab=stock&report=low_in_stock"); ?>"><?php echo esc_html(wp_strip_all_tags(wc_price($value->order_total))); ?></a></span>
														</h3>

													</div>
												</div>
											</div>
										</div>
										<?php $i++; ?>
									<?php endforeach; ?>





									<?php do_action("ni_sales_report_dashboard_after_today_summary"); ?>
								</div>
							</div>

						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('recent orders', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="table-responsive niwoosr-table">
										<table class="table table-striped table-hover">
											<thead class="shadow-sm p-3 mb-5 bg-white rounded">
												<tr>
													<th><?php esc_html_e('Order ID', 'nisalesreport'); ?></th>
													<th><?php esc_html_e('Order Date', 'nisalesreport'); ?> </th>
													<th><?php esc_html_e('First Name', 'nisalesreport'); ?> </th>
													<th><?php esc_html_e('Billing Email', 'nisalesreport'); ?></th>
													<th><?php esc_html_e('Country', 'nisalesreport'); ?> </th>
													<th><?php esc_html_e('Order Status', 'nisalesreport'); ?> </th>
													<th><?php esc_html_e('Currency', 'nisalesreport'); ?> </th>
													<th style="text-align:right">
														<?php esc_html_e('Order Total', 'nisalesreport'); ?>
													</th>
												</tr>
											</thead>

											<?php 
											
											//$order_data = $this->get_recent_order_list(); 
											if ($this->is_hpos_enable == true) {
												$order_data = $this->get_recent_order_list_hpos(); 
											} else {
												$order_data = $this->get_recent_order_list(); 
											}
											
											
											?>
											<?php foreach ($order_data as $key => $v) { ?>
												<tr>
													<td><?php echo esc_html($v->order_id); ?></td>
													<td><?php echo esc_html($v->order_date); ?></td>
													<td><?php echo isset($v->billing_first_name) ? esc_html($v->billing_first_name) : ''; ?>
													</td>
													<td><a
															href="mailto:<?php echo isset($v->billing_email) ? esc_attr($v->billing_email) : ''; ?>"><?php echo isset($v->billing_email) ? esc_html($v->billing_email) : ''; ?></a>
													</td>
													<td><?php echo esc_html($this->get_country_name(isset($v->billing_country) ? $v->billing_country : '')); ?>
													</td>
													<td><?php echo esc_html(ucfirst(str_replace("wc-", "", $v->order_status))); ?></td>
													<td><?php echo esc_html($v->order_currency); ?></td>
													<td style="text-align:right">
														<?php echo esc_html(wp_strip_all_tags(wc_price($v->order_total))); ?>
													</td>
												</tr>
											<?php } ?>
										</table>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Order Status', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<div class="table-responsive niwoosr-table">
											<table class="table table-striped table-hover">
												<thead class="shadow-sm p-3 mb-5 bg-white rounded">
													<tr>
														<th><?php esc_html_e('Order Status', 'nisalesreport'); ?></th>
														<th><?php esc_html_e('Order Count', 'nisalesreport'); ?></th>
														<th><?php esc_html_e('Order Total', 'nisalesreport'); ?></th>
													</tr>
												</thead>

												<?php
												 
												// $results = $this->get_order_status(); 
												if ($this->is_hpos_enable == true) {
													$results = $this->get_order_status_hpos(); 
												} else {
													$results = $this->get_order_status(); 
												}
												 
												 ?>
												<?php foreach ($results as $key => $value) { ?>
													<tr>
														<td><?php echo esc_html(ucfirst(str_replace("wc-", "", $value->order_status))); ?>
														</td>
														<td style="text-align:right"><?php echo esc_html($value->order_count); ?></td>
														<td style="text-align:right">
															<?php echo esc_html(wp_strip_all_tags(wc_price($value->order_total))); ?>
														</td>
													</tr>
												<?php } ?>
											</table>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<?php $data = array(); ?>
										<?php
										
										//$data = $this->get_order_status();
										 
												// $results = $this->get_order_status(); 
												if ($this->is_hpos_enable == true) {
													$data = $this->get_order_status_hpos(); 
												} else {
													$data = $this->get_order_status(); 
												}
										
										?>
										<?php
										$total = 0;
										foreach ($data as $k => $v) {
											$total = $total + $v->order_total;
										}
										foreach ($data as $k => $v) {
											$data[$k]->value = ($v->order_total / $total) * 100;

											$data[$k]->order_status = ucfirst(str_replace("wc-", "", $v->order_status));
											$data[$k]->order_total = wc_price($v->order_total);
										}
										?>
										<script type="text/javascript">
											var data = <?php echo wp_json_encode($data) ?>;
											var chart = AmCharts.makeChart("order_status2", {

												autoMargins: false,
												marginTop: 0,
												marginBottom: 0,
												marginLeft: 0,
												marginRight: 0,
												pullOutRadius: 0,
												"type": "pie",
												"theme": "light",
												"dataProvider": data,
												"valueField": "value",
												"titleField": "order_status",
												"outlineAlpha": 0.4,
												"depth3D": 15,
												"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[order_total]]</b> ([[percents]]%)</span>",
												"angle": 30,

												"maxLabelWidth": 100,
												"innerRadius": "0%",

												"export": {
													"enabled": false
												}
											});
										</script>
										<div id="order_status2" style="width:100%; height:250px"></div>
									</div>
								</div>



							</div>
						</div>

					</div>
				</div>

				<div class="row">
					<div class="col-md-12" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('payment gateway', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-sm-6 col-md-6 col-lg-6">
										<div class="table-responsive niwoosr-table">
											<table class="table table-striped table-hover">
												<thead class="shadow-sm p-3 mb-5 bg-white rounded">
													<tr>
														<th><?php esc_html_e('Payment Method', 'nisalesreport'); ?> </th>
														<th><?php esc_html_e('Order Count', 'nisalesreport'); ?></th>
														<th><?php esc_html_e('Order Total', 'nisalesreport'); ?></th>
													</tr>
												</thead>
												<?php 
												
												//$data = $this->get_payment_gateway();
												if ($this->is_hpos_enable == true) {
													$data = $this->get_payment_gateway_hpos(); 
												} else {
													$data = $this->get_payment_gateway(); 
												}
												
												
												?>
												
												<?php foreach ($data as $k => $v) { ?>
													<tr>
														<td><?php echo esc_html($v->payment_method_title); ?></td>
														<td><?php echo esc_html($v->order_count); ?></td>
														<td><?php echo esc_html(wp_strip_all_tags(wc_price($v->order_total))); ?>
														</td>
													</tr>
												<?php } ?>
											</table>
										</div>
									</div>
									<div class="col-sm-6 col-md-6 col-lg-6">
										<?php $data = array(); ?>
										<?php 
										
										//$data = $this->get_payment_gateway(); 
										
										if ($this->is_hpos_enable == true) {
											$data = $this->get_payment_gateway_hpos(); 
										} else {
											$data = $this->get_payment_gateway(); 
										}

										?>
										<?php
										$total = 0;
										foreach ($data as $k => $v) {
											$total = $total + $v->order_total;
										}
										foreach ($data as $k => $v) {
											$data[$k]->value = ($v->order_total / $total) * 100;
											//$data[$k]->payment_method_title =  "A";
											$data[$k]->order_total = wc_price($v->order_total);

										}
										?>
										<script type="text/javascript">
											var data = <?php echo wp_json_encode($data) ?>;
											var chart = AmCharts.makeChart("_payment_gateway_pie_chart", {
												labelsEnabled: true,
												autoMargins: false,
												marginTop: 0,
												marginBottom: 0,
												marginLeft: 0,
												marginRight: 0,
												pullOutRadius: 0,
												"type": "pie",
												"theme": "light",
												"dataProvider": data,
												"valueField": "value",
												"titleField": "payment_method_title",
												"outlineAlpha": 0.4,
												"depth3D": 15,
												"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[order_total]]</b> ([[percents]]%)</span>",
												"angle": 30,

												"maxLabelWidth": 100,
												"innerRadius": "0%",

												"export": {
													"enabled": false
												}
											});
										</script>
										<div id="_payment_gateway_pie_chart" style="width:100%; height:250px"></div>
									</div>
								</div>



							</div>
						</div>

					</div>
				</div>

				<div class="row">
					<div class="col-md-6" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('Top 5 Customer Report', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">

									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="table-responsive niwoosr-table">
											<table class="table table-striped table-hover">
												<thead class="shadow-sm p-3 mb-5 bg-white rounded">
													<tr>
														<th><?php esc_html_e('First Name', 'nisalesreport'); ?> </th>
														<th><?php esc_html_e('Email Address', 'nisalesreport'); ?></th>
														<th><?php esc_html_e('Order Count', 'nisalesreport'); ?></th>
														<th><?php esc_html_e('Order Total', 'nisalesreport'); ?></th>
													</tr>
												</thead>

												<?php 
												//$data = $this->get_customer_report(); 

												if ($this->is_hpos_enable == true) {
													$data = $this->get_customer_report_hpos(); 
												} else {
													$data = $this->get_customer_report(); 
												}
												
												?>
												<?php
												if (count($data) == 0) {
													?>
													<tr>
														<td colspan="4"><?php esc_html_e('No Customer found', 'nisalesreport'); ?></td>
													</tr>
													<?php
												}
												?>
												<?php foreach ($data as $k => $v) { ?>
													<tr>
														<td><?php echo isset($v->billing_first_name) ? esc_html($v->billing_first_name) : ''; ?>
														</td>
														<td><?php echo isset($v->billing_email) ? antispambot(esc_html($v->billing_email)) : ''; ?>
														</td>
														<td><?php echo isset($v->order_count) ? esc_html($v->order_count) : ''; ?></td>
														<td><?php echo esc_html(wp_strip_all_tags($this->get_price($v->order_total))); ?>
														</td>
													</tr>
												<?php } ?>
											</table>
										</div>
									</div>
								</div>



							</div>
						</div>

					</div>
					<div class="col-md-6" style="padding:0px;">
						<div class="card">
							<div class="card-header niwoosr-bg-c-purple">
								<?php esc_html_e('TOP 5 Country REPORT', 'nisalesreport'); ?>
							</div>
							<div class="card-body ">
								<div class="row">
									<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="table-responsive niwoosr-table">
											<div class="col-sm-12 col-md-12 col-lg-12">
												<table class="table table-striped table-hover">
													<thead class="shadow-sm p-3 mb-5 bg-white rounded">
														<tr>
															<th><?php esc_html_e('Country', 'nisalesreport'); ?></th>
															<th><?php esc_html_e('Order Count', 'nisalesreport'); ?></th>
															<th><?php esc_html_e('Order Total', 'nisalesreport'); ?></th>
														</tr>
													</thead>

													<?php
													
													//$data = $this->get_country_report(); 
													
													if ($this->is_hpos_enable == true) {
														$data = $this->get_country_report_hpos(); 
													} else {
														$data = $this->get_country_report(); 
													}


													?>

													<?php foreach ($data as $k => $v) { ?>
														<tr>
															<td><?php echo esc_html($this->get_country_name($v->billing_country)); ?>
															</td>
															<td><?php echo esc_html($v->order_count); ?></td>
															<td><?php echo esc_html(wp_strip_all_tags($this->get_price($v->order_total))); ?>
															</td>
														</tr>
													<?php } ?>
												</table>
											</div>
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

		function get_total_sales_hpos($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$today_date = date_i18n("Y-m-d");
			$query = array();
			$query[] = " SELECT
					SUM(posts.total_amount) as total_sales
					FROM {$wpdb->prefix}wc_orders as posts          
					
					
					WHERE 1=1
					AND posts.type ='shop_order' ";


			$query[] = " AND posts.status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed')
						
						";
			if ($period == "YESTERDAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) = DATE_SUB(%s, INTERVAL 1 DAY)", '%Y-%m-%d', $today_date);
			}
			if ($period == "DAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) = %s ", '%Y-%m-%d', $today_date);
				$query[] = " GROUP BY  date_format( posts.date_created_gmt, '%Y-%m-%d') ";


			}
			if ($period == "WEEK") {

				$query[] = " AND YEAR(date_format( posts.date_created_gmt, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  WEEK(date_format( posts.date_created_gmt, '%Y-%m-%d')) = WEEK(CURRENT_DATE()) ";
			}
			if ($period == "MONTH") {

				$query[] = " AND YEAR(date_format( posts.date_created_gmt, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  MONTH(date_format( posts.date_created_gmt, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";
			}
			if ($period == "YEAR") {

				$query[] = $wpdb->prepare(" AND YEAR(date_format( posts.date_created_gmt, %s)) = YEAR(date_format(NOW(), %s)) ", '%Y-%m-%d', '%Y-%m-%d');
			}
			$query[] = " AND  posts.status NOT IN ('trash')";


			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared		
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;

		}

		function get_total_sales($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$today_date = date_i18n("Y-m-d");
			$query = array();
			$query[] = " SELECT
					SUM(order_total.meta_value) as total_sales
					FROM {$wpdb->prefix}posts as posts          
					LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID 
					
					WHERE 1=1
					AND posts.post_type ='shop_order' 
					AND order_total.meta_key='_order_total' ";

			$query[] = " AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed')
						
						";
			if ($period == "YESTERDAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) = DATE_SUB(%s, INTERVAL 1 DAY)", '%Y-%m-%d', $today_date);
			}
			if ($period == "DAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) = %s ", '%Y-%m-%d', $today_date);
				$query[] = " GROUP BY  date_format( posts.post_date, '%Y-%m-%d') ";


			}
			if ($period == "WEEK") {

				$query[] = " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  WEEK(date_format( posts.post_date, '%Y-%m-%d')) = WEEK(CURRENT_DATE()) ";
			}
			if ($period == "MONTH") {

				$query[] = " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  MONTH(date_format( posts.post_date, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";
			}
			if ($period == "YEAR") {

				$query[] = $wpdb->prepare(" AND YEAR(date_format( posts.post_date, %s)) = YEAR(date_format(NOW(), %s)) ", '%Y-%m-%d', '%Y-%m-%d');
			}
			$query[] = " AND  posts.post_status NOT IN ('trash')";


			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared		
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;
		}


		function get_total_sales_count($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$query = array();
			$query[] = " SELECT
					count(order_total.meta_value) as sales_count
					FROM {$wpdb->prefix}posts as posts          
					LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID 
					
					WHERE  1 = 1
					AND posts.post_type ='shop_order' 
					AND order_total.meta_key='_order_total' ";
			//if ($start_date!=NULL && $end_date!=NULL)
			//$query .=" AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query[] = " AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed') ";

			if ($period == "YESTERDAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) = DATE_SUB(%s, INTERVAL 1 DAY) ", '%Y-%m-%d', $today_date);
			}
			if ($period == "DAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) = %s ", '%Y-%m-%d', $today_date);
				$query[] = " GROUP BY  date_format( posts.post_date, '%Y-%m-%d') ";


			}
			if ($period == "WEEK") {
				//$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 WEEK) "; 
				$query[] = " AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  WEEK(date_format( posts.post_date, '%Y-%m-%d')) = WEEK(CURRENT_DATE()) ";
			}
			if ($period == "MONTH") {
				//  $query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 MONTH) "; 

				$query[] = "  AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  MONTH(date_format( posts.post_date, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";

			}
			if ($period == "YEAR") {
				//$query .= " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(NOW(), '%Y-%m-%d')) "; 
				$query[] = $wpdb->prepare(" AND YEAR(date_format( posts.post_date, %s)) = YEAR(date_format(NOW(), %s)) ", '%Y-%m-%d', '%Y-%m-%d');
			}
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;
		}
		function get_total_sales_count_hpos($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$query = array();
			$query[] = " SELECT
					count(*) as sales_count
					FROM {$wpdb->prefix}wc_orders as posts          
					
					
					WHERE  1 = 1
					AND posts.type ='shop_order'  ";

			$query[] = " AND posts.status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed') ";

			if ($period == "YESTERDAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) = DATE_SUB(%s, INTERVAL 1 DAY) ", '%Y-%m-%d', $today_date);
			}
			if ($period == "DAY") {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) = %s ", '%Y-%m-%d', $today_date);
				$query[] = " GROUP BY  date_format( posts.date_created_gmt, '%Y-%m-%d') ";


			}
			if ($period == "WEEK") {
				//$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 WEEK) "; 
				$query[] = " AND  YEAR(date_format( posts.date_created_gmt, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  WEEK(date_format( posts.date_created_gmt, '%Y-%m-%d')) = WEEK(CURRENT_DATE()) ";
			}
			if ($period == "MONTH") {
				//  $query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 MONTH) "; 

				$query[] = "  AND  YEAR(date_format( posts.date_created_gmt, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
			  MONTH(date_format( posts.date_created_gmt, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";

			}
			if ($period == "YEAR") {
				//$query .= " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(NOW(), '%Y-%m-%d')) "; 
				$query[] = $wpdb->prepare(" AND YEAR(date_format( posts.date_created_gmt, %s)) = YEAR(date_format(NOW(), %s)) ", '%Y-%m-%d', '%Y-%m-%d');
			}
			$query[] = " AND  posts.status NOT IN ('trash')";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;
		}

		function get_total_sales_count1($period = "CUSTOM", $start_date = NULL, $end_date = NULL)
		{
			$today_date = date_i18n("Y-m-d");
			global $wpdb;
			$query = "SELECT
					count(order_total.meta_value)as 'sales_count'
					FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID 
					
					WHERE  1 = 1
					AND posts.post_type ='shop_order' 
					AND order_total.meta_key='_order_total' ";
			//if ($start_date!=NULL && $end_date!=NULL)
			//$query .=" AND   date_format( posts.post_date, '%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
			$query .= " AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed') ";

			if ($period == "YESTERDAY") {
				$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') = DATE_SUB('$today_date', INTERVAL 1 DAY) ";
			}
			if ($period == "DAY") {
				$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') = '{$today_date}' ";
				$query .= " GROUP BY  date_format( posts.post_date, '%Y-%m-%d') ";


			}
			if ($period == "WEEK") {
				//$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 WEEK) "; 
				$query .= "  AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
      WEEK(date_format( posts.post_date, '%Y-%m-%d')) = WEEK(CURRENT_DATE()) ";
			}
			if ($period == "MONTH") {
				//	$query .= " AND   date_format( posts.post_date, '%Y-%m-%d') > DATE_SUB(date_format(NOW(), '%Y-%m-%d'), INTERVAL 1 MONTH) "; 

				$query .= "  AND  YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(CURRENT_DATE()) AND 
      MONTH(date_format( posts.post_date, '%Y-%m-%d')) = MONTH(CURRENT_DATE()) ";

			}
			if ($period == "YEAR") {
				//$query .= " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(NOW(), '%Y-%m-%d')) "; 
				$query .= " AND YEAR(date_format( posts.post_date, '%Y-%m-%d')) = YEAR(date_format(NOW(), '%Y-%m-%d')) ";
			}
			$query .= " AND  posts.post_status NOT IN ('trash')";
			//echo $query;
			//$results = $wpdb->get_var($query);	
			$results = isset($results) ? $results : "0";
			return $results;
		}
		function get_recent_order_list_hpos()
		{
			global $wpdb;
			$order_data  = array();
			$query = array();
			$query[] = " SELECT
				posts.ID as order_id
				,posts.status as order_status
				,posts.total_amount as order_total
				,posts.currency as order_currency
				
				
				 ";
				

			$query[] = " , date_format( posts.date_created_gmt, '%Y-%m-%d') as order_date  ";

			$query[] = " FROM {$wpdb->prefix}wc_orders as posts	";

			//$query[] = " LEFT JOIN  {$wpdb->prefix}wc_order_addresses as order_total ON order_total.post_id=posts.ID  ";

			$query[] = " WHERE 
						posts.type ='shop_order' 
						
						AND posts.status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed' ,'wc-cancelled' ,  'wc-refunded' ,'wc-failed')
						
						";
			$query[] = " AND  posts.status NOT IN ('trash')";
			$query[] = " order by posts.date_created_gmt DESC";
			$query[] = " LIMIT 10 ";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$order_data = $wpdb->get_results(implode(' ', $query));

			//$this->print_data($order_data);
			if (count($order_data) > 0) {
				foreach ($order_data as $k => $v) {

					/*Order Data*/
					$order_id = $v->order_id;
				//	$order_detail = $this->get_order_detail($order_id);
				$order_detail = $this->get_address_detail_hpos($order_id);
					foreach ($order_detail as $dkey => $dvalue) {
						$order_data[$k]->$dkey = $dvalue;

					}

				}
			} else {
				$order_data = array();
			}
			return $order_data;
		}
		function get_address_detail_hpos($order_id=0, $address_type = 'billing')
		{
			global $wpdb;
			$order_data  = array();
			$address_data = array();
			$query = array();

			$query[] = " SELECT
				addresses.first_name as first_name
				,addresses.email as email
				,addresses.country as country
				
				
				 ";
				

			//$query[] = " , date_format( posts.date_created_gmt, '%Y-%m-%d') as order_date  ";

			$query[] = " FROM {$wpdb->prefix}wc_order_addresses as addresses	";


			$query[] = " WHERE  addresses.address_type ='". $address_type. "'" ;

			$order_data = $wpdb->get_results(implode(' ', $query));

			//$this->print_data($order_data);

			foreach( $order_data as $k => $v ) {
				//$this->print_data($v->first_name);
				$address_data["billing_first_name"] = isset($v->first_name)?$v->first_name:"";
				$address_data["billing_email"] = isset($v->email)?$v->email:"";
				$address_data["billing_country"] = isset($v->country)?$v->country:"";
			}

			return $address_data ;

		}
		function get_recent_order_list()
		{
			global $wpdb;
			$order_data  = array();
			$query = array();
			$query[] = " SELECT
				posts.ID as order_id
				,posts.post_status as order_status ";

			$query[] = " , date_format( posts.post_date, '%Y-%m-%d') as order_date  ";

			$query[] = " FROM {$wpdb->prefix}posts as posts	";

			$query[] = " WHERE 
						posts.post_type ='shop_order' 
						
						AND posts.post_status IN ('wc-pending','wc-processing','wc-on-hold', 'wc-completed' ,'wc-cancelled' ,  'wc-refunded' ,'wc-failed')
						
						";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			$query[] = " order by posts.post_date DESC";
			$query[] = " LIMIT 10 ";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$order_data = $wpdb->get_results(implode(' ', $query));
			if (count($order_data) > 0) {
				foreach ($order_data as $k => $v) {

					/*Order Data*/
					$order_id = $v->order_id;
					$order_detail = $this->get_order_detail($order_id);
					foreach ($order_detail as $dkey => $dvalue) {
						$order_data[$k]->$dkey = $dvalue;

					}

				}
			} else {
				$order_data = array();
			}
			return $order_data;
		}
	
		function get_order_status_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				posts.ID as order_id
				,posts.status as order_status
				,date_format( posts.date_created_gmt, '%Y-%m-%d') as order_date 
				,SUM(posts.total_amount) as 'order_total'
				,count(posts. status) as order_count
				FROM {$wpdb->prefix}wc_orders as posts	";

			//$query[] =	"	LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID ";

			$query[] = " WHERE 1=1 ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}


		//	$query[] = " AND postmeta.meta_key ='_order_total' ";
			$query[] = " AND posts.type ='shop_order' ";
			$query[] = " AND  posts.status NOT IN ('trash')";
			$query[] = " GROUP BY posts.status ";

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_results(implode(' ', $query));
			return $results;
		}
		function get_order_status($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				posts.ID as order_id
				,posts.post_status as order_status
				,date_format( posts.post_date, '%Y-%m-%d') as order_date 
				,SUM(postmeta.meta_value) as 'order_total'
				,count(posts.post_status) as order_count
				FROM {$wpdb->prefix}posts as posts	";

			$query[] =
				"	LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=posts.ID ";

			$query[] = " WHERE 1=1 ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}


			$query[] = " AND postmeta.meta_key ='_order_total' ";
			$query[] = " AND posts.post_type ='shop_order' ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			$query[] = " GROUP BY posts.post_status ";

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_results(implode(' ', $query));
			return $results;
		}
		

		function get_payment_gateway_hpos()
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				posts.payment_method_title as 'payment_method_title'
				
				,SUM(posts.total_amount) as 'order_total'
				,count(*) as order_count
				FROM {$wpdb->prefix}wc_orders as posts	";



			//$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";

			//$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as payment_method_title ON payment_method_title.post_id=posts.ID ";


			$query[] = "WHERE 1=1 ";

			$query[] = " AND posts.type ='shop_order' ";
			//$query[] = " AND order_total.meta_key ='_order_total' ";
			//$query[] = " AND payment_method_title.meta_key ='_payment_method_title' ";
			$query[] = " AND  posts.status NOT IN ('trash')";
			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			$query[] = " GROUP BY posts.payment_method";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));

			return $rows;
		}
		function get_payment_gateway()
		{
			global $wpdb;
			$query = array();
			$query[] = "
				SELECT 
				payment_method_title.meta_value as 'payment_method_title'
				
				,SUM(order_total.meta_value) as 'order_total'
				,count(*) as order_count
				FROM {$wpdb->prefix}posts as posts	";



			$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as order_total ON order_total.post_id=posts.ID ";

			$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as payment_method_title ON payment_method_title.post_id=posts.ID ";


			$query[] = "WHERE 1=1 ";

			$query[] = " AND posts.post_type ='shop_order' ";
			$query[] = " AND order_total.meta_key ='_order_total' ";
			$query[] = " AND payment_method_title.meta_key ='_payment_method_title' ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			$query[] = " GROUP BY payment_method_title.meta_value";
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_results(implode(' ', $query));

			return $rows;
		}
		function get_sold_product_count($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT  SUM(qty.meta_value) as sold_product_count  ";
			$query[] = " FROM {$wpdb->prefix}posts as posts ";
			$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as line_item ON line_item.order_id=posts.ID  ";

			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=line_item.order_item_id  ";

			$query[] = " WHERE 1=1 ";


			$query[] = " AND posts.post_type ='shop_order' ";
			$query[] = " AND qty.meta_key ='_qty' ";
			$query[] = " AND line_item.order_item_type ='line_item' ";
			$query[] = " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed')";

			$query[] = " AND  posts.post_status NOT IN ('trash')";
			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;

		}
		function get_sold_product_count_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT  SUM(qty.meta_value) as sold_product_count  ";
			$query[] = " FROM {$wpdb->prefix}wc_orders as posts ";
			$query[] = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as line_item ON line_item.order_id=posts.ID  ";

			$query[] = "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=line_item.order_item_id  ";

			$query[] = " WHERE 1=1 ";


			$query[] = " AND posts.type ='shop_order' ";
			$query[] = " AND qty.meta_key ='_qty' ";
			$query[] = " AND line_item.order_item_type ='line_item' ";
			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";

			$query[] = " AND  posts.status NOT IN ('trash')";
			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			$results = isset($results) ? $results : "0";
			return $results;

		}


		function get_sold_product_count1($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = " SELECT  SUM(qty.meta_value) as sold_product_count  ";
			$query .= " FROM {$wpdb->prefix}posts as posts ";
			$query .= " LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as line_item ON line_item.order_id=posts.ID  ";

			$query .= "  LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as qty ON qty.order_item_id=line_item.order_item_id  ";

			$query .= " WHERE 1=1 ";


			$query .= " AND posts.post_type ='shop_order' ";
			$query .= " AND qty.meta_key ='_qty' ";
			$query .= " AND line_item.order_item_type ='line_item' ";
			$query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed')";

			$query .= " AND  posts.post_status NOT IN ('trash')";
			if ($start_date && $end_date)
				$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date}'";

			//$results = $wpdb->get_var($query);	
			$results = isset($results) ? $results : "0";
			return $results;

		}
		function get_total_discount($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = "  SELECT
					
					SUM(woocommerce_order_itemmeta.meta_value) as total_discount
					
					FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID 
					
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=woocommerce_order_items.order_item_id 
					
					
					WHERE 1=1
					AND posts.post_type ='shop_order'  ";

			$query[] = " AND woocommerce_order_items.order_item_type ='coupon' ";

			$query[] = " AND woocommerce_order_itemmeta.meta_key ='discount_amount' ";

			$query[] = " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed') ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_var(implode(' ', $query));
			return $rows;
			//$this->print_data($results);
		}
		function get_total_discount_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = "  SELECT
					
					SUM(woocommerce_order_itemmeta.meta_value) as total_discount
					
					FROM {$wpdb->prefix}wc_orders as posts			
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID 
					
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=woocommerce_order_items.order_item_id 
					
					
					WHERE 1=1
					AND posts.type ='shop_order'  ";

			$query[] = " AND woocommerce_order_items.order_item_type ='coupon' ";

			$query[] = " AND woocommerce_order_itemmeta.meta_key ='discount_amount' ";

			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed') ";
			$query[] = " AND  posts.status NOT IN ('trash')";
			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s ) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$rows = $wpdb->get_var(implode(' ', $query));
			return $rows;
			//$this->print_data($results);
		}
		function get_total_discount1($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = "";
			$query = " SELECT
					
					SUM(woocommerce_order_itemmeta.meta_value) as total_discount
					
					FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID 
					
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=woocommerce_order_items.order_item_id 
					
					
					WHERE 1=1
					AND posts.post_type ='shop_order'  ";

			$query .= " AND woocommerce_order_items.order_item_type ='coupon' ";

			$query .= " AND woocommerce_order_itemmeta.meta_key ='discount_amount' ";

			$query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed') ";
			$query .= " AND  posts.post_status NOT IN ('trash')";
			if ($start_date && $end_date)
				$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date}'";

			//$results = $wpdb->get_var( $query);	
			return $results;
			//$this->print_data($results);
		}
		function get_total_tax($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;

			$query = array();
			$query[] = " SELECT ";

			//10.13		
			$query[] = "	(ROUND(SUM(woocommerce_order_itemmeta.meta_value),2)+  ROUND(SUM(shipping_tax_amount.meta_value),2)) as total_tax ";

			//10.12
			//$query .= "	(SUM(ROUND(woocommerce_order_itemmeta.meta_value,2))+  SUM(ROUND(shipping_tax_amount.meta_value,2))) as total_tax ";

			$query[] = "	 FROM {$wpdb->prefix}posts as posts			
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.ID 
					
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=woocommerce_order_items.order_item_id 
					
					
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as shipping_tax_amount ON shipping_tax_amount.order_item_id=woocommerce_order_items.order_item_id 
					
					
					
					WHERE 1=1
					AND posts.post_type ='shop_order'  ";

			$query[] = " AND woocommerce_order_items.order_item_type ='tax' ";

			$query[] = " AND woocommerce_order_itemmeta.meta_key ='tax_amount' ";

			$query[] = " AND shipping_tax_amount.meta_key ='shipping_tax_amount' ";

			//$query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed','wc-pending') ";

			$query[] = " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			$query[] = " AND  posts.post_status NOT IN ('trash')";
			/*
							  if ($this->report_order_status ==""){
									  $query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed','wc-refunded')";
							  }else{
								   $query .= " AND posts.post_status IN ('{$this->report_order_status}')";
							  }
							  */

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare("  AND date_format( posts.post_date, %s) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			return $results;
			//$this->print_data($results);
		}
		function get_total_tax_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;

			$query = array();
			$query[] = " SELECT ";

			//10.13		
			//$query[] = "	(ROUND(SUM(posts.tax_amount),2)) +  ROUND(SUM(shipping_tax_amount.meta_value),2)) as total_tax ";
			$query[] = "	(ROUND(SUM(posts.tax_amount),2)+  ROUND(SUM(shipping_tax_amount.meta_value),2)) as total_tax ";

			//10.12
			//$query .= "	(SUM(ROUND(woocommerce_order_itemmeta.meta_value,2))+  SUM(ROUND(shipping_tax_amount.meta_value,2))) as total_tax ";

			$query[] = "	 FROM {$wpdb->prefix}wc_orders as posts			
					
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items ON woocommerce_order_items.order_id=posts.id 
					
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=woocommerce_order_items.order_item_id 
			
			
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as shipping_tax_amount ON shipping_tax_amount.order_item_id=woocommerce_order_items.order_item_id 
					
					WHERE 1=1
					AND posts.type ='shop_order'  ";

		

			//$query .= " AND posts.post_status IN ('wc-processing','wc-on-hold', 'wc-completed','wc-pending') ";

			$query[] = " AND posts.status IN ('wc-processing','wc-on-hold', 'wc-completed')";
			$query[] = " AND  posts.status NOT IN ('trash')";
			
			$query[] = " AND shipping_tax_amount.meta_key ='shipping_tax_amount' ";
			$query[] = " AND woocommerce_order_items.order_item_type ='tax' ";

			$query[] = " AND woocommerce_order_itemmeta.meta_key ='tax_amount' ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare("  AND date_format( posts.date_created_gmt, %s) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$results = $wpdb->get_var(implode(' ', $query));
			return $results;
			//$this->print_data($results);
		}

		function get_order_detail($order_id)
		{
			$order_detail = get_post_meta($order_id);
			$order_detail_array = array();
			foreach ($order_detail as $k => $v) {
				$k = substr($k, 1);
				$order_detail_array[$k] = $v[0];
			}
			return $order_detail_array;
		}

		function get_customer($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT COUNT(customer_user.meta_value) as count ";

			$query[] = "	 FROM {$wpdb->prefix}posts as posts		";
			$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as customer_user ON customer_user.post_id=posts.ID ";
			$query[] = "	WHERE 1=1 ";
			$query[] = " AND posts.post_type ='shop_order'  ";
			$query[] = " AND customer_user.meta_key ='_customer_user' ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) BETWEEN  %s AND  %s ", '%Y-%m-%d', $start_date, $end_date);
			}

			$query[] = " AND customer_user.meta_value >0 ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";

			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;
		}
		function get_customer_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT COUNT(DISTINCT posts.customer_id) as count ";

			$query[] = "	 FROM {$wpdb->prefix}wc_orders as posts		";

			$query[] = "	WHERE 1=1 ";
			$query[] = " AND posts.type ='shop_order'  ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) BETWEEN  %s AND  %s ", '%Y-%m-%d', $start_date, $end_date);
			}

			$query[] = " AND posts.customer_id !=0 ";
			$query[] = " AND  posts.status NOT IN ('trash')";

			$query[] = " GROUP BY posts.customer_id "; // Group by customer ID
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;
		}

		function get_guest_customer($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT COUNT(customer_user.meta_value) as count ";

			$query[] = "	 FROM {$wpdb->prefix}posts as posts		";
			$query[] = "	LEFT JOIN  {$wpdb->prefix}postmeta as customer_user ON customer_user.post_id=posts.ID ";
			$query[] = "	WHERE 1=1 ";
			$query[] = " AND posts.post_type ='shop_order'  ";
			$query[] = " AND customer_user.meta_key ='_customer_user' ";

			$query[] = " AND customer_user.meta_value=0 ";
			$query[] = " AND  posts.post_status NOT IN ('trash')";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.post_date, %s) BETWEEN  %s AND %s ", '%Y-%m-%d', $start_date, $end_date);
			}
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_var(implode(' ', $query));

			//$this->print_data($row);
			return $row;
		}
		function get_guest_customer_hpos($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = array();
			$query[] = " SELECT COUNT(*) as count ";

			$query[] = "	 FROM {$wpdb->prefix}wc_orders as posts		";

			$query[] = "	WHERE 1=1 ";
			$query[] = " AND posts.type ='shop_order'  ";

			if ($start_date && $end_date) {
				$query[] = $wpdb->prepare(" AND date_format( posts.date_created_gmt, %s) BETWEEN  %s AND  %s ", '%Y-%m-%d', $start_date, $end_date);
			}

			$query[] = " AND posts.customer_id =0 ";
			$query[] = " AND  posts.status NOT IN ('trash')";

			$query[] = " GROUP BY posts.customer_id "; // Group by customer ID
			// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$row = $wpdb->get_var(implode(' ', $query));

			return $row;
		}

		function get_guest_customer1($start_date = NULL, $end_date = NULL)
		{
			global $wpdb;
			$query = "";
			$query .= " SELECT COUNT(customer_user.meta_value) as count ";

			$query .= "	 FROM {$wpdb->prefix}posts as posts		";
			$query .= "	LEFT JOIN  {$wpdb->prefix}postmeta as customer_user ON customer_user.post_id=posts.ID ";
			$query .= "	WHERE 1=1 ";
			$query .= " AND posts.post_type ='shop_order'  ";
			$query .= " AND customer_user.meta_key ='_customer_user' ";

			$query .= " AND customer_user.meta_value=0 ";
			$query .= " AND  posts.post_status NOT IN ('trash')";

			if ($start_date && $end_date) {
				$query .= " AND date_format( posts.post_date, '%Y-%m-%d') BETWEEN  '{$start_date}' AND '{$end_date}'";
			}

			//$row = $wpdb->get_var($query);	

			//$this->print_data($row);
			return $row;
		}
	}
}
?>