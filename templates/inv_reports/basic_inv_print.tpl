{include file="print_header.tpl"}
<h3>Imperial College</h3> 

<h3>Closing Inventory as at {$today} </h3>


			<div style="min-height: 300px; weight: 1000px; margin-top: 5px;">
			{if $search_mode=='on'}
			{php}list_inventory_basic_report_search($_SESSION[report_search]);{/php}
			{else}
			{php}list_inventory_basic_report();{/php}
			{/if}
			</div>


