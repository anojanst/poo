{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
<script>
	$(document).ready(function() {
		$('input.product').typeahead({
			name: 'product',
			remote: 'ajax/query_inventory.php?query=%QUERY'
		});
	})
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Sales</strong></h3>
				</div>
			</div>
            <div class="row">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-4">
							<form action="sales.php?job=barcode" name="select_item_form" method="post" >
								<input type="text" class="form-control" name="barcode" placeholder="For Barcode" tabindex="1" autofocus onkeyup="this.form.submit()"/> 
							</form>
						</div>
						<div class="col-lg-4">
							<form action="sales.php?job=select" name="select_item_form" method="post">
								<input type="text" class="form-control product" name="selected_item" placeholder="Select Items"/>														
						</div>
						<div class="col-lg-4">
								<input type="submit" class="btn btn-primary" name="add" value="Add"/> &nbsp; &nbsp; &nbsp; &nbsp;
							</form>
								<a href="sales.php?job=must_new" class="btn btn-danger">New Sales</a>
						</div>							
					</div><br>
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Delete</th>
									<th>Product Name</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Discount (%)</th>		
									<th>Total</th>
									<th>Update</th>
								</tr>
							</thead>
							<tbody>
							{php}list_item_by_sales($_SESSION['sales_no']);{/php} 
		
							</tbody>
						</table>
					</div>
				</div>
			</div>
				<div class="col-lg-3">
					<form name="sales_form" action="sales.php?job=sales" method="post" class="product">
						<input type="text" class="form-control" name="sales_no" value="{$sales_no}" size="25" required readonly="readonly" placeholder="Sales No" tabindex="3"/>
						<input type="text" class="form-control" name="customer_name"size="25" placeholder="Customer" tabindex="4"/></td>
						<input type="text" class="form-control" name="customer_amount" value="{$customer_amount}" id="customer_amount" size="25" required placeholder="Customer Paying Amount" tabindex="5" onkeyup="calculateBalance()"/>
                        <input type="text" class="form-control" name="discount" value="{$discount}"  size="25" placeholder="Discount" tabindex="5"/>
						<input type="text" class="form-control" name="prepared_by" value="{$prepared_by}" size="25" required readonly="readonly"/>
						{if $edit_mode=='on'}
						<input type="text" class="form-control" name="updated_by" value="{$updated_by}" size="25" required readonly="readonly"/>
						{/if}
						<input type="text" class="form-control" name="total" id="total" value="{$total}" size="25"  placeholder="Total" tabindex="5" readonly="readonly"/>
						<div id="cus_amount"></div>
						<input class="btn btn-success" type="submit" name="ok" value="Finish the Bill & Print" tabindex="6" />					
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

{include file="js_footer.tpl"}