<?php
//sales_payment_function_starts
function list_sales_of_customer($customer_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Sales Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Receive</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE customer_name='$customer_name' AND due > 0 AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="sales_payment.php?job=add_pay&sales_no='.$row[sales_no].'" method="post">';
				
				echo"
				<td align='center'>$row[sales_no]</td>
						
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

function list_sales_of_sales_no($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; margin-top: 20px;">
	<thead valign="top">
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Sales Total</th>
	<th>Paid</th>
	<th>Due</th>
	<th>Pay</th>
	<th>Add</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no='$sales_no' AND due > 0 AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<form name="add_pay" action="sales_payment.php?job=add_pay&sales_no='.$row[sales_no].'" method="post">';
				
				echo"
				<td align='center'>$row[sales_no]</td>
						
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

function update_sales_due($sales_no, $pay) {
	$sales_info=get_sales_info_by_sales_no($sales_no);
	$due=$sales_info['due']-$pay;
	$update_paid=$sales_info['paid']+$pay;
	$update_payment_status=$sales_info['payment_status']+1;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales SET
	paid='$update_paid',
	payment_status='$update_payment_status',
	due='$due'
	WHERE sales_no='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_sales_payment_sales_in_temp_table($sales_no, $random_no, $pay, $user_name){

	$sales_info=get_sales_info_by_sales_no($sales_no);
	$sales_date=$sales_info['date'];
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO temp_sales_payment_has_sales (amount, sales_no, random_no, sales_date, user_name)
	VALUES ('$pay', '$sales_no', '$random_no', '$sales_date', '$user_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_added_sales($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
		  <thead>
    		<tr>
    		<th>Sales No</th>
    		<th>Sales Date</th>
     		<th>Paid</th>
		    <th>Remove</th>
		   </tr>
  		</thead>
  		<tbody>';

	$result=mysqli_query($conn, "SELECT * FROM temp_sales_payment_has_sales WHERE random_no='$random_no' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td align="center">'.$row[sales_no].'</td>
		<td align="center">'.$row[sales_date].'</td>
		<td align="right">'.$row[amount].'</td>
		<td align="center"><a href="sales_payment.php?job=delete_pay&id='.$row[id].'&sales_no='.$row[sales_no].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr>
		';
	}

	echo '<tr>
	<td></td>
	<td></td>	
	<th align="right">'.get_sales_payment_total($random_no).'</th>
	<td></td>
	
	</tr>';

	echo '</tbody></table>';


	include 'conf/closedb.php';
}

function get_sales_payment_total($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT SUM(amount) FROM temp_sales_payment_has_sales WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row['SUM(amount)'];
	}

	return $total;

	include 'conf/closedb.php';
}

function check_added_sales($sales_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
		
	$result=mysqli_query($conn, "SELECT count(id) FROM temp_sales_payment_has_sales WHERE sales_no='$sales_no' AND random_no='$random_no'");
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

function update_sales_payment_sales_in_temp_table($sales_no, $random_no, $pay){
	$sales_payment_info=get_sales_payment_temp_info_by_sales_no($sales_no, $random_no);
	$amount=$sales_payment_info['amount']+$pay;

	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE temp_sales_payment_has_sales SET
	amount='$amount'
	WHERE sales_no='$sales_no' AND random_no='$random_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_sales_payment_temp_info_by_sales_no($sales_no, $random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_sales_payment_has_sales WHERE sales_no='$sales_no' AND random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_sales_payment_info_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_sales_payment_has_sales WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'conf/closedb.php';
}

function update_sales_after_delete_temp($sales_no, $paid, $due, $payment_status){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales SET
	paid='$paid',
	due='$due',
	payment_status='$payment_status'
	WHERE sales_no='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_sales_payment_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_sales_payment_has_sales WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function save_sales_payment($sales_payment_no, $customer_name, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $cash_amount, $total, $prepared_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO sales_payment (sales_payment_no, customer_name, date, remarks, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, cash_amount, total, prepared_by)
	VALUES ('$sales_payment_no', '$customer_name', '$date', '$remarks', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$cash_amount', '$total', '$prepared_by')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';

}

function get_sales_payment_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT MAX(sales_payment_no) FROM sales_payment ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(sales_payment_no)']+1;
	}

	include 'conf/closedb.php';
}

function transfer_sales($random_no, $sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM temp_sales_payment_has_sales WHERE random_no='$random_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$sales_no=$row['sales_no'];
		$amount=$row['amount'];

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = "INSERT INTO sales_payment_has_sales (sales_payment_no, sales_no, amount)
		VALUES ('$sales_payment_no', '$sales_no', '$amount')";
		mysqli_query($conn, $query) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function cash_sales($sales_no, $sales_payment_no, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';


	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO sales_payment_has_sales (sales_payment_no, sales_no, amount)
	VALUES ('$sales_payment_no', '$sales_no', '$amount')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));


	include 'conf/closedb.php';
}

function delete_temp_data_sales_payment($random_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM temp_sales_payment_has_sales WHERE random_no='$random_no'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_sales_payment_search($sales_payment_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($sales_payment_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($sales_payment_no_search){
		$sales_payment_no_check="sales_payment_no LIKE '%$sales_payment_no_search'";
	}
	else{
		$sales_payment_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name LIKE '$customer_search%'";
	}
	else{
		$customer_check="";
	}
	
	if($sales_payment_no_search || $customer_search){
	
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

	$result=mysqli_query($conn, "SELECT * FROM sales_payment WHERE $customer_check $and $sales_payment_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="sales_payment.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[sales_payment_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[cash_amount].'</td>
			
			<td align="right">'.$row[cheque_amount].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'sales_payment.php?job=delete&sales_payment_no='.$row[sales_payment_no].'\',\'No\',\'sales_payment.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function roll_back_sales_payment($sales_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_payment_has_sales WHERE cancel_status=0 AND sales_payment_no='$sales_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		$sales_info=get_sales_info_by_sales_no($row['sales_no']);
		$sales_no=$row['sales_no'];

		$paid=$sales_info['paid']-$row['amount'];
		$due=$sales_info['due']+$row['amount'];
		$payment_status=$sales_info['payment_status']-1;

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query = 
		"UPDATE sales SET
		paid='$paid',
		due='$due',
		payment_status='$payment_status'
		WHERE 
		sales_no='$sales_no'";
		mysqli_query($conn, $query);

	}

	include 'conf/closedb.php';
}

function cancel_sales_payment($sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_payment SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE sales_payment_no='$sales_payment_no'";
	mysqli_query($conn, $query);
		
	include 'conf/closedb.php';
}

function cancel_all_payment_has_sales($sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_payment_has_sales SET
	cancel_status='1'
	WHERE sales_payment_no='$sales_payment_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends