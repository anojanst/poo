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
		{if $error_report=='on'}
		<div class="error_report">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		{if $warning_report=='on'}
		<div class="warning_report" style="margin-bottom: 50px;">
			<strong>{$warning_message}</strong>
		</div>
		{/if}
		<div class="main_user_home" style="min-height: 300px;">
			<div class="product_form" style="min-height: 500px;"> 
	
	<table style="float:left;">
			{if $cover}
			<tr>
				<td><img src="{$cover}" width="200" height="300"/></td>
			</tr>
			{/if}
			<tr>
				<td><a href="html/BCGcode39.php?barcode={$barcode}&product_id={$product_id}&price={$selling_price}&name={$product_name}&type={$type}" target="blank" class="report_select">Print Barcode</a></td>
			</tr>
			<tr>
				<td><a href="inventory.php?job=edit&id={$id}" class="report_select">Edit</a></td>
			</tr>
			<tr>
				<td><a href="inventory.php?job=add_new" class="report_select">Add new</a></td>
			</tr>
			
	</table>

		<table style="float:left; margin: 20px;">
			
			<tr>
				<td>Product Name</td>
				<td> :</td>
				<td>{$product_name}</td>
			</tr>
			<tr>		
				<td>Product ID</td>
				<td> :</td>
				<td>{$product_id}</td>		
			</tr>
			<tr>
				<td>Author</td>
				<td> :</td>
				<td>{$author}</td>
			</tr>
			<tr>
				<td>ISBN No</td>
				<td> :</td>
				<td>{$isbn}</td>						
			</tr>
			
			<tr>
				<td>Publication</td>
				<td> :</td>
				<td>{$publication}</td>	
			</tr>
			<tr>				
				<td>Supplier</td>
				<td> :</td>
				<td>{$supplier}</td>		
			</tr>
			
			<tr>
				<td>Selling Price</td>
				<td> :</td>
				<td>{$selling_price}</td>	
			</tr>
			<tr>
				<td>Selling Discount</td>
				<td> :</td>
				<td>{$discount}</td>		
			</tr>
			
			<tr>
				<td>Buying Price</td>
				<td> :</td>
				<td>{$buying_price}</td>
			</tr>
			<tr>	
				<td>Buying Discount</td>
				<td> :</td>
				<td>{$buying_discount}</td>		
			</tr>
			<tr>
				<td>Currency Type</td>
				<td> :</td>
				<td>{$type}</td>
			</tr>
			<tr>
				<td>Measure Type</td>
				<td> :</td>
				<td>{$measure_type}</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td> :</td>
				<td>{$count}</td>		
			</tr>
			<tr>	
				<td>Pur Date</td>
				<td>:</td>
				<td>{$purchased_date}</td>	
			</tr>
			<tr>
				<td>Exp Date</td>
				<td>:</td>
				<td>{$exp_date}</td>
			</tr>
			<tr>
				<td>Page</td>
				<td> :</td>
				<td>{$page_count}</td>
			</tr>
			<tr>				
				<td>Size  </td>
				<td> :</td>
				<td>{$size}</td>
			</tr>
			<tr>				
				<td>Weight</td>
				<td> :</td>
				<td>{$weight}</td>		
			</tr>
			<tr>
				<td>Description</td>
				<td> :</td>
				<td>{$product_description}</td>		
			</tr>
			<tr>
				<td>Label</td>
				<td> :</td>
				<td>{$label}</td>		
			</tr>

		</table>
		
</div>
		</div>
	</div>
	

{include file="user_footer.tpl"}