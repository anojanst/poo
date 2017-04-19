<?php    
function list_expenses_by_other_expenses_no($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses_has_expenses WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo"<table><tr>
		<td>$row[expenses_name]</td>
		<td>$row[detail]</td>
		<td align='right'>$row[amount]</td>".'
		<td ><a href="other_expenses.php?job=delete_expense&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>
		</tr></table>';
	}

	include 'conf/closedb.php';
}

function check_non_saved_other_expenses($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM other_expenses_has_expenses WHERE user_name='$user_name' AND saved='0'");
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

function non_save_other_expenses_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(other_expenses_no) FROM other_expenses_has_expenses WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(other_expenses_no)'];
	}

	include 'conf/closedb.php';
}

function get_other_expenses_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(other_expenses_no) FROM other_expenses_has_expenses");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(other_expenses_no)']+1;
	}

	include 'conf/closedb.php';
}

function save_expense($expenses_name, $detail, $amount, $other_expenses_no, $user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	$total = $quantity*$buying_price;
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO other_expenses_has_expenses (id, expenses_name, detail, amount, other_expenses_no, user_name)
	VALUES ('', '$expenses_name', '$detail', '$amount', '$other_expenses_no', '$user_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_expense($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE other_expenses_has_expenses SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_expenses_saved($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE other_expenses_has_expenses SET
	saved='1'
	WHERE other_expenses_no='$other_expenses_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_expenses_total($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(amount) as total FROM other_expenses_has_expenses WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}


function save_other_expenses($other_expenses_no, $date, $supplier_name, $prepared_by, $remarks, $total, $cash_amount, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $temp_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($temp_name){
		$unauthorized='1';
	}

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO other_expenses (id, other_expenses_no, supplier_name, prepared_by, remarks, date, total, cash_amount, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, temp_name, unauthorized)
	VALUES ('', '$other_expenses_no', '$supplier_name', '$prepared_by', '$remarks', '$date', '$total', '$cash_amount', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$temp_name', '$unauthorized')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function list_other_expenses_search($other_expenses_no_search, $supplier_search){
	include 'conf/config.php';
	include 'conf/opendb.php';

	if($other_expenses_no_search && $supplier_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($other_expenses_no_search){
		$other_expenses_no_check="other_expenses_no LIKE '%$other_expenses_no_search'";
	}
	else{
		$other_expenses_no_check="";
	}

	if($supplier_search){
		$suppier_check="supplier_name='$supplier_search'";
	}
	else{
		$suppier_check="";
	}
	
	if($other_expenses_no_search || $supplier_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Print</th>
	<th>Other Expenses  No</th>
	<th>Other Expenses  Date</th>
	<th>Suppier Name</th>
	<th>Cash Amount</th>
	<th>Cheque Amount</th>
	<th>Payment Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE $suppier_check $and $other_expenses_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="other_expenses.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td align="center">'.$row[other_expenses_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td align="right">'.$row[cash_amount].'</td>
			
			<td align="right">'.$row[cheque_amount].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'other_expenses.php?job=delete&id='.$row[id].'\',\'No\',\'other_expenses.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function list_other_expensess(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 10px;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Other Expenses  No</th>
	<th>Other Expenses  Date</th>
	<th>Suppier Name</th>
	<th>Other Expenses Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="other_expenses.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="other_expenses.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[other_expenses_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[supplier_name].'</td>
			
			<td>'.$row[total].'</td>
		
			<td>'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'other_expenses.php?job=delete&id='.$row[id].'\',\'No\',\'other_expenses.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function get_other_expenses_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_other_expenses_info_by_other_expenses_no($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE other_expenses_no='$other_expenses_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_other_expenses($id, $other_expenses_no, $date, $supplier_name, $prepared_by, $remarks, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE other_expenses SET
	other_expenses_no='$other_expenses_no',
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

function  calncel_expenses_for_other_expenses_no($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE other_expenses_has_expenses SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE other_expenses_no='$other_expenses_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_other_expenses($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE other_expenses SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}