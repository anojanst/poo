{include file="user_header.tpl"}

{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_inventory.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto1").autocomplete({
		source: "ajax/query_suppliers.php",
		minLength: 1
	});				

});
</script>
{/literal}

	<div id="contents">
		{include file="user_navigation.tpl"}
			<div style="width: 910px; min-height: 50px; background-color: #f1f1f1; margin-bottom: 10px; float: left; margin-top: -40px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
			<form action="inv_full_report.php?job=search" method="post" class="product">
				<table style="margin-top: 0px; margin-left: 5px; margin-bottom: 10px;">
					<tr>
						<td colspan="2" align="center">Custom Report</td>
						<td align="center">Quick Reports</td>
					</tr>
					
					<tr>
						<td colspan="2">
							<input type="text" class='auto' name="product_name" value="{$product_name}" size="66" placeholder="Filter By Product Name"/> 
						</td>
						<td><a href="inv_full_report.php?job=product_on_demand" class="report_select">Products On Demand</a></td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="text" class='auto1' name="supplier" value="{$supplier}" size="66" placeholder="Filter By Supplier"/> 
						</td>
						<td><a href="inv_full_report.php?job=product_with_profit" class="report_select">Product With Profit</a></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="qty_less_than" value="{$qty_less_than}" size="30" placeholder="Filter By Stock (LESS THAN)"/> 
						</td>
						<td>
							OR <input type="text" name="qty_more_than" value="{$qty_more_than}" size="30" placeholder="Filter By Stock (MORE THAN)"/> 
						</td>
						<td><a href="inv_full_report.php?job=product_with_loss" class="report_select">Product With Loss</a></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="bp_less_than" value="{$bp_less_than}" size="30" placeholder="Filter By Buying Price (LESS THAN)"/> 
						</td>
						<td>
							OR <input type="text" name="bp_more_than" value="{$bp_more_than}" size="30" placeholder="Filter By Buying Price (MORE THAN)"/> 
						</td>
						<td><a href="inv_full_report.php?job=recently_purchased" class="report_select">Recently Puchased</a></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="sp_less_than" value="{$sp_less_than}" size="30" placeholder="Filter By Selling Price (LESS THAN)"/> 
						</td>
						<td>
							OR <input type="text" name="sp_more_than" value="{$sp_more_than}" size="30" placeholder="Filter By Selling Price (MORE THAN)"/> 
						</td>
						<td><a href="inv_full_report.php?job=without_sales" class="report_select">Products Without Sales</a></td>
					</tr>
					<tr>
						<td>
							<input type="text" name="purchased_after" value="{$purchased_after}" size="30" class="datepicker" placeholder="Filter By Purchase Date (AFTER)"/> 
						</td>
						<td>
							OR <input type="text" name="purchased_before" value="{$purchased_before}" size="30" class="datepicker" placeholder="Filter By Purchase Date (BEFORE)"/> 
						</td>
						<td><a href="inv_full_report.php?job=out_of_stock" class="report_select">Out of Stock Products</a></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="ok" value="Generate Report" style="float: none;"/></td>
						<td><a href="inv_full_report.php?job=catagory_list" class="report_select">Catagory Listing</a></td>
					</tr>
				</table>
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