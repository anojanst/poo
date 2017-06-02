{include file="print_header.tpl"}
{include file="home_header.tpl"}

<div class="row" style="width: 210mm; height: 297mm;  margin-top: -10px;">
    {include file="print_header.tpl"}
    {literal}
        <style type="text/css" media="print">
            .no-print { display: none; }
        </style>
    {/literal}
    <div class= "row" style="width: 210mm; margin-top: 10px;">
        <div class="col-xs-12">
            <div class="col-xs-8  col-xs-offset-2">
                <div class="col-xs-2">
                    <img   src="images/logo.png" width="60" height="60"/>
                </div>
                <div class="col-xs-10" >
                    <h3><strong>POOBALASINGAM BOOK DEPOT</strong></h3>
                </div>
            </div>

            <div class="col-xs-8 col-xs-offset-2"style="margin-left: 155px;margin-top: -10px;">
                <div class="col-xs-1"></div>
                <div class="col-xs-11">
                    <p style=" margin-left: 10px;"><strong>Wellawatte Bridge, 309 A 2/3, Galle Rd, Colombo, Sri Lanka.</strong><br/> <strong>Tel :</strong> +94 11 4 515775  </p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left: 45px;">
            <div class="col-xs-3" >
                <strong>Sales No : </strong>{$sales}
            </div>
            <div class="col-xs-6"></div>

            <div class="col-xs-3" >
                <strong style="text-align: left;">Date : </strong>{$date}
            </div>
        </div>
        <div class="row" >
            <div class="col-xs-12" style="margin-left: 60px;">
                {php}print_big_bill($_SESSION['print_no']);{/php}
            </div>
        </div>
        <div class="row" style="margin-left: 45px;">
            <div class="col-xs-12">
                <h4><strong>NOTE</strong></h4>
                <strong>*</strong><br/>
                <strong>*</strong><br/>
                <strong>*</strong>
            </div>
        </div>
        <div>
            <a href="sales.php?job=must_new" class="no-print btn btn-success">New Sales</a>
        </div>
    </div>
