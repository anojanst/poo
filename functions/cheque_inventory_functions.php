<?php 

//puchase_payment
function save_purchase_payment_in_cheque_inventory($purchase_order_payment_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $supplier_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status='UNPRESENTED';
	$type='PURCHASE PAYMENT';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO cheque_inventory (payment_ref, payment_date, che_amount, che_no, che_bank, che_branch, che_date, status, payment_type, customer)
	VALUES ('$purchase_order_payment_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$supplier_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_purchase_payment_from_cheque_inventory($purchase_order_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order_payment WHERE purchase_order_payment_no='$purchase_order_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE payment_ref='$purchase_order_payment_no' AND che_no='$row[cheque_no]' AND payment_type='PURCHASE PAYMENT'";
	mysqli_query($conn, $query);
	}
		
	include 'conf/closedb.php';
}
//ends

//return_payment

function save_return_payment_in_cheque_inventory($return_sales_payment_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status='UNPRESENTED';
	$type='RETURN SALES PAYMENT';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO cheque_inventory (payment_ref, payment_date, che_amount, che_no, che_bank, che_branch, che_date, status, payment_type, customer)
	VALUES ('$return_sales_payment_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$customer_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_return_payment_from_cheque_inventory($return_sales_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_sales_payment WHERE return_sales_payment_no='$return_sales_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE payment_ref='$return_sales_payment_no' AND che_no='$row[cheque_no]' AND payment_type='RETURN SALES PAYMENT'";
	mysqli_query($conn, $query);
	}
		
	include 'conf/closedb.php';
}
//ends

//sales_payment

function save_sales_payment_in_cheque_inventory($sales_payment_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status='RECEIVED';
	$type='SALES PAYMENT';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO cheque_inventory (payment_ref, payment_date, che_amount, che_no, che_bank, che_branch, che_date, status, payment_type, customer)
	VALUES ('$sales_payment_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$customer_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_sales_payment_from_cheque_inventory($sales_payment_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_payment WHERE sales_payment_no='$sales_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE payment_ref='$sales_payment_no' AND che_no='$row[cheque_no]' AND payment_type='SALES PAYMENT'";
	mysqli_query($conn, $query);
	}
		
	include 'conf/closedb.php';
}
//ends

//other_expenses

function save_other_expenses_in_cheque_inventory($other_expenses_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $supplier_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status='UNPRESENTED';
	$type='OTHER EXPENSES PAYMENT';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO cheque_inventory (payment_ref, payment_date, che_amount, che_no, che_bank, che_branch, che_date, status, payment_type, customer)
	VALUES ('$other_expenses_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$supplier_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_other_expenses_from_cheque_inventory($other_expenses_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE other_expenses_no='$other_expenses_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE payment_ref='$other_expenses_no' AND che_no='$row[cheque_no]' AND payment_type='OTHER EXPENSES PAYMENT'";
	mysqli_query($conn, $query);
	}
		
	include 'conf/closedb.php';
}
//ends

//other_incomes

function save_other_incomes_in_cheque_inventory($other_incomes_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status='UNPRESENTED';
	$type='OTHER INCOMES PAYMENT';

	$date = date("Y-m-d", strtotime($date));
	$cheque_date = date("Y-m-d", strtotime($cheque_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO cheque_inventory (payment_ref, payment_date, che_amount, che_no, che_bank, che_branch, che_date, status, payment_type, customer)
	VALUES ('$other_incomes_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$customer_name')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function delete_other_incomes_from_cheque_inventory($other_incomes_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_incomes WHERE other_incomes_no='$other_incomes_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE payment_ref='$other_incomes_no' AND che_no='$row[cheque_no]' AND payment_type='OTHER INCOMES PAYMENT'";
	mysqli_query($conn, $query);
	}
		
	include 'conf/closedb.php';
}
//ends