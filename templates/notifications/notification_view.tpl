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

			<div>
				{php}view_notification($_SESSION['product_id'], $_SESSION['branch']);{/php}
			</div>			


			</div>
		</div>
</section>

	{literal}
		<script>
			 $(function () {
				 $("#example1").DataTable();
			 });
		</script>
	{/literal}

{include file="js_footer.tpl"}

