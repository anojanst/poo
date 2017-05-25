{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row" style="margin-left: 20px;">
				<div class="col-lg-12">
					<h1><strong>Basic Details</strong></h1>
				</div>
			</div>
			<div class="row" style="margin-left: 20px;">
				<div class="col-lg-12">
					<form action="detail.php?job=save" method="post" class="settings">
						<input type="text" class="form-control" name="org_name" style="width: 400px;" value="{$org_name}" placeholder="Organization Name" required />	
						<textarea name="address" class="form-control" style="width: 400px;" placeholder="Address" />{$address}</textarea>	
						<input type="text" class="form-control" style="width: 400px;"  name="telephone" value="{$telephone}" placeholder="Telephone No" required />	
						<input type="text" class="form-control" style="width: 400px;"  name="fax" value="{$fax}" placeholder="Fax No" required />
						<input type="text" class="form-control" style="width: 400px;"name="email" value="{$email}" placeholder="E-mail" required />	
						<input type="text" class="form-control" style="width: 400px;" name="owner_name" value="{$owner_name}" placeholder="Owner Name" required />	
						<input type="text" class="form-control" style="width: 400px;"  name="owner_telephone" value="{$owner_telephone}" placeholder="Owner's Telephone No " required />		
						<input type="text" class="form-control" style="width: 400px;" name="owner_email" value="{$owner_email}" placeholder="Owner's E-mail" required /><br/>
						<input type="submit" name="save" value="Save" class="btn btn-primary"/>	
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}