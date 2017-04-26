{include file="user_header.tpl"}
{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_inventory.php",
		minLength: 1
	});				

});
</script>

<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto1").autocomplete({
		source: "ajax/query_customer.php",
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

<script language="JavaScript" type="text/javascript">
  function product(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_product').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_product').style.visibility="hidden"; 
    }
  }
</script>

<script type="text/javascript">
function calculateBalance(){
	
var x = document.getElementById("total").innerHTML,
	y = document.getElementById("customer_amount").value;

var total = +y - +x;
var cus_amount = +y;
document.getElementById("balance").innerHTML=total.toFixed(2);
document.getElementById("cus_amount").innerHTML=cus_amount.toFixed(2);
}
</script>
{/literal}
	<div id="contents">
		{include file="user_navigation.tpl"}
		{if $error_report=='on'}
		<div class="error_report" style="margin-bottom: 50px;">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		
		<div class="pos_print_preview">
			<div class="pos_header">
				<div class="pos_logo">
					<img src="images/logo.png" width="48" style="border: 3px solid blue;" />
				</div>
				<div class="pos_address">
					<h4 class="pos_heading">Poobalasingam <br /> Book Depot</h4>
					<p class="pos_text">No.309 A 2/3, Galle Road, Colombo 06. <br />+94 11 4 515775</p>
				</div>
			</div>
		
			<div class="pos_basic">
				<p class="pos_text2"><strong>Sales No : </strong>{$sales}
				<br />
				<strong>Date : </strong>{$date}
				</p>
			</div>
			
			<div class="pos_list">
				{php}print_sales_item($_SESSION[print_no]);{/php}
			</div>
			
			<div class="pos_payment">
				<p class="pos_text3"><strong>Total : </strong>{$net_total}
				<br />
				<strong>Discount : </strong>{$discount}
				<br />
				<strong>Net Total : </strong>{$total}
				<br />
				<strong>Customer Paid : </strong>{$customer_amount}
				<br />
				<strong>Balance : </strong>{$balance}
				</p>
			</div>
			
			<div class="pos_footer">
				<h3 class="pos_heading">Thank You. Come Again!</h3>
			</div>
			
			
		
		</div>
	</div>
{include file="user_footer.tpl"}