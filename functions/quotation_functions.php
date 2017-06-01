<?php
function get_total_stock($product_id){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(quantity) as total FROM inventory WHERE product_id='$product_id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function get_total_quotation($quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM quotation_has_items WHERE quotation_no='$quotation_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function add_quotation_item($selected_item, $product_name, $stock, $selling_price, $discount, $quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO quotation_has_items (id, product_id, product_name, stock, selling_price, date, discount, quotation_no, quantity, user_name, total)
	VALUES ('', '$selected_item', '$product_name', '$stock', '$selling_price', '$date', '$discount', '$quotation_no', '1', '$_SESSION[user_name]', '$selling_price')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function check_non_saved_quotation_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM quotation_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function non_save_quotation_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(quotation_no) FROM quotation_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(quotation_no)'];
	}

	include 'conf/closedb.php';
}

function get_quotation_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(quotation_no) FROM quotation_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(quotation_no)']+1;
	}

	include 'conf/closedb.php';
}

function check_added_items($product_id, $quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM quotation_has_items WHERE product_id='$product_id' AND quotation_no='$quotation_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if ($row['count(id)'] >=1) {
			return 1;
		}
		else{
			return 0;
		}
	}

	include 'conf/closedb.php';
}

function update_quotation_item($product_id, $quantity, $item_total, $selling_price, $discount, $quotation_no, $stock){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation_has_items SET
	quantity='$quantity',
	selling_price='$selling_price',
	discount='$discount',
	total='$item_total',
	saved='0',
	stock='$stock'
	WHERE product_id='$product_id' AND cancel_status='0' AND quotation_no='$quotation_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_quotation_item_for_repeative_adding($product_id, $quantity, $item_total){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation_has_items SET
	quantity='$quantity',
	total='$item_total',
	saved='0'
	WHERE product_id='$product_id' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_quantity($product_id, $quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(quantity) as total FROM quotation_has_items WHERE product_id='$product_id' AND quotation_no='$quotation_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}


function print_quotation_item($quotation_no){
	include 'conf/config.php';
   include 'conf/opendb.php';
$i=1;
echo'<table style="width:100%;" class="table-responsive table-bordered table-striped dt-responsive">
      <tr>
		 <th>S.No</th>
         <th>Product</th>
         <th>Qty</th>
		 <th>Unit Price</th>
         <th>Discount</th>
         <th>Amount</th>
      </tr>';

$grand_total=0;
   $result=mysqli_query($conn,"SELECT * FROM quotation_has_items WHERE quotation_no='$quotation_no' AND cancel_status='0'");
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
   {
      $qty=$row[quantity];
      $selling_price=$row[selling_price];
      $discount=$row[selling_price]*($row[discount]/100);
      $qty_selling_price=$qty*$selling_price;
      $qty_discount=$qty*$discount;
      $total=$qty_selling_price-$qty_discount;
      
      echo'<tr style="line-height: 30px;">
      		<td>'.$i.'</td>
            <td>'.$row[product_name].'</td>
            <td>'.$row[quantity].'</td>
            <td>'.number_format($row[selling_price],2).'</td>
            <td>'.number_format($row[discount],2).'</td>		
            <td>'.number_format($total,2).'</td>
         </tr>';
      $i +=1;
$grand_total=$grand_total+$total;
   }
   
   
   echo'<tr  style="line-height: 30px;">
         <td></td>
         <td></td>
   		 <td></td>
   		 <td></td>
         <td><strong>Total</strong></td>
         <td><strong>'.number_format($grand_total,2).'</strong></td>
      </tr>
   </table>';
   include 'conf/closedb.php';
}

function net_total($quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$net_total=0;

	$result=mysqli_query($conn, "SELECT * FROM quotation_has_items WHERE quotation_no='$quotation_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[quantity]*$row[selling_price];
		$net_total=$net_total+$total;

	}

	return $net_total;

	include 'conf/closedb.php';
}

function get_product_info_from_quotation_has_items($product_id, $quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM quotation_has_items WHERE product_id='$product_id' AND quotation_no='$quotation_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_product_info_from_quotation_has_items_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM quotation_has_items WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function cancel_item($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='0'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved_quotation($quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation_has_items SET
	saved='1'
	WHERE quotation_no='$quotation_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


function save_quotation($quotation_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount,$total_after_discount, $total, $balance){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO quotation (id, quotation_no, customer_name, prepared_by, remarks, date, total, due, customer_amount,total_after_discount, discount, balance)
	VALUES ('', '$quotation_no', '$customer_name', '$prepared_by', '$remarks', '$date', '$total', '$total', '$customer_amount','$total_after_discount', '$discount', '$balance')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}


function list_quotation_search($quotation_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($quotation_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($quotation_no_search){
		$quotation_no_check="quotation_no LIKE '%$quotation_no_search'";
	}
	else{
		$quotation_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($quotation_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>quotation No</th>
	<th>quotation Date</th>
	<th>Customer Name</th>
	<th>quotation Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM quotation WHERE $customer_check $and $quotation_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="quotation.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="quotation.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[quotation_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'quotation.php?job=delete&id='.$row[id].'\',\'No\',\'quotation.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}


function list_quotation_search_report($customer_search, $quotation_no_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($quotation_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($quotation_no_search){
		$quotation_no_check="quotation_no='$quotation_no_search'";
	}
	else{
		$quotation_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($quotation_no_search || $customer_search){
	
	echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>quotation No</th>
	<th>quotation Date</th>
	<th>Customer Name</th>
	<th>quotation Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
$i=1;
	$result=mysqli_query($conn, "SELECT * FROM quotation WHERE $customer_check $and $quotation_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>'.$i.'</td>
			<td>'.$row[quotation_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		<td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
		$i++;
	
	
	$total=$total+$row[total];
	$due_total=$due_total+$row[due];
	$paid_total=$paid_total+$row[paid];
	}
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table></div>';
	}
	
	include 'conf/closedb.php';
}

function list_quotation(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<div class="table-responsive">
              <table class="table">
				<thead valign="top">
				<th>No</th>
				<th>quotation No</th>
				<th>quotation Date</th>
				<th>Customer Name</th>
				<th>quotation Total</th>
				<th>Due</th>
				<th>Paid</th>
				<th>Remarks</th>
				<th>Prepared By</th>
			
				</thead>
				<tbody valign="top">';

	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM quotation WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td>'.$i.'</td>
			<td>'.$row[quotation_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
			<td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
	$i=$i+1;
	$total=$total+$row[total];
	$due_total=$due_total+$row[due];
	$paid_total=$paid_total+$row[paid];
	}
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table></div>';
	
	
	
	include 'conf/closedb.php';
}

function get_quotation_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM quotation WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_quotation_info_by_quotation_no($quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM quotation WHERE quotation_no='$quotation_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_quotation($id, $quotation_no, $date, $customer_name, $prepared_by, $remarks,$discount, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation SET
	quotation_no='$quotation_no',
	date='$date',
	customer_name='$customer_name',
	prepared_by='$prepared_by',
	remarks='$remarks',
	total='$total',
    discount='$discount',
	due='$total',
	updated_by='$updated_by' 
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function  calncel_items_for_quotation_no($quotation_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE quotation_no='$quotation_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_quotation($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE quotation SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_quotation_item_id($quotation_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM quotation_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}

	include 'conf/closedb.php';
}