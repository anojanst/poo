{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Return Sales</strong></h3>
				</div>
			</div>
			<div class="row">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
					<form action="return.php?job=search" method="post" class="search">
						<div class="col-lg-5">
							<input type="text" class='form-control' name="customer_search" value="{$customer_search}"  placeholder="Search By Customer"/> 								
						</div>
						<div class="col-lg-5">
							<input type="text" class='form-control' name="return_no_search" value="{$return_no_search}"  placeholder="Search By Return No"/>
						</div>
						<div class="col-lg-2">
							<input type="image" src="./images/search.png" height="28" width="28"/>
						</div>
					</form>
			</div>
				{if $search_mode=='on'}
					{php}list_return_search($_SESSION[return_no_search], $_SESSION[customer_search]);{/php}
				{/if}<br>
				<div class="row">
					<div class="col-lg-9">
						<div class="row">
							<form action="return.php?job=select" class="product" name="select_item_form" method="post">
								<div class="col-lg-7">
									<input type="text"  style="width: 407px;"  class="form-control" name="selected_item"  placeholder="Select Items"/> 
								</div>
								<div class="col-lg-1">										
									<a href="javascript:product('show');">
										<img alt="add" src="./images/add.png">
									</a>
								</div>
								<div class="col-lg-4">										
									<a href="sales.php" class="btn btn-success"> 
										New Sales
									</a>
								</div>
							</form>
						</div><br>
						<div class="row">
							<div class="col-lg-9">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Delete</th>
											<th>Product Name</th>
											<th>Product Id</th>
											<th>Stock</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Discount (%)</th>		
											<th>Total</th>
											<th>Update</th>
										</tr>
									</thead>
									<tbody>
								{php}list_item_by_return($_SESSION['return_no']);{/php} 
											</tr>							
										<td></td>
										<td></td>				
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<th align="right"><strong>{$total}</strong></th>									
										<tr>
									</tbody>
								</table>
							</div>
						<div class="col-lg-3"></div>
					</div>
				</div>
				<div class="col-lg-3">					
					<form name="return_form" action="return.php?job=return" method="post" class="product">
						<input type="text" name="return_no" value="{$return_no}" size="25" required readonly="readonly" placeholder="Return No" tabindex="3"/>
						<input type="text" class="auto1" value="{$date}" name="date" size="25" placeholder="Date" tabindex="4"/>
						<input type="text" class="auto1" name="customer_name" value="{$customer_name}"  size="25" required placeholder="Customer Name" tabindex="5" onkeyup="calculateBalance();"/>
						<input type="text" name="remarks" value="{$remarks}" size="25" required placeholder="Remarks" required readonly="readonly"/>
						<input type="text" name="prepared_by" value="{$prepared_by}" size="25" required placeholder="Prepared_by" required readonly="readonly"/>
					{if $edit_mode=='on'}
						<input type="text" name="updated_by" value="{$updated_by}" size="25" required readonly="readonly"/>
					{/if}
					{if $edit_mode=='on'}
						<input type="submit" name="ok" value="Update" style="margin-right: 12px;" />
					{else}
						<input type="submit" name="ok" value="Save" style="margin-right: 12px;" />
					{/if}
					</form>				
				</div>
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}