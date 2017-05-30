{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12">
                    <h3><strong>Purchase Order Payment</strong></h3>
                </div>
            </div>
            <div class="row">
                {if $error_report=='on'}
                    <div class="error_report" style="margin-bottom: 50px;">
                        <strong>{$error_message}</strong>
                    </div>
                {/if}
                <form action="purchase_order_payment.php?job=search" method="post" class="search">
                    <div class="col-lg-5">
                        <input type="text" class='auto1 form-control' name="supplier_search" value="{$supplier_search}" size="20" placeholder="Search By Supplier"/>
                    </div>
                    <div class="col-lg-5">
                        <input type="text" class='auto2 form-control' name="purchase_order_payment_no_search" value="{$purchase_order_payment_no_search}" size="20" placeholder="Purchase Order Payment No"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-primary" value="Search"/>
                    </div>
                </form>
                {if $search_mode=='on'}
                    {php}list_purchase_order_payment_search($_SESSION[purchase_order_payment_no_search], $_SESSION[supplier_search]);{/php}
                {/if}
            </div><br>
            <div class="row">
                <div class="col-lg-5">
                    <form action="purchase_order_payment.php?job=supplier" method="post">
                        <input type="text" class='auto1  form-control' size ="30" name="supplier_name" value="{$supplier_name}" size="30" placeholder="Pay For Supplier Name" style='color: #000; font: 16px/30px Arial, Helvetica, sans-serif; height: 33px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; '/>
                    </form>
                </div>
                <div class="col-lg-5">
                    <form action="purchase_order_payment.php?job=purchase_order" method="post">
                        <input type="text" class='auto3  form-control' name="purchase_order_no" value="{$purchase_order_no_select}" size="15" placeholder="Pay For Purchase Order No" style='color: #000; font: 16px/30px Arial, Helvetica, sans-serif; height: 33px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; '/>
                    </form>
                </div>
                <div class="col-lg-2"></div>
            </div>
            {if $show=='on' }
                <div>
                    <p style="margin-top: 20px;">Pending Purchase Order Payments.</p>
                    {if $supplier_name}
                        <div>
                            {php}list_purchase_order_of_supplier($_SESSION['supplier_name']);{/php}
                        </div>
                    {elseif $purchase_order_no_select}
                        <div>
                            {php}list_purchase_order_of_purchase_no($_SESSION['purchase_order_no']);{/php}
                        </div>
                    {/if}

                    {if $added=='on'}
                        <p style="margin-top: 10px; margin-bottom: 5px;">Added Purchase Order Payments.</p>
                        {php}list_added_purchase_orders($_SESSION['random_no']);{/php}
                    {/if}
                    <div class="row"  style="margin-top: 50px;" >
                        <form name="payment" action="purchase_order_payment.php?job=save_payment" method="post" class="product">

                            <div class="col-lg-6">
                                <div>
                                    <div>Cheque Amount</div>
                                    <div width="350"> <input type="text" class="form-control" name="cheque_amount" value="{$cheque_amount}" size="25"/></div>
                                    <div>Cash Amount</div>
                                    <div> <input type="text" class="form-control" name="cash_amount" value="{$cash_amount}" size="25"/></div>
                                </div>
                                <div>
                                    <div>Cheque No</div>
                                    <div> <input type="text" class="form-control" name="cheque_no" value="{$cheque_no}" size="25"/></div>
                                </div>
                                <div>
                                    <div>Bank</div>
                                    <div><input type="text" class="form-control" name="cheque_bank" value="{$cheque_bank}" size="25"/></div>
                                </div>
                                <div>
                                    <div>Branch</div>
                                    <div><input type="text" class="form-control" name="cheque_branch" value="{$branch}" size="25"/></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>Cheque Date</div>
                                <div><input type="text" class="form-control" name="cheque_date" value="{$cheque_date}" id="datepicker1" required size="25" /></div>
                                <div width="125">Date</div>
                                <div><input type="text" class="form-control" name="date" id="datepicker2" value="{$date}" size="25"/></div>
                                <div>Remarks</div>
                                <div><textarea name="remarks" class="form-control" >{$remarks}</textarea></div>
                                <div>Prepared By</div>
                                <div><input type="text" class="form-control" name="prepared_by" value="{$prepared_by}" readonly size="25"/></div>
                                <br/>
                                <input type="submit" name="ok" class="btn btn-success" value="Save Payment" />
                        </form>
                    </div>
                </div>
            {/if}
</section>
{include file="js_footer.tpl"}
{literal}
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
    <script>
        $(function () {

            $('#datepicker1').datepicker({
            });
        });
        $(function () {

            $('#datepicker2').datepicker({
            });
        });
    </script>
{/literal}
