<?php

//purchase_order_payment_function_starts
function list_purchase_order_of_supplier($supplier_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Purchase Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Pay</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE supplier_name='$supplier_name' AND due > 0 AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="purchase_order_payment.php?job=add_pay&purchase_order_no='.$row[purchase_order_no].'" method="post">';
				
				echo"
				<td align='center'>$row[purchase_order_no]</td>
						
				<td align='center'>$row[date]</td>
				
				<td align='right'>$row[total]</td>
				
				<td align='right'>$row[paid]</td>
			
				<td align='right'>$row[due]</td>
			
				<td align='right' width='140'><input type='text' name='pay' value='$row[due]' size='15' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
				
				<td align='right' width='50'><input type='submit' name='add' value='Add' class='more' style='width: 70px; border: 0; padding: 4px;'/></td>
				
			</form>
		
		</tr>";
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function list_purchase_order_of_purchase_no($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Purchase Order No</th>
	<th>Purchase Order Date</th>
	<th>Purchase Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Pay</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE purchase_order_no='$purchase_order_no' AND due > 0 AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="purchase_order_payment.php?job=add_pay&purchase_order_no='.$row[purchase_order_no].'" method="post">';
				
				echo"
				<td align='center'>$row[purchase_order_no]</td>
						
				<td align='center'>$row[date]</td>
				
				<td align='right'>$row[total]</td>
				
				<td align='right'>$row[paid]</td>
			
				<td align='right'>$row[due]</td>
			
				<td align='right' width='140'><input type='text' name='pay' value='$row[due]' size='15' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
				
				<td align='right' width='50'><input type='submit' name='add' value='Add' class='more' style='width: 70px; border: 0; padding: 4px;'/></td>
				
			</form>
		
		</tr>";
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function update_purchase_order_due($purchase_order_no, $pay) {
	$purchase_order_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
	$due=$purchase_order_info['due']-$pay;
	$update_paid=$purchase_order_info['paid']+$pay;
	$update_payment_status=$purchase_order_info['payment_status']+1;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	paid='$update_paid',
	payment_status='$update_payment_status',
	due='$due'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_purchase_payment_purchase_order_in_temp_table($purchase_order_no, $random_no, $pay, $user_name){

	$purchase_order_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
	$purchase_order_date=$purchase_order_info['date'];
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_purchase_payment_has_purchase_order (amount, purchase_order_no, random_no, purchase_order_date, user_name)
	VALUES ('$pay', '$purchase_order_no', '$random_no', '$purchase_order_date', '$user_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_added_purchase_orders($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
		  <thead>
    		<tr>
    		<th>Purchase Order No</th>
    		<th>Purchase Order Date</th>
     		<th>Paid</th>
		    <th>Remove</th>
		   </tr>
  		</thead>
  		<tbody>';

	$result=mysqli_query($conn, "SELECT * FROM temp_purchase_payment_has_purchase_order WHERE random_no='$random_no' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td align="center">'.$row[purchase_order_no].'</td>
		<td align="center">'.$row[purchase_order_date].'</td>
		<td align="right">'.$row[amount].'</td>
		<td align="center"><a href="purchase_order_payment.php?job=delete_pay&id='.$row[id].'&purchase_order_no='.$row[purchase_order_no].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr>
		';
	}

	echo '<tr>
	<td></td>
	<td></td>	
	<th align="right">'.get_purchase_payment_total($random_no).'</th>
	<td></td>
	
	</tr>';

	echo '</tbody></table>';


	include 'conf/closedb.php';
}

function get_purchase_payment_total($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT SUM(amount) FROM temp_purchase_payment_has_purchase_order WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row['SUM(amount)'];
	}

	return $total;

	include 'conf/closedb.php';
}

function check_added_purchase_order($purchase_order_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM temp_purchase_payment_has_purchase_order WHERE purchase_order_no='$purchase_order_no' AND random_no='$random_no'");
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

function update_purchase_payment_purchase_order_in_temp_table($purchase_order_no, $random_no, $pay){
	$purchase_payment_info=get_purchase_payment_temp_info_by_purchase_no($purchase_order_no, $random_no);
	$amount=$purchase_payment_info['amount']+$pay;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE temp_purchase_payment_has_purchase_order SET
	amount='$amount'
	WHERE purchase_order_no='$purchase_order_no' AND random_no='$random_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_purchase_payment_temp_info_by_purchase_no($purchase_order_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_purchase_payment_has_purchase_order WHERE purchase_order_no='$purchase_order_no' AND random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_purchase_payment_info_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_purchase_payment_has_purchase_order WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'conf/closedb.php';
}

function update_purchase_order_after_delete_temp($purchase_order_no, $paid, $due, $payment_status){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	paid='$paid',
	due='$due',
	payment_status='$payment_status'
	WHERE purchase_order_no='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_purchase_payment_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_purchase_payment_has_purchase_order WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_purchase_payment($purchase_order_payment_no, $supplier_name, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $cash_amount, $total, $prepared_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO purchase_order_payment (purchase_order_payment_no, supplier_name, date, remarks, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, cash_amount, total, prepared_by)
	VALUES ('$purchase_order_payment_no', '$supplier_name', '$date', '$remarks', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$cash_amount', '$total', '$prepared_by')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';

}

function get_purchase_order_payment_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT MAX(purchase_order_payment_no) FROM purchase_order_payment ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(purchase_order_payment_no)']+1;
	}

	include 'conf/closedb.php';
}

function transfer_purchase_order($random_no, $purchase_order_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_purchase_payment_has_purchase_order WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$purchase_order_no=$row['purchase_order_no'];
		$amount=$row['amount'];

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = "INSERT INTO purchase_payment_has_purchase_order (purchase_order_payment_no, purchase_order_no, amount)
		VALUES ('$purchase_order_payment_no', '$purchase_order_no', '$amount')";
		mysqli_query($conn, $query) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function delete_temp_data_purchase_payment($random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_purchase_payment_has_purchase_order WHERE random_no='$random_no'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_purchase_order_payment_search($purchase_order_payment_no_search, $supplier_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($purchase_order_payment_no_search && $supplier_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($purchase_order_payment_no_search){
		$purchase_order_no_check="purchase_order_payment_no LIKE '%$purchase_order_payment_no_search'";
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
	
	if($purchase_order_payment_no_search || $supplier_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Print</th>
	<th>Payment No</th>
	<th>Payment Date</th>
	<th>Suppier Name</th>
	<th>Cash Amount</th>
	<th>Cheque Amount</th>
	<th>Payment Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order_payment WHERE $suppier_check $and $purchase_order_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="purchase_order_payment.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[purchase_order_payment_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td align="right">'.$row[cash_amount].'</td>
			
			<td align="right">'.$row[cheque_amount].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'purchase_order_payment.php?job=delete&purchase_order_payment_no='.$row[purchase_order_payment_no].'\',\'No\',\'purchase_order_payment.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function roll_back_purchase_payment($purchase_order_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_payment_has_purchase_order WHERE cancel_status=0 AND purchase_order_payment_no='$purchase_order_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		$purchase_order_info=get_purchase_order_info_by_purchase_no($row['purchase_order_no']);
		$purchase_order_no=$row['purchase_order_no'];

		$paid=$purchase_order_info['paid']-$row['amount'];
		$due=$purchase_order_info['due']+$row['amount'];
		$payment_status=$purchase_order_info['payment_status']-1;

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = 
		"UPDATE purchase_order SET
		paid='$paid',
		due='$due',
		payment_status='$payment_status'
		WHERE 
		purchase_order_no='$purchase_order_no'";
		mysqli_query($conn, $query);

	}

	include 'conf/closedb.php';
}

function cancel_purchase_payment($purchase_order_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order_payment SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE purchase_order_payment_no='$purchase_order_payment_no'";
	mysqli_query($conn, $query);
		
	include 'conf/closedb.php';
}

function cancel_all_payment_has_purchase($purchase_order_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_payment_has_purchase_order SET
	cancel_status='1'
	WHERE purchase_order_payment_no='$purchase_order_payment_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends