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
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Purchase Order</strong></h3>
				</div>
			</div>
			<div class="row">				
				{if $error_report=='on'}
					<div class="error_report">
						<strong>{$error_message}</strong>
					</div>
				{/if}
					<form action="purchase_order.php?job=search" method="post" class="search">
						<div class="col-lg-5">								
							<input type="text" class='form-control' name="supplier_search" value="{$supplier_search}" placeholder="Search By Supplier"/> 
						</div>				
						<div class="col-lg-5">				
							<input type="text" class='form-control' name="purchase_order_no_search" value="{$purchase_order_no_search}"  placeholder="Search By Purchase No"/> 
						</div>					
						<div class="col-lg-2">	
							<input type="image" src="./images/search.png" height="28" width="28"/>
						</div>		
					</form>
			</div><br>
			<div class="row">
				{if $search_mode=='on'}
					{php}list_purchase_order_search($_SESSION[purchase_order_no_search], $_SESSION[supplier_search]);{/php}
				{/if}
			
				<div class="col-lg-12">
						<h4 style="margin-left: 15px;">Add New Purchase order</h4>
					{if $new}
						<p style="margin-left: 530px; margin-top: -50px;">{$new}</p>				
					{/if}
				</div>
			</div>
			<div class="row">
				<form name="purchase_item_form" action="purchase_order.php?job=purchase_item" method="post" class="product">
					<div class="col-lg-3">		 
						<input style="width: 250px;" type="text" class="form-control" name="product_name" value="{$product_name}" placeholder="Product Name" required/>									
					</div>
					<div class="col-lg-1">
						<input style="width: 80px;" type="text" class="form-control" name="product_id" value="{$product_id}" placeholder="Id" required/>
					</div>
					<div class="col-lg-1">
						<select style="width: 80px;" name="catagory" required>
								<option>Catagory</option>
								<option>{$catagory}</option>
							{section name=parent_catagory loop=$parent_catagorys}
								<option>{$parent_catagorys[parent_catagory]}</option>
							{/section}
						</select> 
					</div> 
					<div class="col-lg-3">
						<input style="width: 250px;" type="text" class="form-control" name="product_description" value="{$product_description}" placeholder="Description" required/>
					</div>
					<div class="col-lg-1">
						<input style="width: 80px;" type="text" class="form-control" name="qty" value="{$qty}" placeholder="Qty" required/>
					</div>
					<div class="col-lg-1">
						<select style="width: 80px;" name="measure_type" required>
							<option>{$measure_type}</option>
							<option>Piece</option>
							<option>Box</option>
							<option>Dozen</option>
							<option>Meters</option>
							<option>Gram</option>
							<option>Kilogram</option>
							<option>Liters</option>
						</select>
					</div>
					<div class="col-lg-1">
						<input style="width: 80px;" type="text" class="form-control" name="buying_price" value="{$buying_price}" placeholder="buying Price" required/>										
					</div>
					<div class="col-lg-1">
						<input type="submit" name="ok" value="Add"/>
					</div>
						{php}list_item_by_purchase_order($_SESSION['purchase_order_no']);{/php}								
				</form>				
			</div><br><br>	
			<div class="row">
				<form name="purchase_form" action="purchase_order.php?job=purchase" method="post" class="product">
					<div class="col-lg-12">	
						<input style="width: 400px;" type="text" class="form-control" name="purchase_order_no" value="{$purchase_order_no}" placeholder="Purchase Order No" required readonly="readonly"/>
						<input type="text" style="width: 150px;" class="form-control" id="datepicker" placeholder="Date">
						<input style="width: 400px;" type="text" class="form-control" name="supplier_name" placeholder="Supplier" value="{$supplier_name}" required />
						<input style="width: 400px;" type="text" class="form-control" name="remarks" placeholder="Remarks" value="{$remarks}" required />
						<input style="width: 400px;" type="text" class="form-control"name="prepared_by" placeholder="Prepared By" value="{$prepared_by}"  required readonly="readonly"/>					
						{if $edit_mode=='on'}
						<input type="text" name="updated_by" value="{$updated_by}" placeholder="Updated By" required readonly="readonly"/>
						{/if}
						{if $edit_mode=='on'}
						<input class="pull-left" type="submit" name="ok" value="Update"/>
						{else}
						<input class="pull-left" type="submit" name="ok" value="Save"/>
						{/if}
					</div>
				</form>					
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}