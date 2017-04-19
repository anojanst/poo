{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}	
<script>
$(function () {
  $("#example1").DataTable();
		responsive: true
});
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h4><strong>Inventory Report</strong></h4>
				</div>
			</div>
			<div class="row">				
				<form action="inv_basic_report.php?job=search" method="post" class="search">
					<div class="col-lg-4">
						<input type="text" class='auto form-control' name="search" value="{$search}" placeholder="Search Inventory"/> 
					</div>
					<div class="col-lg-1">
						<input type="image" src="./images/search.png" height="28" width="28"/>
					</div>
					<div class="col-lg-3">
						<a href="inv_basic_report.php?job=print" class="more">Print</a>
					</div>
					<div class="col-lg-4" style="margin-left: 50px; margin-top: -30px;">
						<a href="inv_basic_report.php?job=select_fields" class="more" style="width: 200px; margin-left: 100px;">custom Report</a>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-md-6">
					{if $search_mode=='on'}
					<a href="inv_basic_report.php" style="font-size:23px;">Full Summary</a>							
					{else}
					{/if}										
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="box-body">
						<table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
						<thead>
							<tr>
								<th>P.ID</th>
								<th>P.Name</th>
								<th>Stock</th>
								<th>Sold</th>
								<th>S.Price</th>
								<th>B.Price</th>
								<th>Value</th>
								<th>Discount</th>
								<th>Pur.Date</th>            
							</tr>
						</thead>
						{php}list_inventory_basic_report();{/php}
						<tfoot>
							<tr>								
								<th>P.ID</th>
								<th>P.Name</th>
								<th>Stock</th>
								<th>Sold</th>
								<th>S.Price</th>
								<th>B.Price</th>
								<th>Value</th>
								<th>Discount</th>
								<th>Pur.Date</th> 
							</tr>
						</tfoot>
						</table>           
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

{include file="js_footer.tpl"}