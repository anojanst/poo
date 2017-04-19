{include file="user_header.tpl"}

{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto1").autocomplete({
		source: "ajax/query_customer_from_sales.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto2").autocomplete({
		source: "ajax/query_sales_no.php",
		minLength: 1
	});				

});
</script>
{/literal}

	<div id="contents">
		{include file="user_navigation.tpl"}
			<div style="width: 910px; min-height: 50px; background-color: #f1f1f1; margin-bottom: 10px; float: left; margin-top: -40px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
			<form action="sales_basic_report.php?job=search" method="post" class="search">
				<table style="margin-top: 0px; margin-left: 5px;">
					<tr>
					<td width="150"><strong>Search Sales</strong></td>
					<td width="350">
						<input type="text" class='auto1' name="search_name" value="{$search_name}" size="25" placeholder="Sold TO"/> 
					</td>
					<td width="80">
						OR
					</td>
					<td width="180">
						<input type="text" class='auto2' name="search_no" value="{$search_no}" size="15" placeholder="Search By Sales No"/> 
					</td>
					<td width="30" style="padding-bottom: 10px;">
						<input type="image" src="./images/search.png" height="28" width="28"/>
					</td>
				</tr>
				</table>
			</form>
			</div>
			<div class="main_user_home" style="min-height: 300px; margin-top: 5px;">
			<a href="sales_basic_report.php?job=print" class="more">Print</a>
			{if $search_mode=='on'}
			{php}list_sales_search_report($_SESSION[search_name], $_SESSION[search_no]);{/php}
			{else}
			{php}list_sales();{/php}
			{/if}
			</div>
		</div>

{include file="user_footer.tpl"}