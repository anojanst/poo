{include file="home_header.tpl"}
{include file="navigation.tpl"}
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
				<div style="min-height: 300px;">			
					<h3 style="margin-top: 30px; margin-bottom: 30px;">Product Details</h3>						
					{include file="product_table.tpl"}			
				</div>
			</div>
		</div>
</section>

{include file="js_footer.tpl"}