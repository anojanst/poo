{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto1").autocomplete({
		source: "ajax/query_customer_from_sales.php",
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
	<script>
        $(function () {
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
	</script>
	<script>
        $(function () {
            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd',
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
					<h3><strong>Sales Basic Report</strong></h3>
				</div>
			</div>
            
			<div class="row" style="margin-top: 20px; margin-left: 10px;">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>

				<div>
				<form action="sales_basic_report.php?job=search" method="post" class="search">
					 <div class="row">
						<div class="col-lg-2">	
							<div class="form-group">
								<input type="text" class='form-control' name="search_name" value="{$search_name}" size="25" placeholder="Sold TO"/> 
							</div>
						</div>
						<div class="col-lg-2">	
							<div class="form-group">
								<input type="text" class='form-control' name="search_no" value="{$search_no}" size="15" placeholder="Search By Sales No"/> 
							</div>
						</div>
						 <div class="col-lg-2">
							 <div class="form-group">
								 <input type="text" name="to_date" class="form-control" value="{$to_date}" id="datepicker3"  placeholder="To date"/>
							 </div>
						 </div>
						 <div class="col-lg-2">
							 <div class="form-group">
								 <input type="text" name="from_date" class="form-control" value="{$from_date}" id="datepicker2"  placeholder="From date"/>
							 </div>
						 </div>
						 <div class="col-lg-2">
							<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
						</div>
						 <div class="col-lg-1">
						<a href="sales_basic_report.php?job=print" class="btn btn-primary">Print</a>
					</div>
					<div class="col-lg-1">
						<a href="reports.php" class="btn btn-primary">Back</a>
					</div>
					 </div>			
				</form>
				</div>
				
				
			
			<div class="row">
				<div class="col-lg-12">
					{if $search_mode=='on'}
                        {php}list_sales_search_report($_SESSION[search_name], $_SESSION[search_no], $_SESSION[from_date], $_SESSION[to_date]);{/php}
                    {else}
					{php}list_sales();{/php}
					{/if}
				</div>
			</div>
			
		</div>
	</div>
</section>

{include file="js_footer.tpl"}