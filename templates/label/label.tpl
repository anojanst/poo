<!DOCTYPE html>
{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}
<script>
	$(function () {
	  $("#example1").DataTable();						   
	});
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<div class="tab-content">
			<div style="min-height: 300px;">			
				<h3 style="margin-top: 30px; margin-bottom: 30px;">Label Details</h3>						
					<form action="label.php?job=save" method="post" class="product">
						<div class="row">
							<div class="col-lg-9">
								<input class="form-control" type="text" value="{$label}" name="label" placeholder="Label" autofocus="autofocus" required>
							</div>
							<div class="col-lg-3" >
								{if $edit_mode=='on'}
								<input type="submit" name="ok" value="Update" class="btn btn-primary"/>
								{else}
								<input type="submit" name="ok" value="Save" class="btn btn-primary"/>
								{/if}
							</div>
						</div>							
					</form>				
					<div class="row">      							
						  <div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
							  <thead>
							  <tr>
								<th>Edit</th>
								<th>ID</th>
								<th>Label</th>
								<th>Delete</th>             
							  </tr>
							  </thead>
							  {php}list_label();{/php}
							  <tfoot>
							  <tr>
								<th>Edit</th>
								<th>ID</th>
								<th>Label</th>
								<th>Delete</th>
							  </tr>
							  </tfoot>
							</table>           
						</div>						            			  								
					</div>
				</div>
			</div>
		</div>
</section>
{include file="js_footer.tpl"}