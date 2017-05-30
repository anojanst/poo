{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}
<script>
  $(function () {
    
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>
<script>
	$(function () {
		$("#example1").DataTable();
	});
</script>
<script>
  $(function () {
    
    $('#datepicker1').datepicker({
      autoclose: true
    });
  });
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Other Expenses Payments</strong></h3>
				</div>
			</div>
			<div class="row">	
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
				<form action="other_expenses.php?job=search" method="post" class="search">
					<div class="col-lg-5">						
						<input type="text" class='form-control'	name="supplier_search" value="{$supplier_search}" placeholder="Search By Supplier" />
					</div>
					<div class="col-lg-5">
						<input type="text" class='form-control' name="other_expenses_no_search" value="{$other_expenses_no_search}" placeholder="Other Expenses No" />
					</div>
					<div class="col-lg-2">
						<input type="submit" class="btn btn-primary" value="Search" />
					</div>
				</form>
			</div><br>
			<div class="row">	
			{if $search_mode=='on'}
				{php}list_other_expenses_search($_SESSION[other_expenses_no_search], $_SESSION[supplier_search]);{/php}
			{/if}			
				<form name="other_expenses_form" action="other_expenses.php?job=add_expenses" method="post" class="product">						
					<div class="col-lg-3">	
						<input type="text" class="auto4 form-control" name="expenses_name" value="{$expenses_name}" style="width: 250px;" placeholder="Expenses Name" required/>
					</div>
					<div class="col-lg-5">
						<input type="text" class="form-control" name="detail" value="{$detail}" style="width: 425px;" placeholder="Expenses Detail" required />
					</div>
					<div class="col-lg-2">
						<input type="text" class="form-control" name="amount" value="{$amount}"  placeholder="Amount" required  />
					</div>
					<div class="col-lg-2">
						<input type="submit" name="ok" class="btn btn-primary" style="margin-top: 3px;" value="Add Expense"/>
					</div>			
						{php}list_expenses_by_other_expenses_no($_SESSION['other_expenses_no']);{/php}												
							<th align="right"><strong>{$total}</strong></th>						
				</form>
			</div><br>
			<div class="row">
				<div class="col-lg-12">
					<form name="payment" action="other_expenses.php?job=save" method="post" class="product">          
						<input type="text" class="form-control" name="cheque_amount" value="{$cheque_amount}" style="width: 250px;" placeholder="Cheque Amount"/>
						<input type="text" class="form-control" name="cash_amount" value="{$cash_amount}" style="width: 250px;" placeholder="Cash Amount"/>
						<input type="text" class="form-control" name="cheque_no" value="{$cheque_no}" style="width: 250px;" placeholder="Cheque No"/>
						<input type="text" class="form-control" name="cheque_bank" value="{$cheque_bank}" style="width: 250px;" placeholder="Cheque Bank"/>
						<input type="text" class="form-control" name="cheque_branch" value="{$cheque_branch}"	style="width: 250px;"" placeholder="Cheque Branch"/>
						<input type="text" class="form-control" id="datepicker" style="width: 250px;" placeholder="Cheque Date">
						<input type="text" class="auto form-control" name="supplier_name" value="{$supplier_name}" style="width: 250px;" placeholder="Supplier Name" /></td>
						<input type="text"  class="form-control"  name="temp_name" value="{$temp_name}" style="width: 250px;" placeholder="Temp Supplier*"/>
						<input type="text" class="form-control" id="datepicker1" style="width: 250px;" placeholder="Date">
						<textarea name="remarks" class="form-control" style="width: 250px;" placeholder="Remarks">{$remarks}</textarea>
						<input type="text" class="form-control" name="prepared_by" style="width: 250px;" value="{$prepared_by}" placeholder="Prepared By" readonly="pbd" /><br>
						<input class="pull-left btn btn-success" type="submit"  name="ok" value="Save Payment"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}
