{include file="home_header.tpl"}
{include file="navigation.tpl"}
<!-- Main content -->

<section class="content">
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-9 col-xs-12">
                    <div class="box box-danger box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-building"></i>
                            <h3 class="box-title">Pending Sales</h3>
                        </div>
                        <div class="box-body">
                            {php}last_incomplete_bill();{/php}
                            <h3><strong>Other Pending Sales</strong></h3>
                            {php}all_incomplete_bill();{/php}
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-12">
                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-building"></i>
                            <h3 class="box-title">New Sales</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="sales.php?job=must_new" class="btn btn-success form-control">New Sales</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{include file="js_footer.tpl"}