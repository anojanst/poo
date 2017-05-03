{include file="user_header.tpl"}
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
		source: "ajax/query_customer.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto2").autocomplete({
		source: "ajax/query_sales_no.php",
		minLength: 1
	});				

});
</script>

<script language="JavaScript" type="text/javascript">
  function product(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_product').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_product').style.visibility="hidden"; 
    }
  }
</script>
{/literal}
	<div id="contents">
		{include file="user_navigation.tpl"}
		{if $error_report=='on'}
		<div class="error_report" style="margin-bottom: 50px;">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		<div style="width: 890px; min-height: 50px; background-color: #eee; {if $search_mode=='on'}margin-bottom: 10px;{else}margin-bottom: 30px;{/if} float: left; margin-top: -40px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
		<form action="sales.php?job=search" method="post" class="search">
			<table style="width: 880px;">
				<tr>
					<td><strong>Search & Edit Sales</strong></td>
					<td width="250">
						<input type="text" class='auto1' name="customer_search" value="{$customer_search}" size="25" placeholder="Search By Customer"/> 
					</td>
					<td width="20">
						OR
					</td>
					<td width="180">
						<input type="text" class='auto2' name="sales_no_search" value="{$sales_no_search}" size="15" placeholder="Search By Sales No"/> 
					</td>
					<td width="30" style="padding-bottom: 10px;">
						<input type="image" src="./images/search.png" height="28" width="28"/>
					</td>
				</tr>
			</table>
		</form>
		</div>
		{if $search_mode=='on'}
			{php}list_sales_search($_SESSION[sales_no_search], $_SESSION[customer_search]);{/php}
		{/if}
		<div class="main_user_home" style="min-height: 300px;">
		
			<div style="width: 900px;">
				<form action="sales.php?job=select" class="product" name="select_item_form" method="post">
					<table>
						<tr>
							<td>
								<input type="text" class="auto" name="selected_item" size="50" placeholder="Select Items"/> 
							</td>
							<td width="100" align="center">
								Add New
							</td>
							<td width="40">
								<a href="javascript:product('show');">
									<img alt="add" src="./images/add.png">
								</a>
							</td>
							<td>
								<a href="return.php"><div class="delete">
									Return Sales
								</div></a>
							</td>
						</tr>
					</table>
				</form>
				
				<table class="sales_table1">
					<thead>
						<tr>
							<th>Delete</th>
							<th>Product Name</th>
							<th>Product Id</th>
							<th>Stock</th>
							<th width="100">Price</th>
							<th width="70">Quantity</th>
							<th width="90">Discount (%)</th>		
							<th>Total</th>
							<th width="70">Update</th>
						</tr>
					</thead>
					<tbody>
				{php}list_item_by_sales($_SESSION['sales_no']);{/php} 
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
				<form name="sales_form" action="sales.php?job=sales" method="post" class="product">
					<table style="border-top: 2px silver solid; width: 900px; padding-top: 20px;">
						<tr>
							<td width="150">Sales No</td>
							<td width="15">:</td>
							<td width="150"><input type="text" name="sales_no" value="{$sales_no}" size="17" required readonly="readonly"/></td>
							<td width="300"></td>
						</tr>
						<tr>	
							<td>Sales Date</td>
							<td>:</td>
							<td><input type="text" name="date" value="{$date}" size="17" class="datepicker" required  /></td>
						</tr>
						<tr>	
							<td>Customer</td>
							<td>:</td>
							<td><input type="text" class="auto1" name="customer_name" value="{$customer_name}" size="40" required  /></td>
						</tr>
						<tr>	
							<td>Remarks</td>
							<td>:</td>
							<td><input type="text" name="remarks" value="{$remarks}" size="40" required  /></td>
						</tr>
						<tr>	
							<td>Prepared By</td>
							<td>:</td>
							<td><input type="text" name="prepared_by" value="{$prepared_by}" size="40" required readonly="readonly"/></td>
						</tr>
						
						{if $edit_mode=='on'}
						<tr>	
							<td>Updated By</td>
							<td>:</td>
							<td><input type="text" name="updated_by" value="{$updated_by}" size="40" required readonly="readonly"/></td>
						</tr>
						{/if}
						<tr>	
							<td colspan="3"><br />
								{if $edit_mode=='on'}
								<input type="submit" name="ok" value="Update" />
								{else}
								<input type="submit" name="ok" value="Save" />
								{/if}
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
{include file="user_footer.tpl"}