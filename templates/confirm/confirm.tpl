{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script>
	$(function () {
	  $("#example1").DataTable();
	 
	});
	</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Confirm Purchase Orders</strong></h3>
				</div>
			</div><br>		
			<div class="row">      							
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>View</th>
								<th>Purchase Order No</th>
								<th>Purchase Order Date</th>
								<th>Suppier Name</th>
								<th>Purchase Total</th>
								<th>Remarks</th>
								<th>Prepared By</th>
								<th>Confirm</th>        
							</tr>
						</thead>
						{php}list_purchase_orders_for_confirm();{/php}
						<tfoot>
							<tr>
								<th>View</th>
								<th>Purchase Order No</th>
								<th>Purchase Order Date</th>
								<th>Suppier Name</th>
								<th>Purchase Total</th>
								<th>Remarks</th>
								<th>Prepared By</th>
								<th>Confirm</th>        
							</tr>
						</tfoot>
					</table>           
				</div>
			</div>
				<div class="main_user_home" style="min-height: 300px;">
					{if $view_mode=='on'}
					{php}display_purchase_order($_SESSION[purchase_order_no]);{/php}
					{php}display_purchase_order_items($_SESSION[purchase_order_no]);{/php}
					{else}
					{/if}
				</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}