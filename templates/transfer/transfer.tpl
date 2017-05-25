{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
<script>
	$(document).ready(function() {
		$('#product_name').autocomplete({
			source: 'ajax/query_transfer.php?query=%QUERY'
		});
	})
</script>

<script>
	$(document).ready(function() {
		$('#selected_item').autocomplete({
			source: 'ajax/query_transfer.php?query=%QUERY'
		});
	})
</script>

{/literal}
<section class="content">
	<div class="row">
				<div class="col-lg-12" style="margin-top: -20px;">
					<h3><strong>Transfer</strong></h3>
				</div>
			
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
	<div class="nav-tabs-custom">
		
		<div class="tab-content">
			
                    <div class="row">
						<div class="col-lg-9">
							<div class="row">
						<div class="col-lg-3">
							<form action="transfer.php?job=barcode" name="select_item_form" method="post" >
								<input type="text" class="form-control" name="barcode" placeholder="For Barcode" autofocus tabindex="1" onchange="this.form.submit()"/> 
							</form>
						</div>
								<form action="transfer.php?job=add_transfer" name="select_item_form" method="post">
									<div class="col-lg-4">
										<input type="text" id="product_name" class="form-control product" name="product_name" placeholder="Product Name"/>														
									</div>
									<div class="col-lg-3">
										<input type="text" class="form-control" name="quantity" placeholder="Quantity"/>														
									</div>
									<div class="col-lg-2">
										<input type="submit" class="btn btn-primary" name="add" value="Add"/> &nbsp; &nbsp; &nbsp; &nbsp;
									</div>
								</form>
							</div>
												

						<div class="row" style="margin-left: 4px; margin-top: 5px; margin-right: 4px;">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Delete</th>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Update</th>
									</tr>
								</thead>
								<tbody>
								{php}list_item_by_transfer($_SESSION['transfer_no']);{/php} 
			
								</tbody>
							</table>
						</div>
					</div>

				<div class="col-lg-3">
					<form name="sales_form" action="transfer.php?job=transfer" method="post" class="product">
						<div class="row" style="margin-right: 5px;">
							<input type="text" class="form-control" name="transfer_no" value="{$transfer_no}" size="25" required readonly="readonly" placeholder="Transfer No" tabindex="3"/>
						</div>
						
						<div class="row" style="margin-top: 5px; margin-right: 5px;">
							<input type="text" class="form-control" name="branch" value="{$branch}" size="25" required readonly="readonly" placeholder="From Branch" tabindex="3"/>
						</div>
						
						<div class="row" style="margin-top: 5px; margin-right: 5px;">
							<select class="form-control"  name="to_branch" placeholder="Branch">
										   {if $to_branch}
											   <option value="{$to_branch}">{$to_branch}</option>
										   {else}
											   <option value="" disabled selected> To Branch</option>
										   {/if}
										   {section name=to_branch loop=$to_branch_names}
											   <option  value="{$to_branch_names[to_branch]}" >{$to_branch_names[to_branch]}</option>
										   {/section}
						   </select>
						</div>
                         
                        <div class="row" style="margin-top: 5px; margin-right: 5px;"> 
							<input class="btn btn-success" type="submit" name="ok" value="Finish the transfer" tabindex="18" />					
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>



{include file="js_footer.tpl"}