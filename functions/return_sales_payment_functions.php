<?php
//return_sales_payment_function_starts
function list_return_sales_of_customer($customer_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Return Sales No</th>
	<th>Return Sales Date</th>
	<th>Return Sales Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Pay</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE customer_name='$customer_name' AND due > 0 AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="return_sales_payment.php?job=add_pay&return_no='.$row[return_no].'" method="post">';
				
				echo"
				<td align='center'>$row[return_no]</td>
						
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

function list_return_sales_of_return_no($return_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Return Sales No</th>
	<th>Return Sales Date</th>
	<th>Return Sales Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Pay</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE return_no='$return_no' AND due > 0 AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="return_sales_payment.php?job=add_pay&return_no='.$row[return_no].'" method="post">';
				
				echo"
				<td align='center'>$row[return_no]</td>
						
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

function update_return_sales_due($return_no, $pay) {
	$return_info=get_return_info_by_return_no($return_no);
	$due=$return_info['due']-$pay;
	$update_paid=$return_info['paid']+$pay;
	$update_payment_status=$return_info['payment_status']+1;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE returns SET
	paid='$update_paid',
	payment_status='$update_payment_status',
	due='$due'
	WHERE return_no='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_return_payment_return_sales_in_temp_table($return_no, $random_no, $pay, $user_name){

	$return_info=get_return_info_by_return_no($return_no);
	$return_date=$return_info['date'];
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_return_payment_has_return_sales (amount, return_no, random_no, return_date, user_name)
	VALUES ('$pay', '$return_no', '$random_no', '$return_date', '$user_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_added_return_sales($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
		  <thead>
    		<tr>
    		<th>Return Sales No</th>
    		<th>Return Sales Date</th>
     		<th>Paid</th>
		    <th>Remove</th>
		   </tr>
  		</thead>
  		<tbody>';

	$result=mysqli_query($conn, "SELECT * FROM temp_return_payment_has_return_sales WHERE random_no='$random_no' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td align="center">'.$row[return_no].'</td>
		<td align="center">'.$row[return_date].'</td>
		<td align="right">'.$row[amount].'</td>
		<td align="center"><a href="return_sales_payment.php?job=delete_pay&id='.$row[id].'&return_no='.$row[return_no].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr>
		';
	}

	echo '<tr>
	<td></td>
	<td></td>	
	<th align="right">'.get_return_payment_total($random_no).'</th>
	<td></td>
	
	</tr>';

	echo '</tbody></table>';


	include 'conf/closedb.php';
}

function get_return_payment_total($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT SUM(amount) FROM temp_return_payment_has_return_sales WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row['SUM(amount)'];
	}

	return $total;

	include 'conf/closedb.php';
}

function check_added_return_sales($return_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
		
	$result=mysqli_query($conn, "SELECT count(id) FROM temp_return_payment_has_return_sales WHERE return_no='$return_no' AND random_no='$random_no'");
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

function update_return_payment_return_sales_in_temp_table($return_no, $random_no, $pay){
	$return_payment_info=get_return_payment_temp_info_by_return_no($return_no, $random_no);
	$amount=$return_payment_info['amount']+$pay;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE temp_return_payment_has_return_sales SET
	amount='$amount'
	WHERE return_no='$return_no' AND random_no='$random_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_return_payment_temp_info_by_return_no($return_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_return_payment_has_return_sales WHERE return_no='$return_no' AND random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_return_payment_info_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_return_payment_has_return_sales WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'conf/closedb.php';
}

function update_return_sales_after_delete_temp($return_no, $paid, $due, $payment_status){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE returns SET
	paid='$paid',
	due='$due',
	payment_status='$payment_status'
	WHERE return_no='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_return_payment_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_return_payment_has_return_sales WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_return_payment($return_sales_payment_no, $customer_name, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $cash_amount, $total, $prepared_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO return_sales_payment (return_sales_payment_no, customer_name, date, remarks, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, cash_amount, total, prepared_by)
	VALUES ('$return_sales_payment_no', '$customer_name', '$date', '$remarks', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$cash_amount', '$total', '$prepared_by')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';

}

function get_return_sales_payment_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT MAX(return_sales_payment_no) FROM return_sales_payment ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(return_sales_payment_no)']+1;
	}

	include 'conf/closedb.php';
}

function transfer_return_sales($random_no, $return_sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_return_payment_has_return_sales WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$return_no=$row['return_no'];
		$amount=$row['amount'];

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = "INSERT INTO return_payment_has_return_sales (return_sales_payment_no, return_no, amount)
		VALUES ('$return_sales_payment_no', '$return_no', '$amount')";
		mysqli_query($conn, $query) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function delete_temp_data_return_payment($random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_return_payment_has_return_sales WHERE random_no='$random_no'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_return_sales_payment_search($return_sales_payment_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($return_sales_payment_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($return_sales_payment_no_search){
		$return_sales_payment_no_check="return_sales_payment_no LIKE '%$return_sales_payment_no_search'";
	}
	else{
		$return_sales_payment_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($return_sales_payment_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Print</th>
	<th>Payment No</th>
	<th>Payment Date</th>
	<th>Customer Name</th>
	<th>Cash Amount</th>
	<th>Cheque Amount</th>
	<th>Payment Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM return_sales_payment WHERE $customer_check $and $return_sales_payment_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="return_sales_payment.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[return_sales_payment_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[cash_amount].'</td>
			
			<td align="right">'.$row[cheque_amount].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'return_sales_payment.php?job=delete&return_sales_payment_no='.$row[return_sales_payment_no].'\',\'No\',\'return_payment.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function roll_back_return_payment($return_sales_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_payment_has_return_sales WHERE cancel_status=0 AND return_sales_payment_no='$return_sales_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		$return_info=get_return_info_by_return_no($row['return_no']);
		$return_no=$row['return_no'];

		$paid=$return_info['paid']-$row['amount'];
		$due=$return_info['due']+$row['amount'];
		$payment_status=$return_info['payment_status']-1;

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = 
		"UPDATE returns SET
		paid='$paid',
		due='$due',
		payment_status='$payment_status'
		WHERE 
		return_no='$return_no'";
		mysqli_query($conn, $query);

	}

	include 'conf/closedb.php';
}

function cancel_return_payment($return_sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_sales_payment SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE return_sales_payment_no='$return_sales_payment_no'";
	mysqli_query($conn, $query);
		
	include 'conf/closedb.php';
}

function cancel_all_payment_has_return($return_sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE return_payment_has_return_sales SET
	cancel_status='1'
	WHERE return_sales_payment_no='$return_sales_payment_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends

