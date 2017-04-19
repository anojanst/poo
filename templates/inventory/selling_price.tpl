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
		source: "ajax/query_customer.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto2").autocomplete({
		source: "ajax/query_sales_no.php",
		minLength: 1
	});				

});
</script>

<script language="JavaScript" type="text/javascript">
  function product(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_product').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_product').style.visibility="hidden"; 
    }
  }
</script>
{/literal}
	<div id="contents">
		{include file="user_navigation.tpl"}
		{if $error_report=='on'}
		<div class="error_report" style="margin-bottom: 50px;">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		
		<div class="main_user_home" style="min-height: 300px;">
		
			<div style="width: 900px;">
				
				
				<table class="sales_table1">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Product Id</th>
							<th >Selling Price</th>
							<th width="70">Update</th>
						</tr>
					</thead>
					<tbody>
				{php}list_item_for_selling_price();{/php} 
							</tr>
				
						<td></td>
						<td></td>				
						<td></td>
						<td></td>
											
						<tr>
					</tbody>
				</table>
				
			</div>
		</div>
	</div>
{include file="user_footer.tpl"}