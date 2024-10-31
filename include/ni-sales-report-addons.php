<?php
if ( ! defined( 'ABSPATH' ) ) { exit;}
if( !class_exists( 'ni_sales_report_addons' ) ) {
	class ni_sales_report_addons{
		public function __construct(){
			
		}
		function page_init(){
		?>
        <div class="container-fluid" id="niwoosalesreport">
        	 <div class="row">
             	<div class="col-md-12"  style="padding:0px;">
					<div class="card" style="max-width:1000% ">
						<div class="card-header niwoosr-bg-c-purple">
							<?php esc_html_e(  'Hire us for plugin Development and Customization', 'nisalesreport') ?>
						</div>
						<div class="card-body">
							 <p>
							<?php esc_html_e(  ' Our area of expertise is WordPress and custom plugins development. We specialize in creating custom plugin solutions for your business needs', 'nisalesreport') ?>
                           .</p>
                            <p><?php esc_html_e(  'Email us', 'nisalesreport') ?>: <strong><a href="mailto:support@naziinfotech.com">support@naziinfotech.com</a></strong></p>
                          
                            <div class="row">
                            	<div class="col-md-12">
                                <h3  class="box4"><?php esc_html_e(  'Our Other Free Wordpress Plugins', 'nisalesreport') ?></h3>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-md-4">
                                	<h6 class="text-success">Ni WooCommerce Cost Of Goods</h6>
                                    <ul class="list-group" >
                                    	<li class="list-group-item">Ability to add the cost of goods for simple and variation product</li>
                                    	<li class="list-group-item">Dashboard report provide the total, monthly, yearly and daily sales amount, sales count, tax, and coupon</li>
                                    	<li class="list-group-item">Show sold product profit report</li>
                                        <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-cost-of-goods" target="_blank">View</a> 
                        				<a href="https://downloads.wordpress.org/plugin/ni-woocommerce-cost-of-goods.zip" target="_blank">Download</a> </li>
                        			</ul>
                                </div>
                                <div class="col-md-4">
                                <h6 class="text-success">Ni WooCommerce Custom Order Status</h6>
                                	<ul class="list-group">
                                        <li class="list-group-item">Add/Edit/Delete new WooCommerce order status</li>
                                        <li class="list-group-item">Set Color to the order status</li>
                                        <li class="list-group-item">Display order status list</li>
                                        <li class="list-group-item">Add order status slug </li>
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-woocommerce-custom-order-status" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-custom-order-status.zip" target="_blank">Download</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                 <h6 class="text-success">Ni Woocommerce Product Enquiry </h6>
                                
                        			<ul class="list-group">
                      					<li class="list-group-item">Display simple enquiry dashboard </li>
                            			<li class="list-group-item">Email Setting option</li>
                      					<li class="list-group-item">Display enquiry form on the product page </li>
                            			<li class="list-group-item">Send email to client or admin</li>
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-woocommerce-product-enquiry" target="_blank">View</a> 
                        <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-product-enquiry.zip" target="_blank">Download</a></li>
                    				</ul>
                       
                                </div>
                                <div class="col-md-4">
                                	<h6 class="text-success">Ni WooCommerce Order Export</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">Show the order summary on dashboard </li>
                                        <li class="list-group-item">Export customer billing details like billing name,customer email address, billing address details etc.</li>
                                        <li class="list-group-item">Order Status Report</li>
                                        <li class="list-group-item">Payment Gateway report</li>
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-woocommerce-sales-report-email" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-sales-report-email.zip" target="_blank">Download</a> </li>
                                    </ul>
                                   
                                </div>
                                <div class="col-md-4">
                                <h6 class="text-success">Ni WooCommerce Dashboard Report</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">Display the sales summary on WordPress admin dashboard.</li>
                                    <li class="list-group-item">Display the recent order on dashboard </li>
                                    <li class="list-group-item">Order status summary report</li>
                                    <li class="list-group-item">Show the sales analysis report on dashboard</li>
                                    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-invoice" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-invoice.zip" target="_blank">Download</a> </li>
                                </ul>
                        	
                                </div>
                                <div class="col-md-4">
                                	<h6 class="text-success">Ni WooCommerce Sales Report By User Role</h6>
                                    <ul class="list-group">
                                        <li>Ability to create new sales agent or sales person</li>
                                        <li>Assign order to sales agent or vendor</li>
                                        <li>Display the list of sales order with sales agent or <strong>sales person</strong> name</li>
                                        <li>Filter the sales order by sales person or sales agent.</li>
                                         <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-sales-report-by-user-role/" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-sales-report-by-user-role.zip" target="_blank">Download</a> </li>
                                    </ul>
                        
                                </div>
                                <div class="col-md-4">
                                 	<h6 class="text-success">Ni WooCommerce Sales Report Email</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">Display simple sales dashboard </li>
                                        <li class="list-group-item">Automatically email the daily sales report.</li>
                                        <li class="list-group-item">Email WooCommerce sales order list</li>
                                        <li class="list-group-item">Email setting option and enable/disable cron job</li>
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-woocommerce-sales-report-email" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-sales-report-email.zip" target="_blank">Download</a> </li>
                                    </ul>
                       
                                </div>
                                <div class="col-md-4">
                                	<h6 class="text-success">Ni WooCommerce Product Editor</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">Display simple, variable and variation product in tabular format</li>
                                        <li class="list-group-item">Provide the product filter by product name, mange backorder </li>
                                        <li class="list-group-item">Ajax pagination and Ajax filter and Ajax data saving for better user experience </li>
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-woocommerce-product-editor" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-woocommerce-product-editor.zip" target="_blank">Download</a> </li>
                                    </ul>
                       
                                </div>
                                
                                <div class="col-md-4">
                                	<h6 class="text-success">Ni One Page Inventory Management System For WooCommerce</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">PURCHASE ORDER SYSTEM</li>
                                        <li class="list-group-item">MULTI-LOCATION PURCHASE ORDER</li>
                                        <li class="list-group-item">INVENTORY MANAGEMENT</li>
                                        <li class="list-group-item">MANAGE PRODUCT</li>
                                        
                                        <li class="list-group-item"> <a href="https://wordpress.org/plugins/ni-one-page-inventory-management-system-for-woocommerce/" target="_blank">View</a> 
                                    <a href="https://downloads.wordpress.org/plugin/ni-one-page-inventory-management-system-for-woocommerce.zip" target="_blank">Download</a> </li>
                                    </ul>
                       
                                </div>
                                
                            </div>
                            <div class="row">
                            	<div class="col-md-12">
                                <h3 class="box4"><?php esc_html_e(  'All Free Plugins', 'nisalesreport') ?></h3>
                                	<ul class="list-group">
	
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-cost-of-goods/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Cost Of Goods</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-product-enquiry/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Product Enquiry</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-payment-gateway-charges/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Payment Gateway Charges</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-custom-order-status/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Custom Order Status</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-product-variations-table/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Product Variations Table</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-sales-report-by-user-role/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Sales Report By User Role</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-product-editor/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Product Editor</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-order-export/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Order Export</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-dashboard-report/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Dashboard Sales Report</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-sales-report-email/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Sales Report Email</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-admin-order-columns/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Admin Order Columns</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-invoice/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Invoice</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-crm-lead/"  class="ni_other_plugin_link" target="_blank">Ni CRM Lead</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-order-delivery/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Order Delivery</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-stock/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Stock</a>  </li>   
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-product-editor/"  class="ni_other_plugin_link" target="_blank">Ni WooCommerce Product Editor</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woocommerce-multi-currency-report/"  class="ni_other_plugin_link" target="_blank">WooCommerce Multi Currency Report</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-woo-sales-commission/"  class="ni_other_plugin_link" target="_blank">Ni Sales Commission For WooCommerce</a>  </li>
    <li class="list-group-item"><a href="https://wordpress.org/plugins/ni-one-page-inventory-management-system-for-woocommerce/"  class="ni_other_plugin_link" target="_blank">Ni One Page Inventory Management System For WooCommerce</a>  </li>
</ul>
                                </div>
                            </div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <?php	
		}
	}
}
?>