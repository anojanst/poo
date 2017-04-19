{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Return Sales Payment</strong></h3>
				</div>
			</div>
			<div class="row">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
				<form action="return_sales_payment.php?job=search" method="post class="search">
					<div class="col-lg-5">
						<input type="text" class='auto1 form-control' name="customer_search" value="{$customer_search}" placeholder="Search By Customer" />
					</div>
					<div class="col-lg-5">
						<input type="text" class='auto2 form-control' name="return_sales_payment_no_search" value="{$return_sales_payment_no_search}" placeholder="Reurn Sales Payment No" />
					</div>
					<div class="col-lg-2">
						<input type="image"	src="./images/search.png" height="28" width="28" />
					</div>
				</form>
			</div><br>
				{if $search_mode=='on'}
				{php}list_return_sales_payment_search($_SESSION[return_sales_payment_no_search],$_SESSION[customer_search]);{/php}
				{/if}
			<div class="row">
				<div class="col-lg-5">					
					<form action="return_sales_payment.php?job=customer" method="post">		
						<input type="text" class='auto1 form-control' name="customer_name" value="{$customer_name}" size="30" placeholder="Customer Name"/>			
					</form>
				</div>
				<div class="col-lg-5">	
					<form action="return_sales_payment.php?job=return_sales" method="post">
						<input type="text" class='auto3 form-control' name="return_no" value="{$return_no_select}" size="15" placeholder="Return Sales No"/>			
					</form>
				</div>
				<div class="col-lg-2"></div>
			</div>
				{if $show=='on' }
					<div class="main_user_home" style="min-height: 300px;">
						<p style="margin-top: 20px; margin-bottom: -20px;">Pending Return Sales Payments.</p>
				{if $customer_name}
			<div>
				{php}list_return_sales_of_customer($_SESSION['customer_name']);{/php}
			</div>
				{elseif $return_no_select}
			<div>
				{php}list_return_sales_of_return_no($_SESSION['return_no']);{/php}
			</div>
				{/if}
				{if $added=='on'}
					<p style="margin-top: 10px; margin-bottom: 5px;">Added Return Sales Payments.</p>
					{php}list_added_return_sales($_SESSION['random_no']);{/php}
				{/if}
			<div>
				<form name="payment" action="return_sales_payment.php?job=save_payment" method="post" class="product">
					<table style="border-top: 2px silver solid; width: 900px; padding-top: 20px;">
						<tr>				
							<td>			
								<table>
									<tr>				
										<td>Cheque Amount</td>
										<td width="350">: <input type="text" name="cheque_amount"
											value="{$cheque_amount}" size="25" /></td>
										<td>Cash Amount</td>
										<td>: <input type="text" name="cash_amount" value="{$cash_amount}" size="25" /></td>
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
							<td><input type="text" name="date" class="datepicker" value="{$date}"
								size="25" /></td>
						</tr>
						<tr>
							<td>Remarks</td>
							<td>:</td>
							<td><textarea name="remarks" style="width: 265px;">{$remarks}</textarea></td>
						</tr>
						<tr>
							<td>Prepared By</td>
							<td>:</td>
							<td><input type="text" name="prepared_by" value="{$prepared_by}"
								readonly size="25" /></td>
						</tr>				
					</table><br/>
						<input type="submit" name="ok" value="Save Payment" />
				</form>
			</div>
				{/if}
		</div>
	</div>
</section>
{include file="js_footer.tpl"}
		