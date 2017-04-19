{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Payments</strong></h3>
				</div>
			</div><br>
			<div class="row">
				{if $error_report=='on'}
				<div class="error_report" style="margin-bottom: 50px;">
					<strong>{$error_message}</strong>
				</div>
				{/if}		
					<form action="payment.php?job=select_mode" method="post" class="product" name="select_mode_form">
						<div class="col-lg-12">
							<select name="mode">
								<option>Select Your Type</option>
								<option>{$mode}</option>
								<option onclick="document.select_mode_form.submit()">Purchase Order</option>
								<option onclick="document.select_mode_form.submit()">Returns</option>
								<option onclick="document.select_mode_form.submit()">Sales</option>
								<option onclick="document.select_mode_form.submit()">Other Expenses</option>
								<option onclick="document.select_mode_form.submit()">Other Incomes</option>
							</select>
						</div>
					</form>
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}