{include file="home_header.tpl"}
{include file="navigation.tpl"}

<section class="content">
    {if $error_report=='on'}
        <div class="error_report">
            <strong>{$error_message}</strong>
        </div>
    {/if}
    {if $warning_report=='on'}
        <div class="warning_report" style="margin-bottom: 50px;">
            <strong>{$warning_message}</strong>
        </div>
    {/if}
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12" align="center">
                    <h2><strong>Supplier Details </strong></h2>

                </div>
                <form role="form" action="suppliers.php?job=add" method="post" class="product" enctype="multipart/form-data">
                    <div class="row" style="margin-bottom: 10px; margin-left: 20px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">
                                Supplier Name:
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="supplier_name"  value="{$supplier_name}" placeholder="Supplier Name">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Address : </div>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="address"  placeholder="address"> {$address}</textarea>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Telephone No : </div>

                            <div class="col-lg-6">
                                <input class="form-control" name="telephone" value="{$telephone}"  placeholder="Telephone No">
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Fax No : </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="fax" value="{$fax}"  placeholder="Fax No">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Email : </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="email" value="{$email}"  placeholder="Email">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Contact Person : </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="contact_person" value="{$contact_person}"  placeholder="Contact Person">
                            </div>
                        </div>

                        <div class="row" style="margin-left: 20px;">
                            <div class="col-lg-2">
                                {if $edit_mode=='on'}
                                <button type="submit" name="ok" value="Update" class="btn btn-block btn-success btn-lg">Update</button>
                                {else}
                                <button type="submit" name="ok" value="Save" class="btn btn-block btn-success btn-lg">Save</button>
                            </div>
                            <div class="col-lg-2">
                                {/if}
                                <button type="reset" class="btn btn-block btn-danger btn-lg">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{include file="js_footer.tpl"}
{literal}
    <script>
        $(document).on('ready', function() {
            $("#gallery").fileinput({
                showUpload: false,
                maxFileCount: 10,
                mainClass: "input-group-lg"
            });
        });
    </script>

    <script>
        $(document).on('ready', function() {
            $("#input-1").fileinput({
                showUpload: false,
                maxFileCount: 1,
                mainClass: "input-group-lg"
            });
        });
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

        });
    </script>
    <script>
        $(function () {

            $('#datepicker1').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>
{/literal}