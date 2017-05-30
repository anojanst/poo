{include file="home_header.tpl"}
{include file="navigation.tpl"}

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

<div class="row">
	<div class="col-lg-3">
		<section class="content">
			<div class="nav-tabs-custom">
				<div class="tab-content">
					<div class="row">
						<div class="col-xs-12">
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
								<input type="submit" value="Generate Report" class="more btn btn-danger" style="width: 200px;"/>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

{include file="js_footer.tpl"}