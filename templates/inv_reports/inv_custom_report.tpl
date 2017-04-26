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

	<div id="contents">
		{include file="user_navigation.tpl"}
			<div style="width: 910px; min-height: 50px; background-color: #f1f1f1; margin-bottom: 10px; float: left; margin-top: -40px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
			<form action="inv_basic_report.php?job=search" method="post" class="search">
				<table style="margin-top: 0px; margin-left: 5px;">
					<tr>
						<td>
							<input type="text" class='auto' name="search" value="{$search}" size="60" placeholder="Search Inventory"/> 
						</td>
						<td width="40" align="right" style="padding-bottom: 10px;">
							<input type="image" src="./images/search.png" height="28" width="28"/>
						</td>
						{if $search_mode=='on'}
						<td width="220" align="center">
							<a href="inv_basic_report.php" style="font-size:23px;">Full Summary</a>
						</td>
						{else}
						{/if}
					</tr>
				</table>
			</form>
			</div>
			<div class="main_user_home" style="min-height: 300px; margin-top: 5px;">
			<a href="inv_basic_report.php?job=custom_print" class="more">Print</a>
			<a href="inv_basic_report.php?job=select_fields" class="more" style="width: 200px; margin-left: 100px;">custom Report</a>
			{if $search_mode=='on'}
			{php}list_inventory_custom_report_search($_SESSION[report_search]);{/php}
			{else}
			{php}list_inventory_custom_report();{/php}
			{/if}
			</div>
		</div>

{include file="user_footer.tpl"}