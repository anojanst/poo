{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<div class="tab-content">
			<form id="add_product" method="post" class="product" action="inventory.php?job=add" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-6">
						<input class="form-control" type="text" value="{$product_name}" name="product_name" placeholder="Product Name" autofocus="autofocus" required>
					</div>
					<div class="col-lg-6">
						<select class="form-control" name="item_type" placeholder="Item Type" required>
							<option>Item Type</option>
							<option>BOOK</option>
							<option>ACC</option>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-6">
						<input class="form-control" type="text" name="author" value="{$author}" placeholder="Author" required>
					</div>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="isbn" value="{$isbn}" placeholder="ISBN No" required>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-6">
						<input class="form-control" type="text" name="publication" value="{$publication}" class='auto1' placeholder="Publication" required>
					</div>
					<div class="col-lg-6">
						<input class="form-control" type="text" name="barcode" value="{$barcode}" class='auto1' placeholder="Barcode" required/>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-4">
						<input class="form-control" type="text" name="selling_price" value="{$selling_price}" placeholder="Selling Price" required>
					</div>
					<div class="col-lg-4">
						<select class="form-control" name="type" required>
							<option value="" disable selected >Type</option>
							<option >SRI LANKA</option>
							<option>INDIA TAMIL</option>
							<option>INDIA ENGLISH</option>
							<option>DOLLAR</option>
							<option>EURO</option>
							<option>POUNDS</option>
						</select>
					</div>
					<div class="col-lg-4">
						<select class="form-control" name="measure_type" required>
							<option value="" disable selected>Measure Type</option>
							<option>Piece</option>
							<option>Box</option>
							<option>Dozen</option>
							<option>Meters</option>
						</select>
					</div>
				</div>

				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-3">
						<input class="form-control" type="text" name="count" value="{$count}" placeholder="Quantity" required>
					</div>
					<div class="col-lg-3">
						<input class="form-control" type="text" name="page" value="{$page_count}" placeholder="Page" required>
					</div>
					<div class="col-lg-3">
						<input class="form-control" type="text" name="size" value="{$size}"  placeholder="Size" required/>
					</div>
					<div class="col-lg-3">
						<input class="form-control" type="text" name="weight" value="{$weight}" placeholder="Weight" required/>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-12">
						<textarea class="form-control" name="location" rows="2" cols="90" placeholder="Location" >{$location}</textarea>
					</div>
				</div>
                <div class="row" style="margin-top: 10px;"  >
                    <div class="col-lg-12">
                        <div class="span6">
                            <select  multiple="multiple" id="label" name="label[]">
                                {php}list_label($_SESSION[id]);{/php}
                            </select>
                        </div>
                    </div>
                </div>

				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-6">
						<input class="form-control" type="text" name="name_in_ta" value="{$name_in_ta}" placeholder="Name in Tamil or Sinhala" required  />
					</div>
					<div class="col-lg-6"></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-lg-12">
						<input type="file" name="cover" id="cover" placeholder="Cover" required  />
					</div>
				</div>

				<div class="row" style="margin-top: 10px; margin-left: -255px;">
					<div class="col-lg-3">
                        {if $edit_mode=='on'}
							<input type="submit" name="ok" value="Update" />
                        {else}
							<input type="submit" name="ok" value="Save" />
                        {/if}
					</div>
					<div class="col-lg-9"></div>
				</div>
            </form>
		</div>
	</div>
</section>
{literal}
<script src="js/bootstrap.min.js"></script>
<script src="js/kendo.all.min.js"></script>

<script>

    (function($) {
        $("#label").kendoMultiSelect();
    }(jQuery));

</script>
{/literal}

{include file="js_footer.tpl"}