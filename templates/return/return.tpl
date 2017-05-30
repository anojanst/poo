{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
	<script>
        $(document).ready(function() {
            $('#product_name').autocomplete({
                source: 'ajax/query_multiple_stock.php?query=%QUERY'
            });
        })
	</script>
	<script src="js/jquery-2.2.3.min.js"></script>

	<script>
        $(document).ready(function() {
            $('#selected_item').autocomplete({
                source: 'ajax/query_multiple_stock.php?query=%QUERY'
            });
        })
	</script>

{/literal}

<section class="content-header">
	<h1>
		Return Sales
	</h1>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Return Sales</li>
	</ol>
</section>

<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
                    {if $error_report=='on'}
						<div class="alert alert-warning alert-dismissible" style="height:35px;">
							<button type="button" style="margin-top: -7px;" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4 style="margin-top: -8px; text-align: center; color: black;">{$error_message}</h4>
						</div>
                    {/if}

                    {if $stock_warning=='on'}
						<div class="alert alert-danger alert-dismissible" style="height:35px;">
							<button type="button" style="margin-top: -7px;" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4 style="margin-top: -8px; text-align: center; color: yellow;">{$stock_warning_message}</h4>
						</div>
                    {/if}

                    {if $pay_error=='on'}
						<div class="alert alert-danger alert-dismissible" style="height:35px;">
							<button type="button" style="margin-top: -7px;" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4 style="margin-top: -8px; text-align: center; color: yellow;">{$pay_error_msg}</h4>
						</div>
                    {/if}
				</div>

			</div>
				
				<div class="row">
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-aqua">
							<div class="inner">
								<strong><h4 style="margin-top: -5px; font-weight: 900;">Barcode</h4></strong>
								<form action="return.php?job=barcode" name="select_item_form" method="post" >
									<input type="text" class="form-control" name="barcode" placeholder="For Barcode" autofocus tabindex="1" onchange="this.form.submit()"/>
								</form>
							</div>							
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
								<strong><h4 style="margin-top: -5px; font-weight: 900;">Select Items</h4></strong>
								<form action="return.php?job=select" name="select_item_form" method="post">
									<input type="text" class="form-control" id="product_name" name="selected_item" placeholder="Select Items"/>
									<!--<input type="submit" style="margin-top: 5px;" class="form-control btn btn-primary" name="add" value="Add"/> 
								--></form>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-red">
							<div class="inner">
								<strong><h4 style="margin-top: -5px; font-weight: 900;">Price</h4></strong>
								 <form action="return.php?job=price" name="select_item_form" method="post">
									<input type="text" class="form-control" name="price" placeholder="Price"/>
									<!--<input type="submit" style="margin-top: 5px;" class="form-control btn btn-primary" name="add" value="Add"/> 
								--></form>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-yellow">
							<div class="inner">
								<strong><h4 style="margin-top: -5px; font-weight: 900;">Product No</h4></strong>
								<form action="return.php?job=product_no" name="select_item_form" method="post">
									<input type="text" class="form-control" name="product_no" placeholder="Product No"/>
									<!--<input type="submit" style="margin-top: 5px;" class="form-control btn btn-primary" name="add" value="Add"/> 
								--></form>
							</div>
						</div>
					</div>
				</div>		
				
						
					<div class="row">
						<div class="col-lg-9">
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
                                {php}list_item_by_return($_SESSION['return_no']);{/php} 

								</tbody>
							</table>
						</div>

				<div class="col-lg-3">					
					<form name="sales_form" action="return.php?job=return" method="post" class="product">
						<div class="row" style="margin-right: 5px;">
							<label> <strong>Return No</strong> </label>
							<input type="text" class="form-control" name="return_no" value="{$return_no}" size="25" required readonly="readonly" placeholder="Return No" tabindex="3"/>
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Customer</strong> </label>
							<input type="text" class="form-control" name="customer_name"size="25" placeholder="Customer" tabindex="4"/></td>
						</div>

						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Payment Type</strong> </label>
							<select class="form-control" id="type" name="payment_type" required onchange="changeAttributes();">
								<option value="" disabled>Payment Type</option>
								<option value="CASH" selected>Cash</option>
								<option value="ITEM">Item</option>
							</select>
						</div>
						
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Prepared by </strong> </label>
							<input type="text" class="form-control" name="prepared_by" value="{$prepared_by}" size="25" required readonly="readonly"/>
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
                            {if $edit_mode=='on'}
								<input type="text" class="form-control" name="updated_by" value="{$updated_by}" size="25" required readonly="readonly"/>
                            {/if}
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Total </strong> </label>
							<input type="text" class="form-control" name="total" id="total" value="{$total}" size="25"  placeholder="Total" tabindex="5" readonly="readonly"/>
						</div>
						<div id="cus_amount"></div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<input class="btn btn-success" type="submit" name="ok" value="Finish the Return Bill & Print" tabindex="6" />
						</div>
					</form>			
				</div>
			</div>
		</div>
	</div>
</section>

{literal}

	<<script type="text/javascript">
    function changeAttributes()
    {
        var type = document.getElementById ( "type" ).value ;

        // when connecting to server
        if ( type == "ITEM" ){
			 document.getElementById ( "total" ).style.visibility = "hidden" ;
        }
        else{
			 document.getElementById ( "total" ).style.visibility = "visible" ;

        }
    }
</script>
{/literal}
{include file="js_footer.tpl"}