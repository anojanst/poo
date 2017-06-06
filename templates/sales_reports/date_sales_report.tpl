{include file="home_header.tpl"}
{include file="navigation.tpl"}

{literal}
    <script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto1").autocomplete({
                source: "ajax/query_customer_from_sales.php",
                minLength: 1
            });

        });
    </script>

    <script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto2").autocomplete({
                source: "ajax/query_sales_no.php",
                minLength: 1
            });

        });
    </script>

    <script>
        $(function () {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
{/literal}

<section class="content">
    <div class="nav-tabs-custom">
        <div class="tab-content">

            <div class="row">
                <div class="col-lg-12">
                    <h3><strong>Today Sales Report</strong></h3>
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
                <form action="sales_basic_report.php?job=date_sales" method="post" class="search">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="text" name="date" class="form-control" value="{$date}" id="datepicker"  placeholder="Date"/>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-lg-1">
                            <a href="sales_basic_report.php?job=today_sales_print" class="btn btn-primary">Print</a>
                        </div>
                        <div class="col-lg-1">
                            <a href="reports.php" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {php}list_date_sales_report($_SESSION[date]);{/php}
                </div>
            </div>

        </div>
    </div>
</section>

{include file="js_footer.tpl"}