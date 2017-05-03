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
  <div class="col-lg-12" style="margin-left: 20px;">
   <div class="row">
      <div class="col-xs-6">
         <img src="images/logo.png"  height="120" width= "170" alt="Poobalasingam">
      </div>
      <div class="col-xs-6" style="text-align: right;">
         <p><strong>Tel :</strong> 0772928907</p>
         <p style="margin-top: -30px;"><strong>Address :</strong> No 18, 1st floor, 2nd Rohin Lane</p>
         <p style="margin-left: 80px; margin-top: -30px;"> (Off Malwatta Rd) Colombo 11.</p>
         <p style="margin-left: 80px; margin-top: -30px;"><strong>Email :</strong> wvgraphix2011@gmail.com</p>
         <p style="margin-left: 80px; margin-top: -30px;"> mohann509@gmail.com</p>
      </div>
   </div>

 <div class="row">
      	<div class="col-xs-6" style="text-align: left;">
		 <h4><strong>Quotation for</strong></h4>
         <p><strong>Name :</strong>{$customer_name}</p>
         <p style="margin-top: -30px;"><strong>Address :</strong> {$customer_address} </p>
         <p style="margin-top: -30px;"><strong>Tel :</strong>  {$customer_tel}</p>

   		</div>
</div>


   <div class="row">
      <div class="col-xs-6">
         <strong>Quotation No : </strong>{$quotation}
      </div>
      <div class="col-xs-6" style="text-align: right;">
         <strong>Date : </strong>{$date}    
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12">       
         {php}print_quotation_item($_SESSION['print_no']);{/php}
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12" style="margin-left: 300px;">

      </div>
   </div> 
 </div>
</div>
	
   <div class="row" style="margin-left: 40px;">
		<a href="quotation.php?job=quotation_page" class="no-print btn btn-success">New Quotation</a>
	</div>
</div>