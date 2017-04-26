{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
<script>
  $(function () { 
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>
<script>
  $(function () {
    
    $('#datepicker1').datepicker({
      autoclose: true
    });
  });
</script>
<script>
$(function () {
  $("#example1").DataTable();
});
</script>
{/literal}

	<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Sales Full Report</strong></h3>
				</div>
			</div>
            
			<div class="row" style="margin-top: 20px; margin-left: 10px;">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>
			
			<div class="row">
			<form action="inv_full_report.php?job=search" method="post" class="product">
				<div class="col-lg-9">
					<div class="row">
						<h4><strong>Custom Reportt</strong></h4>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<input type="text" class='form-control' name="product_name" value="{$product_name}" size="66" placeholder="Filter By Product Name"/> 
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12">
							<input type="text" class='form-control' name="supplier" value="{$supplier}" size="66" placeholder="Filter By Supplier"/> 
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="qty_less_than" value="{$qty_less_than}"  class='form-control' placeholder="Filter By Stock (LESS THAN)"/> 
						</div>
						<div class="col-lg-6">
							<input type="text" name="qty_more_than" value="{$qty_more_than}"  class='form-control' placeholder="Filter By Stock (MORE THAN)"/> 
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="bp_less_than" value="{$bp_less_than}"  class='form-control' placeholder="Filter By Buying Price (LESS THAN)"/> 
						</div>
						<div class="col-lg-6">
							<input type="text" name="bp_more_than" value="{$bp_more_than}"  class='form-control' placeholder="Filter By Buying Price (MORE THAN)"/> 
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="sp_less_than" value="{$sp_less_than}"  class='form-control' placeholder="Filter By Selling Price (LESS THAN)"/> 
						</div>
						<div class="col-lg-6">
							<input type="text" name="sp_more_than" value="{$sp_more_than}"  class='form-control' placeholder="Filter By Selling Price (MORE THAN)"/> 
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="purchased_after" value="{$purchased_after}"  class='form-control' class="datepicker" placeholder="Filter By Purchase Date (AFTER)"/> 
						</div>
						<div class="col-lg-6">
							<input type="text" name="purchased_before" value="{$purchased_before}"  class='form-control' class="datepicker" placeholder="Filter By Purchase Date (BEFORE)"/> 
						</div>
						
					</div>
					
					<div class="row">
						<input type="submit" name="ok" value="Generate Report" style="float: none;"/>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="row">
						<h4><strong>Quick Reports</strong></h4>
					</div>
					
					<div class="row">
						<a href="inv_full_report.php?job=product_on_demand" class="report_select">Products On Demand</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=product_with_profit" class="report_select">Product With Profit</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=product_with_loss" class="report_select">Product With Loss</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=without_sales" class="report_select">Products Without Sales</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=without_sales" class="report_select">Products Without Sales</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=out_of_stock" class="report_select">Out of Stock Products</a>
					</div>
					<div class="row">
						<a href="inv_full_report.php?job=catagory_list" class="report_select">Catagory Listing</a>
					</div>
				</div>
				
			</form>
			</div>
			
			
			<div class="main_user_home" style="min-height: 300px; margin-top: 5px;">
			{if $search_mode=='on'}
			{php}coustom_inventory_report($_SESSION[product_name], $_SESSION[supplier], $_SESSION[qty_less_than], $_SESSION[qty_more_than], $_SESSION[bp_less_than], $_SESSION[bp_more_than], $_SESSION[sp_less_than], $_SESSION[sp_more_than], $_SESSION[purchased_after], $_SESSION[purchased_before]);{/php}
			{else}
			{/if}
			{if $demand_report=='on'}
			{php}inventory_demand_report();{/php}
			{else}
			{/if}
			{if $product_profit_report=='on'}
			{php}product_profit_report();{/php}
			{else}
			{/if}
			{if $product_loss_report=='on'}
			{php}product_loss_report();{/php}
			{else}
			{/if}
			{if $recent_purchase=='on'}
			{php}recent_purchase_report();{/php}
			{else}
			{/if}
			{if $out_of_stock=='on'}
			{php}out_of_stock();{/php}
			{else}
			{/if}
			{if $without_sales=='on'}
			{php}without_sales();{/php}
			{else}
			{/if}
			{if $catagory_list=='on'}
			{php}catagory_listing();{/php}
			{else}
			{/if}
			</div>
		</div>

{include file="user_footer.tpl"}