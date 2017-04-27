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

	<script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto1").autocomplete({
                source: "ajax/query_suppliers.php",
                minLength: 1
            });

        });
	</script>

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
<div class="row">
	<div class="col-lg-8">
		<section class="content">
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<div class="tab-content">
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
					<div class="row">
						<div class="col-lg-12">
							<h4><strong> Product Details</strong></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4">
							<div class="row">
								<div class="col-lg-12">
                                    {if $cover}
										<img src="{$cover}" width="200" height="300"/>
                                    {/if}
								</div>
							</div>
							<div class="row" style="margin-top: 10px; ">
								<div class="col-lg-12">
									<a href="html/BCGcode39.php?barcode={$barcode}&product_id={$product_id}&price={$selling_price}&name={$product_name}&type={$type}" target="blank" class="btn btn-success form-control">Print Barcode</a>
								</div>
							</div>
							<div class="row" style="margin-top: 10px; ">
								<div class="col-lg-12">
									<a href="inventory.php?job=edit&id={$id}"  class="btn btn-danger form-control" >Edit</a>
								</div>
							</div>
							<div class="row" style="margin-top: 10px; ">
								<div class="col-lg-12">
									<a href="inventory.php?job=add_new" class="btn btn-warning form-control">Add new</a>
								</div>
							</div>
						</div>

						<div class="col-lg-8">
							<div class="row">
								<div class="col-lg-6">
									<b>Product Name</b>
								</div>
								<div class="col-lg-6">
									: {$product_name}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Product Id</b>
								</div>
								<div class="col-lg-6">
									: {$product_id}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Author</b>
								</div>
								<div class="col-lg-6">
									: {$author}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>ISBN No</b>
								</div>
								<div class="col-lg-6">
									: {$isbn}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Publication</b>
								</div>
								<div class="col-lg-6">
									: {$publication}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Supplier</b>
								</div>
								<div class="col-lg-6">
									: {$supplier}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Selling Price</b>
								</div>
								<div class="col-lg-6">
									: {$selling_price}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Selling Discount</b>
								</div>
								<div class="col-lg-6">
									: {$discount}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Buying Price</b>
								</div>
								<div class="col-lg-6">
									: {$buying_price}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Buying Discount</b>
								</div>
								<div class="col-lg-6">
									: {$buying_discount}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Currency Type</b>
								</div>
								<div class="col-lg-6">
									: {$type}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Measure Type</b>
								</div>
								<div class="col-lg-6">
									: {$measure_type}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Quantity</b>
								</div>
								<div class="col-lg-6">
									: {$quantity}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Pur Date</b>
								</div>
								<div class="col-lg-6">
									: {$purchased_date}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Exp Date</b>
								</div>
								<div class="col-lg-6">
									: {$exp_date}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Page</b>
								</div>
								<div class="col-lg-6">
									: {$page_count}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Exp Date</b>
								</div>
								<div class="col-lg-6">
									: {$exp_date}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Size</b>
								</div>
								<div class="col-lg-6">
									: {$size}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Weight</b>
								</div>
								<div class="col-lg-6">
									: {$weight}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Description</b>
								</div>
								<div class="col-lg-6">
									: {$product_description}
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<b>Label</b>
								</div>
								<div class="col-lg-6">
									: {$label}
								</div>
							</div>
						</div>
						<div class="col-lg-6"></div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>


{include file="js_footer.tpl"}