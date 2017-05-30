{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
	<script>
        $(function () {
            $("#example1").DataTable();
        });
	</script>
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
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Supplier Details</strong></h3>
				</div>
			</div>

			<div class="row">
				<form action="suppliers.php?job=search" method="post" class="search">
					<div class="col-xs-3">
						<a href="suppliers.php?job=add_new" class="btn btn-primary">Add New</a>
						</a>
					</div>
				</form>
			</div>

			<div class="row">
				<div class="col-xs-12">
                    {if $search_mode=='on'}
                        {php}list_supplier_search($_SESSION[search]);{/php}
                    {else}
                        {php}list_suppliers();{/php}
                    {/if}
				</div>
			</div>
		</div>
	</div>
</section>


{include file="js_footer.tpl"}