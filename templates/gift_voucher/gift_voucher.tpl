{include file="home_header.tpl"}
{include file="navigation.tpl"}


<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12" style="margin-top: -20px;">
					<h3><strong>Gift Voucher</strong></h3>
				</div>
			</div>
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
				</div>
			</div>
			<div class="row">
				<form role="form" action="gift_voucher.php?job=save" method="post" class="product" enctype="multipart/form-data">
					<div class="row" style="margin-left: 20px;">
						<div class="col-lg-5">
							<div class="form-group">
								<input class="form-control" name="voucher_no" value="{$voucher_no}" required placeholder="Voucher No ">
							</div>
						</div>

						<div class="col-lg-5">
							<div class="form-group">
								<select class="form-control" name="voucher_amount" required>
                                    {if $voucher_amount}
										<option value="{$voucher_amount}">{$voucher_amount}</option>
                                    {else}
										<option value="" disabled selected>Voucher Amount</option>
                                    {/if}
									<option value="500">500</option>
									<option value="600">600</option>
									<option value="700">700</option>
								</select>

							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 20px;">
						<div class="col-lg-5">
							<div class="form-group">
								<input class="form-control" name="customer_name" value="{$customer_name}" required placeholder="Customer Name">
							</div>
						</div>

						<div class="col-lg-5">
							<div class="form-group">
								<input class="form-control" name="phone_no" value="{$phone_no}" required placeholder="Phone No">
							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 20px;">
						<div class="col-lg-6">
							<div class="form-group">
								<textarea name="address" rows="3" cols="68" required placeholder="Address">{$address}</textarea>
							</div>
						</div>
					</div>
					<div class="row" style="margin-left: 20px;">
						<div class="col-lg-8" >
                            {if $edit=='on'}
								<button type="submit" name="ok" style="width: 150px; background: #3498db;" value="Update" class="btn btn-default">Update</button>
                            {else}
								<button type="submit" name="ok" style="width: 150px; background: #3498db;" value="Save" class="btn btn-default">Save</button>
                            {/if}
						</div>
					</div>
				</form>
			</div>

			<div class="row">
				<div class="col-lg-12" style="margin-top: 20px;">
					<h3><strong>Gift Voucher</strong></h3>
				</div>
				<div class="col-lg-12">
                    {php}list_voucher();{/php}
				</div>
			</div>
		</div>
	</div>
</section>

{include file="js_footer.tpl"}