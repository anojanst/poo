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
		<!-- Tabs within a box -->
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-9">
					<form action="inv_full_report.php?job=search" method="post" class="product">
						<h4><strong>Custom Report</strong></h4>
						<input type="text" class='auto form-control' name="product_name" value="{$product_name}" placeholder="Filter By Product Name"/>
						<input type="text" class='auto1 form-control' name="supplier" value="{$supplier}" placeholder="Filter By Supplier"/>
						<div class="row">
							<div class="col-lg-6">
								<input type="text" class='form-control'  name="qty_less_than" value="{$qty_less_than}" placeholder="Filter By Stock (LESS THAN)"/>
							</div>
							<div class="col-lg-6">
								 <input type="text" class='form-control' name="qty_more_than" value="{$qty_more_than}" placeholder="Filter By Stock (MORE THAN)"/> 
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<input type="text" class="form-control" name="bp_less_than" value="{$bp_less_than}" size="30" placeholder="Filter By Buying Price (LESS THAN)"/>  
							</div>
							<div class="col-lg-6">
								<input type="text" class="form-control" name="bp_more_than" value="{$bp_more_than}" size="30" placeholder="Filter By Buying Price (MORE THAN)"/>  
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<input type="text"  class="form-control" name="sp_less_than" value="{$sp_less_than}" placeholder="Filter By Selling Price (LESS THAN)"/>
							</div>
							<div class="col-lg-6">
								<input type="text"  class="form-control" name="sp_more_than" value="{$sp_more_than}" placeholder="Filter By Selling Price (MORE THAN)"/> 
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<input type="text" name="purchased_after" class="form-control" value="{$purchased_after}" id="datepicker" style="width: 250px;" placeholder="Filter By Purchase Date (AFTER)"/>  
							</div>
							<div class="col-lg-6">
								<input type="text" name="purchased_before" class="form-control" value="{$purchased_before}" id="datepicker1" style="width: 250px;" placeholder="Filter By Purchase Date (BEFORE)"/>
							</div>
						</div>
				</div>
				<div class="col-lg-3">
					<h4><strong>Quick Report</strong></h4>
					<a href="inv_full_report.php?job=product_on_demand" class="btn btn-xs btn-primary" style="width: 200px; height: 35px;"><span style="padding-top: 5px;">Products On Demand</span></a>
					<a href="inv_full_report.php?job=product_with_profit" class="btn btn-xs btn-danger" style="width: 200px; height: 35px";>Product With Profit</a>
					<a href="inv_full_report.php?job=product_with_loss" class="btn btn-xs btn-success" style="width: 200px; height: 35px";>Product With Loss</a>
					<a href="inv_full_report.php?job=recently_purchased" class="btn btn-xs btn-warning" style="width: 200px; height: 35px";>Recently Puchased</a>
					<a href="inv_full_report.php?job=without_sales" class="btn btn-xs btn-primary" style="width: 200px; height: 35px";>Products Without Sales</a>
					<a href="inv_full_report.php?job=out_of_stock" class="btn btn-xs btn-danger" style="width: 200px; height: 35px";>Out of Stock Products</a>
					<a href="inv_full_report.php?job=inv_stock" class="btn btn-xs btn-success" style="width: 200px; height: 35px";>Stock</a>
				</div>
			</div>
				<div class="row">
					<div  class="col-lg-12">
						<input type="submit" class ="pull left" name="ok" value="Generate Report" class="btn btn-xs btn-primary" style="width: 200px; height: 35px";/>
					</div>
				</div>
			</form>
		<div style="min-height: 300px; margin-top: 5px;">
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
		{if $inv_stock=='on'}
		{php}inv_stock();{/php}
		{else}
		{/if}
		{if $head_office_inv_stock=='on'}
		{php}head_office_inv_stock();{/php}
		{else}
		{/if}
		{if $without_sales=='on'}
		{php}without_sales();{/php}
		{else}
		{/if}
		{if $catagory_list=='on'}
		{php}CategoryList();{/php}
			{if $list_inventory_by_cat=='on'}
<br /><br />

			{php}list_inventory_by_cat($_SESSION['category']);{/php}
			{else}
			{/if}
		{else}
		{/if}
		</div>
		</div>
</section>

{include file="js_footer.tpl"}