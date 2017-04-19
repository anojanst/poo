{include file="user_header.tpl"}
{literal}
	
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_customer.php",
		minLength: 1
	});				

});
</script>

<script language="JavaScript" type="text/javascript">
  function customer(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_customer').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_customer').style.visibility="hidden"; 
    }
  }
</script>


{/literal}

<div id="popupbox_customer"> 
	<br />
	<form name="add_product" action="customer.php?job=add" method="post" class="product">
		<table style="margin-top: -15px;">
			<tr>
				<td>Customer Name</td>
				<td> :</td>
				<td><input type="text" name="customer_name" value="{$customer_name}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Address</td>
				<td> :</td>
				<td><textarea name="address" cols="34" required>{$address}</textarea></td>		
			</tr>
			<tr>
				<td>Telephone No</td>
				<td> :</td>
				<td><input type="text" name="telephone" value="{$telephone}" size="35"/></td>		
			</tr>
			<tr>
				<td>Fax No</td>
				<td> :</td>
				<td><input type="text" name="fax" value="{$fax}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Email</td>
				<td> :</td>
				<td><input type="text" name="email" value="{$email}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Contact Person</td>
				<td> :</td>
				<td><input type="text" name="contact_person" value="{$contact_person}" size="35"/></td>		
			</tr>
			<tr>
				<td>Customer Status</td>
				<td> :</td>
				<td><select name="customer_status" required style="width: 225px;">
					<option>{$customer_status}</option>
					<option>Active</option>
					<option>Blocked</option>
				</select>
				</td>
			</tr>
			<tr>
				<td>Opening Balance</td>
				<td> :</td>
				<td><input type="text" name="opening_balance"
					value="{$opening_balance}" /></td>
			</tr>
		
			<tr>		
				<td>Opening balance Date </td>
				<td> :</td>
				<td><input type="text" name="opening_balance_date" value="{$opening_balance_date}" class="datepicker"/></td>
			</tr>
			<tr>
				<td>Credit Limit</td>
				<td> :</td>
				<td><input type="text" name="credit_limit" value="{$credit_limit}" /></td>
			</tr>
		
			<tr>
				<td>Credit Period</td>
				<td> :</td>
				<td><input type="text" name="credit_period" value="{$credit_period}" /></td>
			</tr>
			<tr>
				<td colspan="3">
					{if $edit_mode=='on'}
					<input type="submit" name="ok" value="Update" />
					{else}
					<input type="submit" name="ok" value="Save" />
					{/if}
				</td>		
			</tr>
		</table>
	</form>
	<ul id="navigation" style="position: absolute; bottom: -50px; left: -200px;">
		<li>* Optional</li>
	</ul>
	<a href="javascript:customer('hide');"><img src="./images/close.png" width="15" height="15" style="position: absolute; top: 5px; right: 5px;"/></a>
</div>
	
	<div id="contents">
		{include file="user_navigation.tpl"}
		<div class="main_user_home" style="min-height: 300px;">
			<div style="float: left; margin-right: 5px; min-height: 300px;">
				<h4 style="margin-top: 30px;">Customer Details</h4>
			<form action="customer.php?job=search" method="post" class="search">
				<table style="margin-top: -60px; margin-left: 485px;">
					<tr>
						<td width="80">
							Add New
						</td>
						<td width="40">
							<a href="javascript:customer('show');">
								<img alt="add" src="./images/add.png">
							</a>
						</td>
						<td>
							<input type="text" class='auto' name="search" value="{$search}" size="20" placeholder="Search"/> 
						</td>
						<td width="40" align="right" style="padding-bottom: 10px;">
							<input type="image" src="./images/search.png" height="28" width="28"/>
						</td>
					</tr>
				</table>
			</form>
			{if $search_mode=='on'}
			{php}list_customer_search($_SESSION[search]);{/php}
			{else}
			{php}list_customer();{/php}
			{/if}
			</div>
		</div>
	</div>
	

{include file="user_footer.tpl"}