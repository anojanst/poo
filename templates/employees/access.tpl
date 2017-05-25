{include file="home_header.tpl"}
{include file="navigation.tpl"}

<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div>
				<div class="row">
					<div class="col-lg-12" style="margin-top: -20px;">
						<h3><strong>Add or Remove Permissions</strong></h3>
					</div>
				</div>
            	<div class="row" style="margin-top: 20px; margin-left: 10px;">
					{if $error_report=='on'}
						<div class="error_report" style="margin-bottom: 50px;">
							<strong>{$error_message}</strong>
						</div>
					{/if}
				</div>


				<div class="row">
					<div class="col-lg-12">
				
						<div class="col-lg-6">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Module Name</th>
										<th>Grant Permission</th>
									</tr>
								</thead>
								<tbody>
								{php}list_not_user_module($_SESSION['id']);{/php}
			
								</tbody>
							</table>
						</div>

						<div class="col-lg-6">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Module Name</th>
										<th>Deny Permission</th>
									</tr>
								</thead>
								<tbody>
								{php}list_user_module($_SESSION['id']);{/php}	
			
								</tbody>
							</table>
						</div>

					</div>
				</div>

			</div>                    
		</div>
	</div>
</section>



{include file="js_footer.tpl"}