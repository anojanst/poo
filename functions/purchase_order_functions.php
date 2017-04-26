<?php
function check_non_saved_purchase_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM purchase_order_has_items WHERE user_name='$user_name' AND saved='0'");
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

function non_save_purchase_order_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(purchase_order_no) FROM purchase_order_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(purchase_order_no)'];
	}

	include 'conf/closedb.php';
}

function get_purchase_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(purchase_order_no) FROM purchase_order_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(purchase_order_no)']+1;
	}

	include 'conf/closedb.php';
}

function save_item($product_id, $product_name, $quantity, $buying_price, $catagory, $product_description, $measure_type, $purchase_order_no, $user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	$total = $quantity*$buying_price;
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO purchase_order_has_items (id, product_id, product_name, quantity, buying_price, date, catagory, product_description, measure_type, purchase_order_no, user_name, total)
	VALUES ('', '$product_id', '$product_name', '$quantity', '$buying_price', '$date', '$catagory', '$product_description', '$measure_type', '$purchase_order_no', '$user_name', '$total')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_item_by_purchase_order($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0' ORDER BY id ASC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo"<table>
		<tbody>
		<tr>
		<td>$row[product_name]</td>
		<td>$row[product_id]</td>
		<td>$row[catagory]</td>
		<td>$row[product_description]</td>
		<td>$row[quantity]</td>
		<td>$row[measure_type]</td>
		<td align='right'>$row[buying_price]</td>
		<td align='right'>$row[total]</td>".'
		<td ><a href="purchase_order.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr>		
		</tbody>
		</table>';
	}

	include 'conf/closedb.php';
}

function delete_item($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order_has_items SET
	saved='1'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_total($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}


function save_purchase_order($purchase_order_no, $date, $supplier_name, $prepared_by, $remarks, $total){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO purchase_order (id, purchase_order_no, supplier_name, prepared_by, remarks, date, total, due)
	VALUES ('', '$purchase_order_no', '$supplier_name', '$prepared_by', '$remarks', '$date', '$total', '$total')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_purchase_order_search($purchase_order_no_search, $supplier_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($purchase_order_no_search && $supplier_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($purchase_order_no_search){
		$purchase_order_no_check="purchase_order_no LIKE '%$purchase_order_no_search'";
	}
	else{
		$purchase_order_no_check="";
	}

	if($supplier_search){
		$suppier_check="supplier_name='$supplier_search'";
	}
	else{
		$suppier_check="";
	}
	
	if($purchase_order_no_search || $supplier_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Suppier Name</th>
	<th>Purchase Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE $suppier_check $and $purchase_order_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="purchase_order.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="purchase_order.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[purchase_order_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'purchase_order.php?job=delete&id='.$row[id].'\',\'No\',\'purchase_order.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function list_purchase_orders(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Suppier Name</th>
	<th>Purchase Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="purchase_order.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="purchase_order.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[purchase_order_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td>'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'purchase_order.php?job=delete&id='.$row[id].'\',\'No\',\'purchase_order.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function get_purchase_order_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_purchase_order_info_by_purchase_no($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE purchase_order_no='$purchase_order_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_purchase_order($id, $purchase_order_no, $date, $supplier_name, $prepared_by, $remarks, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	purchase_order_no='$purchase_order_no',
	date='$date',
	supplier_name='$supplier_name',
	prepared_by='$prepared_by',
	remarks='$remarks',
	total='$total',
	due='$total',
	updated_by='$updated_by' 
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function  calncel_items_for_purchase_order_no($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_purchase_order($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_purchase_order_item_id($purchase_order_no) {
	include 'functions/config.php';
	include 'functions/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM purchase_order_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}
	
	include 'conf/closedb.php';
}