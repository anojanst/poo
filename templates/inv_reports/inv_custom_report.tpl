{include file="home_header.tpl"}
{include file="navigation.tpl"}

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
<section class="content">
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <form action="inv_basic_report.php?job=search" method="post" class="search">
                <div class= "row">
                    <div class="col-lg-10">
                        <input type="text" class='form-control' name="search" value="{$search}" size="60" placeholder="Search Inventory"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-primary" value="Search"/>
                    </div>
                </div>
                <div class= "row">
                    <div class="col-lg-6">
                        {if $search_mode=='on'}
                            <a href="inv_basic_report.php" style="font-size:23px;">Full Summary</a>
                        {else}
                        {/if}
                    </div>
                    <div class="col-lg-6"></div>
                </div><br/>
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <a href="inv_basic_report.php?job=custom_print" class="more btn btn-primary">Print</a>
                    <a href="inv_basic_report.php?job=select_fields" class="more btn btn-primary" style="width: 200px; margin-left: 100px;">custom Report</a>
                </div>
            </div>
            {if $search_mode=='on'}
                {php}list_inventory_custom_report_search($_SESSION[report_search]);{/php}
            {else}
                {php}list_inventory_custom_report();{/php}
            {/if}
        </div>
    </div>
</section>

{include file="js_footer.tpl"}