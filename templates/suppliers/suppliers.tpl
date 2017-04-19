{include file="user_header.tpl"}
{literal}
	
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_suppliers.php",
		minLength: 1
	});				

});
</script>

<script language="JavaScript" type="text/javascript">
  function supplier(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_supplier').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_supplier').style.visibility="hidden"; 
    }
  }
</script>


{/literal}

<div id="popupbox_supplier"> 
	<br />
	<form name="add_product" action="suppliers.php?job=add" method="post" class="product">
		<table>
			<tr>
				<td>Supplier Name</td>
				<td> :</td>
				<td><input type="text" name="supplier_name" value="{$supplier_name}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Address</td>
				<td> :</td>
				<td><textarea name="address" cols="34" required>{$address}</textarea></td>		
			</tr>
			<tr>
				<td>Telephone No</td>
				<td> :</td>
				<td><input type="text" name="telephone" value="{$telephone}" size="35"/></td>		
			</tr>
			<tr>
				<td>Fax No</td>
				<td> :</td>
				<td><input type="text" name="fax" value="{$fax}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Email</td>
				<td> :</td>
				<td><input type="text" name="email" value="{$email}" required size="35"/></td>		
			</tr>
			<tr>
				<td>Contact Person</td>
				<td> :</td>
				<td><input type="text" name="contact_person" value="{$contact_person}" size="35"/></td>		
			</tr>
			<tr>
				<td colspan="3"><br />
					{if $edit_mode=='on'}
					<input type="submit" name="ok" value="Update" />
					{else}
					<input type="submit" name="ok" value="Save" />
					{/if}
				</td>		
			</tr>
		</table>
	</form>
	<ul id="navigation" style="position: absolute; bottom: -50px; left: -200px;">
		<li>* Optional</li>
	</ul>
	<a href="javascript:supplier('hide');"><img src="./images/close.png" width="15" height="15" style="position: absolute; top: 5px; right: 5px;"/></a>
</div>
	
	<div id="contents">
		{include file="user_navigation.tpl"}
		<div class="main_user_home" style="min-height: 300px;">
			<div style="float: left; margin-right: 5px; min-height: 300px;">
				<h4 style="margin-top: 30px;">Supplier Details</h4>
			<form action="suppliers.php?job=search" method="post" class="search">
				<table style="margin-top: -60px; margin-left: 485px;">
					<tr>
						<td width="80">
							Add New
						</td>
						<td width="40">
							<a href="javascript:supplier('show');">
								<img alt="add" src="./images/add.png">
							</a>
						</td>
						<td>
							<input type="text" class='auto' name="search" value="{$search}" size="20" placeholder="Search"/> 
						</td>
						<td width="40" align="right" style="padding-bottom: 10px;">
							<input type="image" src="./images/search.png" height="28" width="28"/>
						</td>
					</tr>
				</table>
			</form>
			{if $search_mode=='on'}
			{php}list_supplier_search($_SESSION[search]);{/php}
			{else}
			{php}list_suppliers();{/php}
			{/if}
			</div>
		</div>
	</div>
	

{include file="user_footer.tpl"}