{include file="home_header.tpl"}
{include file="navigation.tpl"}
{literal}
    <script>
        $( function() {
            $("#product_name").autocomplete({
                source: 'ajax/query_multiple_stock.php'
            });
            $("#load_form").submit();
        });
    </script>

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

                <div class="row">
                    <form action="multiple_stock.php?job=product_details"  name="select_item_form" method="post" >
                        <div class="col-lg-8">
                            <input class="form-control" type="text" value="{$product_name}" id="product_name" name="product_name" placeholder="Product Name"  required>
                        </div>
                        <div class="col-lg-4">
                            <input type="submit" name="ok" value="Next"/>
                        </div>
                    </form>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-lg-4">
                        <select class="form-control" name="branch" value="{$branch}"  required>
                            {if $branch}
                                <option value="{$branch}" selected>{$branch}</option>
                            {else}
                                <option value="" disabled selected>Branch</option>
                            {/if}
                            {php}select_branch();{/php}
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="stock" value="{$stock}" placeholder="Stock" required>
                    </div>
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="reorder" value="{$reorder}" placeholder="Reorder" required>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-lg-12">
                        <textarea class="form-control" name="location" rows="2" cols="90" placeholder="Location" >{$location}</textarea>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px; margin-left: -250px;">
                    <div class="col-lg-3" >
                        <input type="submit" value="Save" />
                    </div>
                    <div class="col-lg-9"></div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-lg-12">
                        {php}list_multiple_stock();{/php}
                    </div>
                </div>
        </div>
    </div>
</section>
{include file="js_footer.tpl"}