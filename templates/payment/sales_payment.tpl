{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Sales Payment</strong></h3>
				</div>
			</div>
			<div class="row">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
				<form action="sales_payment.php?job=search" method="post" class="search">
					<div class="col-lg-5">	
						<input type="text" class='auto1 form-control' name="customer_search" value="{$customer_search}"  placeholder="Search By Customer" />
					</div>
					<div class="col-lg-5">	
						<input type="text" class='auto2 form-control' name="sales_payment_no_search" value="{$sales_payment_no_search}" placeholder="Reurn Sales Payment No" />
					</div>
					<div class="col-lg-2">	
						<input type="image"	src="./images/search.png" height="28" width="28" />
					</div>
				</form>
			</div><br>
			{if $search_mode=='on'}
			{php}list_sales_payment_search($_SESSION[sales_payment_no_search], $_SESSION[customer_search]);{/php}
			{/if}
			<div class="row">
				<div class="col-lg-5">	
					<form action="sales_payment.php?job=customer" method="post">
						<input type="text" class='auto1 form-control' name="customer_name" value="{$customer_name}" placeholder="Pay For Customer Name"/>			
					</form>
				</div>
				<div class="col-lg-5">			
					<form action="sales_payment.php?job=sales" method="post">
						<input type="text" class='auto3 form-control' name="sales_no"value="{$sales_no_select}" placeholder="Pay For Sales No"/>
					</form>
				</div>
				<div class="col-lg-2"></div>
			</div>
			{if $show=='on' }
			<div class="main_user_home" style="min-height: 300px;">
				<p style="margin-top: 20px; margin-bottom: -20px;">Pending Sales Payments.</p>
			{if $customer_name}
			<div>
			{php}list_sales_of_customer($_SESSION['customer_name']);{/php}</div>
			{elseif $sales_no_select}
			<div>
			{php}list_sales_of_sales_no($_SESSION['sales_no']);{/php}
			</div>
			{/if}
			{if $added=='on'}
				<p style="margin-top: 10px; margin-bottom: 5px;">Added Sales Payments.</p>
			{php}list_added_sales($_SESSION['random_no']);{/php}
			{/if}
			<div>
				<form name="payment" action="sales_payment.php?job=save_payment" method="post" class="product">
					<table	style="border-top: 2px silver solid; width: 900px; padding-top: 20px;">
						<tr>
							<td>
								<table>
									<tr>
										<td>Cheque Amount</td>
										<td width="350">: <input type="text" name="cheque_amount"
											value="{$cheque_amount}" size="25" /></td>
										<td>Cash Amount</td>
										<td>: <input type="text" name="cash_amount" value="{$cash_amount}"
											size="25" /></td>
									</tr>
									<tr>
										<td>Cheque No</td>
										<td>: <input type="text" name="cheque_no" value="{$cheque_no}" size="25" /></td>
									</tr>
									<tr>
										<td>Bank</td>
										<td>: <input type="text" name="cheque_bank" value="{$cheque_bank}" size="25" /></td>
									</tr>
									<tr>
										<td>Branch</td>
										<td>: <input type="text" name="cheque_branch" value="{$branch}"	size="25" /></td>
									</tr>
									<tr>
										<td>Cheque Date</td>
										<td>: <input type="text" name="cheque_date" value="{$cheque_date}" class="datepicker" required size="25" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table><br/>
					<table>
						<tr>
							<td width="125">Date</td>
							<td>:</td>
							<td><input type="text" name="date" class="datepicker" value="{$date}"size="25" /></td>
						</tr>
						<tr>
							<td>Remarks</td>
							<td>:</td>
							<td><textarea name="remarks" style="width: 265px;">{$remarks}</textarea></td>
						</tr>
						<tr>
							<td>Prepared By</td>
							<td>:</td>
							<td><input type="text" name="prepared_by" value="{$prepared_by}" readonly size="25" /></td>
						</tr>					
					</table> <br/>

						<input type="submit" name="ok" value="Save Payment"/>
				</form>
			</div>
			{/if}
		</div>
	</div>
</section>
{include file="js_footer.tpl"}
