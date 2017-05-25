{include file="print_header.tpl"}
{include file="home_header.tpl"}
<div class="row" style="width: 7cm; margin-left:0.5cm;">
    <div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <img  style="margin-top: 5px; margin-left: 34%;" src="images/logo.png" width="60" height="60"/>
        </div>
        <div class="col-xs-12">
            <h3 style="font-size: 25px; text-align: center;  margin-top: -10px; padding: 5px;"><strong>POOBALASINGHAM</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="margin-top: -20px; text-align: center;">
            <strong style=" font-size: 20px;">BOOK DEPOT</strong>
			<p>309 A 2/3, Galle Road, Wellawata. <br /> Tel: 0114515775, 0112504266 <br /> Fax: 0114515775</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <strong>--------------------------------------------------</strong>
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
    <div class="row">
        <div class="col-xs-12">
            <strong>--------------------------------------------------</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            {php}print_sales_item($_SESSION[print_no]);{/php}
        </div>
    </div>
        <p>No Of Items :&nbsp;&nbsp;&nbsp;&nbsp;<strong>{$count}</strong> <br/> No Of Pieces :&nbsp;&nbsp;&nbsp;<strong>{$pieces}</strong></p>
    <p></p>
    <h4 style="text-align: center;">Thank You.Come Again!</h4>
    </div>    
</div>
<div>
<a href="sales.php?job=must_new" class="no-print btn btn-success">New Sales</a>
</div>