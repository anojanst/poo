{include file="home_header.tpl"}
{include file="navigation.tpl"}
<style>
#popupbox_account{
	margin: 0; 
	margin-left: 30%;
	margin-top: -45px; 
	padding-top: 10px; 
	padding-left: 10px;
	width: 570px; 
	height: 590px; 
	position: fixed; 
	background: #FBFBF0; 
	border-radius: 1px;
	box-shadow: 0px 0px 0px 8px rgba(0,0,0,0.3); 
	z-index: 0; 
	font-family: arial; 
	visibility: hidden; 
	overflow: auto;
}
</style>
{literal}
<script>
$(function () {
  $("#example1").DataTable(); 
});
</script>
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_account.php",
		minLength: 1
	});				

});
</script>

<script language="JavaScript" type="text/javascript">
  function account(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_account').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_account').style.visibility="hidden"; 
    }
  }
</script>


{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Accounts</strong></h3>
				</div>
			</div>
				<div id="popupbox_account"><br>
					<form name="add_product" action="chart_of_accounts.php?job=add" method="post" class="product">
						<table style="margin-top: -15px;">
							<tr>
								<td>Account Name *</td>
								<td> :</td>
								<td><input type="text" name="account_name" value="{$account_name}" required size="35"/></td>		
							</tr>
							<tr>
								<td>Account Code *</td>
								<td> :</td>
								<td><input type="text" name="account_code" value="{$account_code}" required size="35"/></td>		
							</tr>
							<tr>
								<td>Parent Account</td>
								<td> :</td>
								<td><input type="text" name="parent_account" value="{$parent_account}" size="35"/></td>		
							</tr>
							<tr>
								<td>Account Category *</td>
								<td> :</td>
								<td><select name="category" required style="width: 225px;">
									<option>{$category}</option>
									<option>Receivable</option>
									<option>Payable</option>
									<option>Asset</option>
									<option>Liability</option>
									<option>Equity</option>
									<option>Contra</option>
								</select>
								</td>
							</tr>
							<tr>
								<td>Address *</td>
								<td> :</td>
								<td><textarea name="address" cols="34" required>{$address}</textarea></td>		
							</tr>
							<tr>
								<td>Telephone No *</td>
								<td> :</td>
								<td><input type="text" name="telephone" value="{$telephone}" required size="35"/></td>		
							</tr>
							<tr>
								<td>Fax No *</td>
								<td> :</td>
								<td><input type="text" name="fax" value="{$fax}" required size="35"/></td>		
							</tr>
							<tr>
								<td>Email *</td>
								<td> :</td>
								<td><input type="text" name="email" value="{$email}" required size="35"/></td>		
							</tr>
							<tr>
								<td>Contact Person *</td>
								<td> :</td>
								<td><input type="text" name="contact_person" value="{$contact_person}" size="35"/></td>		
							</tr>
							<tr>
								<td>Account Status *</td>
								<td> :</td>
								<td><select name="account_status" required style="width: 225px;">
									<option>{$account_status}</option>
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
					<a href="javascript:account('hide');"><img src="./images/close.png" width="15" height="15" style="position: absolute; top: 5px; right: 5px;"/></a>
				</div>
			<div class="row">
				<div class="col-lg-10" >
					<h4>Customer Details</h4>
				</div>
			
					<div class="col-lg-2" style="padding-left: 60px; margin-top: -5px; ">
						<h5 align="right">Add New <a href="chart_of_accounts.php?job=add_new_acc">
						<img alt="add" width="28" src="./images/add.png">
						</a> </h5>											
					</div>	
	
				<!--			

				<form action="chart_of_accounts.php?job=search" method="post" class="search">
					<div class="col-lg-2"></div>
					<div class="col-lg-2" style="padding-left: 60px; margin-top: -5px; ">
						<h5>Add New <a href="javascript:account('show');">
						<img alt="add" width="28" src="./images/add.png">
						</a> </h5>											
					</div>						
					<div class="col-lg-3" style="margin-left: -20px;">
						<input type="text" class='auto form-control' name="search" value="{$search}" placeholder="Search"/> 
					</div>
					<div class="col-lg-1" style="margin-left: -10px;">
						<input type="image" src="./images/search.png" height="28" width="28"/>
					</div>			
				</form>

				-->

			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box-body">
							{php}list_account();{/php}        
					</div>
				</div>
			</div>						
		</div>
	</div>
</section>
	

{include file="js_footer.tpl"}