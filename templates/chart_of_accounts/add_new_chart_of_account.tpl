{include file="home_header.tpl"}
{include file="navigation.tpl"}

	
	<div id="contents">
		{if $error_report=='on'}
		<div class="error_report">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		{if $warning_report=='on'}
		<div class="warning_report" style="margin-bottom: 50px;">
			<strong>{$warning_message}</strong>
		</div>
		{/if}
		
 	<section class="content">
  		  <div class="nav-tabs-custom">
  			  <div class="tab-content">
   				 <div class="row">
     			   <div class="col-lg-12">
                     <h2><strong>Add New </strong></h2>
               		</div>
		 
	<div class="row">
		<div class="col-lg-5" style="margin-top: 10px;">			
			
				<div class="panel-body">
					<form name="add_product" action="chart_of_accounts.php?job=add" method="post" class="product">
			  
							<div class="row" style="margin-bottom: 10px; margin-left: 20px;">

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
									Account Name *
									<input class="form-control" name="account_name" value="{$account_name}" required placeholder="Account Name">
									
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                    Account Code *
									<input class="form-control" name="account_code" value="{$account_code}" required placeholder="Account Code">
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
									Account Category *
									<select name="category" required class="form-control"">
									<option>{$category}</option>
									<option>Receivable</option>
									<option>Payable</option>
									<option>Asset</option>
									<option>Liability</option>
									<option>Equity</option>
									<option>Contra</option>
								</select>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                    Address *
									<textarea name="address" required class="form-control">{$address}</textarea>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                    Telephone No *
									<input type="text" name="telephone" value="{$telephone}" class="form-control" required size="35"/>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   	Fax No *
									<input type="text" name="fax" value="{$fax}" class="form-control" required size="35"/>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   	Email *
									<input type="text" name="email" value="{$email}" class="form-control" required size="35"/>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   	Contact Person *
									<input type="text" name="contact_person" class="form-control" value="{$contact_person}" size="35"/>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   	Account Status *
								<select name="account_status" required class="form-control" style="width: 225px;">
									<option>{$account_status}</option>
									<option>Active</option>
									<option>Blocked</option>
								</select>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   Opening Balance
									<input type="text" name="opening_balance" value="{$opening_balance}" class="form-control" />
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   Opening balance Date 
									<input type="text" name="opening_balance_date" value="{$opening_balance_date}" class="datepicker"/>
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   Credit Limit
									<input type="text" name="credit_limit" value="{$credit_limit}" class="form-control" />
								</div>                                
							</div>

							<div class="row" style="margin-bottom: 10px;">
								<div class="col-lg-12">
                                   Credit Period
									<input type="text" name="credit_period" value="{$credit_period}" class="form-control" />
								</div>                                
							</div>
						
				 <div class="row">
					<div class="col-lg-6">
			 
						 {if $edit_mode=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-block btn-success btn-lg">Update</button>
			
						{else}
							<button type="submit" name="ok" value="Save" class="btn btn-block btn-success btn-lg">Save</button>
						</div>
						<div class="col-lg-6">
						{/if}
	                    	<button type="reset" class="btn btn-block btn-danger btn-lg">Reset</button>
						</div>
					</div>
				

								


				</div>

			 	</form>
		 </div>
	</div>


 <div class="col-lg-7" style="margin-top: 10px;">	
 <section class="content">
    <div class="nav-tabs-custom">
    <div class="tab-content">
    <div class="row">
        <div class="col-lg-12">
            <h4><strong>List Account</strong></h4>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-xs-12">
                {php}list_account();{/php}
            </div>
        </div>
    </div>
    </div>
</section>
</div>	


		   
	 </div>
	 </div>
	</div>
	</section>
	</div>

	{literal}
		<script>
			 $(function () {
				 $("#example1").DataTable();
			 });
		</script>
	{/literal}
	
{include file="js_footer.tpl"}
