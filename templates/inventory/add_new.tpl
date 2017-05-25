{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}

<script>
	$(document).ready(function() {
		$('#publication').autocomplete({
			source: 'ajax/query_publication.php?query=%QUERY'
		});
	})
</script>
<script>
	$(document).ready(function() {
		$('#author').autocomplete({
			source: 'ajax/query_author.php?query=%QUERY'
		});
	})
</script>

{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Add Inventory</strong></h3>
				</div>
			</div>
            <div class="row" style="margin-top: 20px; margin-left: 10px;">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>
            <div class="row">
				<form id="add_product" method="post" class="product" action="inventory.php?job=add" enctype="multipart/form-data">
					
					<div class="row" style="margin-left: 10px; margin-right: 10px;">
						<div class="col-lg-6">
							<label>Product Name</label>
							<input class="form-control" type="text" value="{$product_name}" name="product_name" placeholder="Product Name" autofocus="autofocus" required>
						</div>
						{if $edit_mode=='on'}
						<div class="col-lg-6">
							<label>Item Type</label>
							<select class="form-control" name="item_type" required>
								{if $item_type}
										<option value="{$item_type}">{$item_type}</option>
								{else}
										<option value="" disabled selected>Item Type</option>
								{/if}
								<option>BOOK</option>
								<option>ACC</option>
							</select>
						</div>
						{else}
						<div class="col-lg-6">
							<label>Item Type</label>
							<select class="form-control" name="item_type" required>
								{if $item_type}
										<option value="{$item_type}">{$item_type}</option>
								{else}
										<option value="" disabled selected>Item Type</option>
								{/if}
								<option>BOOK</option>
								<option>ACC</option>
							</select>
						</div>
						{/if}
					</div>
					
					
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-6">
							<label>Author</label>
							<input class="form-control" type="text" id="author" name="author" value="{$author}" placeholder="Author" required>
						</div>
						<div class="col-lg-6">
							<label>Publication</label>
							<input class="form-control" id="publication" type="text" name="publication" value="{$publication}" class='auto1' placeholder="Publication" required>
						</div>
					</div>


					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-6">
							<label>ISBN No</label>
							<input class="form-control" type="text" name="isbn" value="{$isbn}" placeholder="ISBN No" required>
						</div>
						<div class="col-lg-6">
							<label>Barcode</label>
							<input class="form-control" type="text" name="barcode" value="{$barcode}" class='auto1' placeholder="Barcode" />
						</div>
					</div>
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-6">
							<label>Selling Price</label>
							<input class="form-control" type="text" name="selling_price" value="{$selling_price}" placeholder="Selling Price" required>
						</div>
						<div class="col-lg-6">
							<label>Quantity</label>
							<input class="form-control" type="text" name="count" value="{$quantity}" placeholder="Quantity" required>
						</div>
					</div>
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-6">
							<label>Type</label>
							<select class="form-control" name="type" required>
								{if $type}
										<option value="{$type}">{$type}</option>
								{else}
										<option value="" disabled selected>Type</option>
								{/if}

								<option >SRI LANKA</option>
								<option>INDIA TAMIL</option>
								<option>INDIA ENGLISH</option>
								<option>DOLLAR</option>
								<option>EURO</option>
								<option>POUNDS</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label>Measure Type</label>
							<select class="form-control" name="measure_type" required>
								{if $measure_type}
										<option value="{$measure_type}">{$measure_type}</option>
								{else}
										<option value="" disabled selected>Measure Type</option>
								{/if}
								<option>Piece</option>
								<option>Box</option>
								<option>Dozen</option>
								<option>Meters</option>
							</select>
						</div>
					</div>
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-4">
							<label>Page</label>
							<input class="form-control" type="text" name="page" value="{$page_count}" placeholder="Page" required>
						</div>
						<div class="col-lg-4">
							<label>Size</label>
							<input class="form-control" type="text" name="size" value="{$size}"  placeholder="Size" required/>
						</div>
						<div class="col-lg-4">
							<label>Weight</label>
							<input class="form-control" type="text" name="weight" value="{$weight}" placeholder="Weight" required/>
						</div>
					</div>
					
					
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-12">
							<label>Location</label>
							<textarea class="form-control" name="location" rows="2" cols="90" placeholder="Location" >{$location}</textarea>
						</div>
					</div>
					
					
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-12">
							<label>Label</label>
								<select   class="form-control select2" multiple="multiple" name="label[]">
									{php}list_label($_SESSION[id]);{/php}
								</select>
						</div>
					</div>
					
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-12">
							<label>Name in Tamil or Sinhala</label>
							<input class="form-control" type="text" name="name_in_ta" value="{$name_in_ta}" placeholder="Name in Tamil or Sinhala" required  />
						</div>
					</div>
					
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-12">
							<label>Image</label>
							<input type="file" name="cover" id="cover" placeholder="Cover" />
						</div>
					</div>
	
					<div class="row" style="margin-left: 10px; margin-top: 10px; margin-right: 10px;">
						<div class="col-lg-3" >
							{if $edit_mode=='on'}
								<input type="submit" name="ok" value="Update" class="btn btn-danger"/>
							{else}
								<input type="submit" name="ok" value="Save" class="btn btn-primary"/>
							{/if}
						</div>
						<div class="col-lg-9"></div>
					</div>
					
				</form>
			</div>
			</div>
		</div>
	</div>
</section>

{literal}

 <script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
	
  });
</script>
{/literal}

{include file="js_footer.tpl"}