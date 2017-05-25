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
			<h3 style="margin-top: 10px; margin-bottom: 30px;">Author Details</h3>						
				<form action="author.php?job=save" method="post" class="product">
					<div class="row">
						<div class="col-lg-9">
							<input class="form-control" type="text" value="{$author}" name="author" placeholder="Author Name" autofocus="autofocus" required>
						</div>
						<div class="col-lg-3">
							<input class="form-control" type="text" value="{$author_id}" name="author_id" placeholder="Author ID" autofocus="autofocus" required>
						</div>
					</div><br>
					<div class="row">
						<div class="col-lg-12">
							<textarea class="form-control"  name="description" rows="2" placeholder="Description" />{$description}</textarea>																	
						</div>
					</div>
					<div class="row">
						
						<div class="col-lg-3" style="margin-top: 15px;">
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
										<th>Author ID</th>
										<th>Author Name</th>
										<th>Description</th>
										<th>Delete</th>             
									</tr>
								</thead>
								{php}list_author() ;{/php}
								<tfoot>
									<tr>
										<th>Edit</th>
										<th>Author ID</th>
										<th>Author Name</th>
										<th>Description</th>
										<th>Delete</th>
									</tr>
								</tfoot>
							</table>           
						</div>						            											
					</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}