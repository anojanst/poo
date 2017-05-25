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
            <div class="col-xs-10" style="margin-left:-10px;">
                <h3><strong>POOBALASINGAM BOOK DEPOT</strong></h3>
            </div>
        </div>

        <div class="col-xs-8 col-xs-offset-2">
            <div class="col-xs-1"></div>
            <div class="col-xs-11">
                <p style=" margin-left: 10px;"><strong>Wellawatte Bridge, 309 A 2/3, Galle Rd, Colombo,<br> Sri Lanka.</strong><br/> <strong>Tel :</strong> +94 11 4 515775  </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6" style="margin-left: 30px;">
            <h4><strong>Quotation for</strong></h4>
            <p><strong>Name :</strong>{$customer_name}</p>
            <p style="margin-top: -30px;"><strong>Address :</strong> {$customer_address} </p>
            <p style="margin-top: -30px;"><strong>Tel :</strong>  {$customer_tel}</p>
        </div>
        <div class="col-xs-3" style="padding-top: 50px;">
            <strong>Quotation No : </strong><span style="font-size: 25px;">{$quotation}</span><br/>
            <strong>Date : </strong>{$date}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="margin-left: 30px;">
            {php}print_quotation_item($_SESSION['print_no']);{/php}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="margin-left: 30px;">
            <h4><strong>NOTE</strong></h4>
            <strong>*</strong><br/>
            <strong>*</strong><br/>
            <strong>*</strong>
        </div>
    </div>
</div>