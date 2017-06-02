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

	<script>
        $(document).ready(function() {
            $('#barcode').autocomplete({
                source: 'ajax/query_barcode.php?query=%QUERY'
            });
        })
	</script>

	<script>
        $(document).ready(function() {
            $('#product_no').autocomplete({
                source: 'ajax/query_product_id.php?query=%QUERY'
            });
        })
	</script>

    <script type="text/javascript">
        function calculateBalance(){
            var x = document.getElementById("total1").value;
            var y = document.getElementById("cust").value;
            var z = document.getElementById("discount").value;
            var totalWithDiscount = x-z;
            console.log(totalWithDiscount);
            document.getElementById("total").innerHTML=totalWithDiscount.toFixed(2);
            var total = y - totalWithDiscount;
            var cus_amount = y;
            document.getElementById("balance").innerHTML=total.toFixed(2);
        }
    </script>

{/literal}

<section class="content-header">
	<h1>Sales</h1>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Sales</li>
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
							<form action="sales.php?job=barcode" name="select_item_form" method="post" >
								<input type="text" class="form-control" id="barcode" name="barcode" placeholder="For Barcode" autofocus  onchange="this.form.submit()"/>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-yellow">
						<div class="inner">
							<strong><h4 style="margin-top: -5px; font-weight: 900;">Product No</h4></strong>
							<form action="sales.php?job=product_no" name="select_item_form" method="post">
								<input type="text" class="form-control" id="product_no" name="product_no" placeholder="Product No"/>
								<!--<input type="submit" style="margin-top: 5px;" class="form-control btn btn-primary" name="add" value="Add"/>
							--></form>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
					<div class="small-box bg-green">
						<div class="inner">
							<strong><h4 style="margin-top: -5px; font-weight: 900;">Select Items</h4></strong>
							<form action="sales.php?job=select" name="select_item_form" method="post">
								<input type="text" class="form-control" id="product_name" name="selected_item" placeholder="Select Items"/>
								<!--<input type="submit" style="margin-top: 5px;" class="form-control btn btn-primary" name="add" value="Add"/>-->
                            </form>
						</div>
					</div>
                </div>
                <div class="col-lg-2 col-xs-6">
                    <label> <strong>Total</strong> </label>
                    <strong><h2 id="total" style="color: red;">{$total}</h2></strong>
                </div>

                <div class="col-lg-1 col-xs-6" style="margin-left: -50px;">
                    <label> <strong>Balance</strong> </label>
                    <strong><h2 id="balance" style="color: red; "></h2></strong>
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
                        {php}list_item_by_sales($_SESSION['sales_no']);{/php}

						</tbody>
					</table>
				</div>

				<div class="col-lg-3">
					<form name="sales_form" action="sales.php?job=sales" method="post" class="product">
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
                            <input class="form-control btn btn-success" type="submit" name="ok" value="Finish the Bill & Print" tabindex="6" />
                        </div>
                        <div class="row" style="margin-top: 5px; margin-right: 5px;">
                            <select class="form-control" name="bill" required>
                                <option value="" disabled></option>
                                <option value="small_bill" selected>small bill</option>
                                <option value="big_bill">big bill</option>
                            </select>
						</div>
						<div class="row" style="margin-right: 5px;" hidden="hidden">
							<label> <strong>Sales No</strong> </label>
							<input type="text" class="form-control" name="sales_no" value="{$sales_no}" size="25" required readonly="readonly"  placeholder="Sales No" tabindex="3"/>
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;" hidden="hidden">
							<label> <strong>Total </strong> </label>
							<input type="text" class="form-control" id="total1" name="total" value="{$total}" size="25"  placeholder="Total" tabindex="5" readonly="readonly"/>
						</div>
                        <div class="row" style="margin-right: 5px; margin-top: 5px;">
                            <label> <strong>Books Total </strong> </label>
                            <input type="text" class="form-control" id="" name="books_total" value="{$books_total}" size="25"  placeholder="Books Total" tabindex="5" readonly="readonly"/>
                        </div>
                        <div class="row" style="margin-right: 5px; margin-top: 5px;">
                            <label> <strong>Non Books Total </strong> </label>
                            <input type="text" class="form-control" id="" name="non_books_total" value="{$non_books_total}" size="25"  placeholder="Non Books Total" tabindex="5" readonly="readonly"/>
                        </div>
                        <div class="row" style="margin-right: 5px; margin-top: 5px;">
                            <label> <strong>Customer Paying Amount</strong> </label>
                            <input type="text" class="form-control" id="cust" name="customer_amount" size="25" placeholder="Customer Paying Amount" tabindex="5" onkeyup="calculateBalance()" />
                        </div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Discount </strong> </label>
                            {if $discount_display=='off'}
                                <input type="hidden" class="form-control" id="discount" name="discount" value="{$discount}"  size="25" placeholder="Discount" tabindex="5" onkeyup="calculateBalance()"/>
                            {else}
								<input type="text" class="form-control" id="discount" name="discount" value="{$discount}"  size="25" placeholder="Discount" tabindex="5" onkeyup="calculateBalance()"/>
                            {/if}
						</div>
                        <div class="row" style="margin-right: 5px; margin-top: 5px;">
                            <label> <strong>Discount Type</strong> </label>
                            <select class="form-control" name="discount_type" required>
                                <option value="" disabled>Discount Type</option>
                                <option value="CASH" selected>All</option>
                                <option value="BOOK">Book</option>
                                <option value="ACC">Acc</option>
                            </select>
                        </div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Customer</strong> </label>
							<input type="text" class="form-control" name="customer_name"size="25" placeholder="Customer" tabindex="4"/>
						</div>

						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Payment Type</strong> </label>
							<select class="form-control" id="type" name="payment_type" required onchange="changeAttributes();">
								<option value="" disabled>Payment Type</option>
								<option value="CASH" selected>Cash</option>
								<option value="CARD">Card</option>
								<option value="CREDIT">Credit</option>
								<option value="GIFT">Gift Card</option>
							</select>
						</div>

						<div class="row" style="margin-right: 5px; margin-top: 5px;">
							<label> <strong>Gift Card No</strong> </label>
							<input type="text"  style="visibility: hidden;" class="form-control" id="gift" name="gift_card_no" id="gift_card_no" size="25" placeholder="Gift Card No" tabindex="5" onkeyup="calculateBalance()" />
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;" hidden="hidden">
							<label> <strong>Prepared by </strong> </label>
							<input type="text" class="form-control" name="prepared_by" value="{$prepared_by}" size="25" required readonly="readonly"/>
						</div>
						<div class="row" style="margin-right: 5px; margin-top: 5px;" hidden="hidden">
                            {if $edit_mode=='on'}
								<input type="text" class="form-control" name="updated_by" value="{$updated_by}" size="25" required readonly="readonly"/>
                            {/if}
						</div>

						<div id="cus_amount"></div>

					</form>
				</div>
			</div>
		</div>
	</div>

</section>

{literal}

	<script type="text/javascript">
        function changeAttributes()
        {
            var type = document.getElementById ( "type" ).value ;

            // when connecting to server
            if ( type == "CARD" ||  type == "CREDIT" ){
                document.getElementById ( "cust" ).style.visibility = "hidden" ;
            }

            else{
                document.getElementById ( "cust" ).style.visibility = "visible" ;

            }

            if ( type == "GIFT"){

                document.getElementById ( "gift" ).style.visibility = "visible" ;
            }

            else{
                document.getElementById ( "gift" ).style.visibility = "hidden" ;

            }
        }
	</script>


{/literal}

{include file="js_footer.tpl"}