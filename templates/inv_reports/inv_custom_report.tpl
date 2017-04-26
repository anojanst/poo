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
{/literal}

<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Custom Report</strong></h3>
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
			<form action="inv_basic_report.php?job=search" method="post" class="search">
				<div class="row">
				   <div class="col-lg-3">	
					   <div class="form-group">
							<input type="text" class='auto' name="search" value="{$search}" size="60" placeholder="Search Inventory"/> 
						</div>
					</div>
					<div class="col-lg-2">
							<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
					</div>
				</div>
				
			<div class="row">
				<div class="col-lg-12">
						{if $search_mode=='on'}
						<td width="220" align="center">
							<a href="inv_basic_report.php" style="font-size:23px;">Full Summary</a>
						</td>
						{else}
				</div>
			</div>
			</form>
		</div>
			
			<div class="row">
				<div class="col-lg-12">
					<a href="inv_basic_report.php?job=custom_print" class="more">Print</a>
					<a href="inv_basic_report.php?job=select_fields" class="more" style="width: 200px; margin-left: 100px;">custom Report</a>
					{if $search_mode=='on'}
					{php}list_inventory_custom_report_search($_SESSION[report_search]);{/php}
					{else}
					{php}list_inventory_custom_report();{/php}
					{/if}
				</div>
			</div>
	
		</div>
	</div>
</section>
{include file="user_footer.tpl"}