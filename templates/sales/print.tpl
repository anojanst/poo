{include file="print_header.tpl"}
{include file="home_header.tpl"}
<div class="row" style="width: 6.4cm;  margin-top: -10px;">
    <div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <img  style="margin-left: 60px;" src="images/logo.png" width="100" height="100"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h3 style="font-size: 20px; margin-left: 20px; margin-top: -10px;"><strong>POOBALASINGAM</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="margin-top: -10px;">
            <strong style="margin-left: 60px; ">Book Depot</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <strong>---------------------------------------------------</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            {php}print_sales_item($_SESSION[print_no]);{/php}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <strong >Sales No : </strong>{$sales}
        </div>
        <div class="col-xs-6">
            <strong style="text-align: right; margin-left: -27px;">Date : </strong>{$date}
        </div>
    </div>
    
    <h4 style="text-align: center;">Thank You.Come Again!</h4>
    </div>    
</div>
<div>
<a href="sales.php" class="no-print btn btn-success">New Sales</a>
</div>