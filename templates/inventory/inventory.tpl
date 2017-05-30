{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
<script>
	$(document).ready(function() {
		$('#product_name').autocomplete({
			source: 'ajax/query_multiple_stock.php?query=%QUERY'
		});
	})
</script>

<script>
	$(document).ready(function() {
		$('#selected_item').autocomplete({
			source: 'ajax/query_multiple_stock.php?query=%QUERY'
		});
	})
</script>

{/literal}

<section class="content">
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<div class="tab-content">
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
			<div class="row">
				<div class="col-xs-6">
					<h3 style="margin-top: 30px; margin-bottom: 30px;">Product Details</h3>
				</div>
				<form action="inventory.php?job=search" method="post" class="search">
					<div class="col-xs-4" style="margin-top: 30px; margin-bottom: 30px;">
						<input type="text" class='form-control' id="product_name" name="search" value="{$search}" size="47" placeholder="Search"/>
					</div>
					<div class="col-xs-2" style="margin-top: 30px; margin-bottom: 30px;">
						<input type="submit" class="btn btn-primary"  value="search"/>
					</div>
			</div>
			</form>
            {if $search_mode=='on'}
                {php}list_inventory_search($_SESSION[search]);{/php}
            {else}
                {php}list_inventory();{/php}
            {/if}
		</div>
	</div>
</section>

{include file="js_footer.tpl"}