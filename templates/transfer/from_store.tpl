{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}
<script>
  $(function () { 
    $('#datepicker').datepicker({
	  format: 'yyyy-mm-dd',
      autoclose: true
    });
  });
</script>
<script>
  $(function () {
    $('#datepicker1').datepicker({
	  format: 'yyyy-mm-dd',
      autoclose: true
    });
  });
</script>
<script>
	$(document).ready(function() {
		$('#branch').autocomplete({
			source: 'ajax/query_from_store.php?query=%QUERY'
		});
	})
</script>
{/literal}


<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Transfer From Store</strong></h3>
				</div>
			</div>
            
			<div class="row" style="margin-top: 20px; margin-left: 10px;">
				{if $error_report=='on'}
					<div class="error_report" style="margin-bottom: 50px;">
						<strong>{$error_message}</strong>
					</div>
				{/if}
			</div>
            
            <div>
				<form action="transfer.php?job=from_store_search" method="post" class="search">
					 <div class="row">
							<div class="col-lg-3">	
								<div class="form-group">
									<input type="text" id="branch" class='form-control' name="from_branch" value="{$from_branch}" placeholder="Branch"/> 
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group">
									<input type="text" name="from_date" class="form-control" value="{$from_date}" id="datepicker1"  placeholder="From date"/>
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group">
									<input type="text" name="to_date" class="form-control" value="{$to_date}" id="datepicker"  placeholder="To date"/>  
								</div>
							</div>
							<div class="col-lg-2">
								<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
							</div>
						 </div>			
				</form>
			</div>

			<div class="row">
				<div class="col-lg-12">
					{if $search_mode=='on'}
					{php}search_from_store($_SESSION[from_branch],$_SESSION[from_date], $_SESSION[to_date]);{/php}
					{else}
					{php}list_from_store();{/php}
					{/if}
				</div>
			</div>

		</div>
	</div>
</section>



{include file="js_footer.tpl"}