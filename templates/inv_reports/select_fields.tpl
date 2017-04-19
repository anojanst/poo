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
{/literal}

	<div id="contents">
		{include file="user_navigation.tpl"}
			<div style="width: 210px; min-height: 50px; background-color: #f1f1f1; margin-bottom: 10px; float: left; margin-top: -40px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
			<form action="inv_basic_report.php?job=custom" method="post" class="login">
				
						<input type="checkbox" name="product_name" value="product_name">Product Name<br />
						<input type="checkbox" name="product_id" value="product_id">Product ID<br />
						<input type="checkbox" name="product_catagory" value="product_catagory">Product Catagory<br />
						<input type="checkbox" name="stock" value="stock">Stock<br />
						<input type="checkbox" name="sold" value="sold">Sold<br />
						<input type="checkbox" name="selling_price" value="selling_price">Selling Price<br />
						<input type="checkbox" name="buying_price" value="buying_price">Buying Price<br />
						<input type="checkbox" name="stock_value" value="stock_value">Stock Value<br />
						<input type="checkbox" name="discount" value="discount">Discount<br />
						<input type="checkbox" name="puchased_date" value="purchased_date">Puchased date<br /><br />
						<input type="submit" value="Generate Report" class="more" style="width: 200px;"/>
			</form>
			</div>
		</div>

{include file="user_footer.tpl"}