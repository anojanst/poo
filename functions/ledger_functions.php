<?php

//purchase_payment
function add_purchase_payment_ledger($purchase_order_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order_payment WHERE purchase_order_payment_no='$purchase_order_payment_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='PURCHASE PAYMENT';
		$purchase_order_payment_no=$ref_no=$row['purchase_order_payment_no'];
		$supplier_name=addslashes($row['supplier_name']);
		$cheque_amount=$row['cheque_amount'];
		$cheque_no=$row['cheque_no'];
		$cash_amount=$row['cash_amount'];

		if ($cash_amount=='0.00' AND $cheque_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount=='0.00' AND $cash_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount>0 AND $cash_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		else{}
	}

	include 'conf/closedb.php';

}

function delete_purchase_payment_ledger($purchase_order_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='PURCHASE PAYMENT' AND ref_no ='$purchase_order_payment_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}
//ends

//return_payment

function add_return_payment_ledger($return_sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM return_sales_payment WHERE return_sales_payment_no='$preturn_sales_payment_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='RETURN SALES PAYMENT';
		$return_sales_payment_no=$ref_no=$row['return_sales_payment_no'];
		$customer_name=addslashes($row['scustomer_name']);
		$cheque_amount=$row['cheque_amount'];
		$cheque_no=$row['cheque_no'];
		$cash_amount=$row['cash_amount'];

		if ($cash_amount=='0.00' AND $cheque_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount=='0.00' AND $cash_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount>0 AND $cash_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		else{}
	}

	include 'conf/closedb.php';

}

function delete_return_payment_ledger($return_sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='RETURN SALES PAYMENT' AND ref_no ='$return_sales_payment_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends


// sales payment

function add_discount_sales_payment_ledger($sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_payment WHERE sales_payment_no='$sales_payment_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='SALES PAYMENT';
		$sales_payment_no=$ref_no=$row['sales_payment_no'];
		$customer_name=addslashes($row['customer_name']);
		$amount=$row['cash_amount'];

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'DISCOUNT', '', '$amount', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('DISCOUNT', '$date', '$flag', '$ref_no', '$customer_name', '$amount', '', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function add_sales_quick_payment_ledger($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no='$sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$payment_type=$row['payment_type'];
		$flag='SALES PAYMENT';
		$sales_payment_no=$ref_no=$row['sales_no'];
		$customer_name="DEFAULT CUSTOMER";
		$total=$row['total'];
		$gift_card_amount=get_gift_card_amount_by_gift_card_no($row['gift_card_no']);
		if ($payment_type!="GIFT") {

			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', '$payment_type', '', '$total', '')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$payment_type', '$date', '$flag', '$ref_no', '$customer_name', '$total', '', '')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
		}

		else {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', '$payment_type', '', '$gift_card_amount', '')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$payment_type', '$date', '$flag', '$ref_no', '$customer_name', '$gift_card_amount', '', '')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));

			if ($total>$gift_card_amount) {
			    $cash_amount=$total-$gift_card_amount;

                mysqli_select_db($conn_for_changing_db, $dbname);
                $query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			    VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CASH', '', '$cash_amount', '')";
                mysqli_query($conn, $query3) or die (mysqli_error($conn));

                mysqli_select_db($conn_for_changing_db, $dbname);
                $query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			  VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer_name', '$cash_amount', '', '')";
                mysqli_query($conn, $query4) or die (mysqli_error($conn));
            }
		}

	}
	
	include 'conf/closedb.php';
}

function delete_sales_payment_ledger($sales_payment_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='SALES PAYMENT' AND ref_no ='$sales_payment_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}
// end

// other expenses
function convert_other_expenses($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses_has_expenses WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$info=get_other_expenses_info_by_other_expenses_no($row['other_expenses_no']);

		$date=$info['date'];
		$flag='OTHER EXPENSES';
		$ref_no=$row['other_expenses_no'];
		$supplier=addslashes($info['supplier_name']);
		$total=$row['amount'];
		$narration=addslashes($row[expenses_name]);
		$desc=' ('.$row[detail].' )';
		$desc=addslashes($desc);

		include 'conf/opendb.php';

		mysqli_select_db($conn_for_changing_db, $dbname) or die (mysqli_error($conn));
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$supplier', '$date', '$flag', '$ref_no', '$narration $desc', '', '$total', '')";
		mysqli_query($conn, $query1) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$supplier $desc', '$total', '', '')";
		mysqli_query($conn, $query4) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function add_other_expenses_ledger($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_expenses WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='OTHER EXPENSES PAYMENT';
		$other_expenses_no=$ref_no=$row['other_expenses_no'];
		$supplier_name=addslashes($row['supplier_name']);
		if($row['temp_name']){
			$supplier_name=addslashes($row['temp_name']);
		}
		$cheque_amount=$row['cheque_amount'];
		$cheque_no=$row['cheque_no'];
		$cash_amount=$row['cash_amount'];

		if ($cash_amount=='0.00' AND $cheque_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount=='0.00' AND $cash_amount>0) {
			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount>0 AND $cash_amount>0) {
			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$supplier_name', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$supplier_name', '', '$cash_amount', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		else{}
	}

	include 'conf/closedb.php';
}

function delete_other_expenses_ledger($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag LIKE 'OTHER EXPENSES%' AND ref_no ='$other_expenses_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends

// other incomes
function convert_other_incomes($other_incomes_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_incomes_has_incomes WHERE other_incomes_no='$other_incomes_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$info=get_other_incomes_info_by_other_incomes_no($row['other_incomes_no']);

		$date=$info['date'];
		$flag='OTHER INCOMES';
		$ref_no=$row['other_incomes_no'];
		$customer=addslashes($info['customer_name']);
		$total=$row['amount'];
		$narration=addslashes($row[incomes_name]);
		$desc=' ('.$row[detail].' )';
		$desc=addslashes($desc);

		include 'conf/opendb.php';

		mysqli_select_db($conn_for_changing_db, $dbname) or die (mysqli_error($conn));
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$customer', '$date', '$flag', '$ref_no', '$narration $desc', '$total', '', '')";
		mysqli_query($conn, $query1) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$customer $desc', '', '$total', '')";
		mysqli_query($conn, $query4) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function add_other_incomes_ledger($other_incomes_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM other_incomes WHERE other_incomes_no='$other_incomes_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='OTHER INCOMES PAYMENT';
		$other_incomes_no=$ref_no=$row['other_incomes_no'];
		$customer_name=addslashes($row['customer_name']);
		if($row['temp_name']){
			$customer_name=addslashes($row['temp_name']);
		}
		$cheque_amount=$row['cheque_amount'];
		$cheque_no=$row['cheque_no'];
		$cash_amount=$row['cash_amount'];

		if ($cash_amount=='0.00' AND $cheque_amount>0) {

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer_name', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount=='0.00' AND $cash_amount>0) {
			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CASH', '', '$cash_amount', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer_name', '$cash_amount', '', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		elseif ($cheque_amount>0 AND $cash_amount>0) {
			mysqli_select_db($conn_for_changing_db, $dbname);
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '', '$cheque_amount', '$cheque_no')";
			mysqli_query($conn, $query1) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer_name', '$cheque_amount', '', '$cheque_no')";
			mysqli_query($conn, $query2) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('$customer_name', '$date', '$flag', '$ref_no', 'CASH', '', '$cash_amount', '')";
			mysqli_query($conn, $query3) or die (mysqli_error($conn));

			mysqli_select_db($conn_for_changing_db, $dbname);
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer_name', '$cash_amount', '', '')";
			mysqli_query($conn, $query4) or die (mysqli_error($conn));
		}

		else{}
	}

	include 'conf/closedb.php';
}

function delete_other_incomes_ledger($other_incomes_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag LIKE 'OTHER INCOMES%' AND ref_no ='$other_incomes_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

//ends

//sales

function add_sales_ledger($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no = '$sales_no' AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='SALES';
		$sales_no=$ref_no=$row['sales_no'];
		$narration='DEFAULT CUSTOMER';
        $total=$row['total'];
		$account="SALES";
		//customer
		include 'conf/opendb.php';

		mysqli_select_db($conn_for_changing_db, $dbname) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '$total', '', '', '')";
		mysqli_query($conn, $query2) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function update_sales_ledger($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$sales_info=get_sales_info_by_sales_no($sales_no);
	$account='SALES';
	$date=$sales_info['date'];
	$flag='SALES';
	$total=$sales_info['total'];
	$narration=addslashes($sales_info['customer_name']);


	mysqli_select_db($conn_for_changing_db, $dbname);
	$query2 = "UPDATE ledger SET
	account='$narration',
	date='$date',	
	flag='$flag',
	narration='$account',
	debit='$total',			
	remarks='$remarks'
	WHERE flag='SALES' AND ref_no ='$sales_no' AND credit='0' AND cancel_status='0'";
	mysqli_query($conn, $query2);

	include 'conf/closedb.php';
}

function delete_sales_ledger($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE flag='SALES' AND ref_no ='$sales_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function add_sales_items_ledger($sales_no, $product_id, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$id=get_sales_item_id($sales_no);
	$date=date("Y-m-d");
	$flag='SALES ITEM';
	$account=$product_id;
	$narration='SALES';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
	VALUES ('$account', '$date', '$flag', '$id', '$narration', '', '$total', '', '$sales_no')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_sales_item_ledger($product_id ,$sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$item_info=get_product_info_from_sales_has_items($product_id, $sales_no);
	$account=$product_id;
	$date=$item_info['date'];
	$flag='SALES ITEM';
	$total=$item_info['total'];
	$id=$item_info['id'];
	$narration='SALES';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	account='$account',
	date='$date',	
	flag='$flag',
	narration='$narration',
	credit='$total', 	
	remarks='$sales_no'
	WHERE ref_no='$id' AND flag='SALES ITEM' AND remarks='$sales_no' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_sales_items_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='SALES ITEM' AND ref_no='$id'";
	mysqli_query($conn, $query);
	include 'conf/closedb.php';

}

function delete_all_sales_items_ledger($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='SALES ITEM' AND remarks='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';

}
//ends

//return

function add_return_ledger($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM returns WHERE return_no = '$return_no' AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['date'];
		$flag='RETURN';
		$return_no=$ref_no=$row['return_no'];
		$narration=addslashes($row['customer_name']);
        $total=$row['total'];
		$account="RETURN";
		//customer
		include 'conf/opendb.php';

		mysqli_select_db($conn_for_changing_db, $dbname) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '', '$total', '', '')";
		mysqli_query($conn, $query2) or die (mysqli_error($conn));
	}

	include 'conf/closedb.php';
}

function update_return_ledger($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$return_info=get_return_info_by_return_no($return_no);
	$account='RETURN';
	$date=$return_info['date'];
	$flag='RETURN';
	$total=$return_info['total'];
	$narration=addslashes($return_info['customer_name']);


	mysqli_select_db($conn_for_changing_db, $dbname);
	$query2 = "UPDATE ledger SET
	account='$narration',
	date='$date',	
	flag='$flag',
	narration='$account',
	credit='$total',			
	remarks='$remarks'
	WHERE flag='RETURN' AND ref_no ='$return_no' AND debit='0' AND cancel_status='0'";
	mysqli_query($conn, $query2);

	include 'conf/closedb.php';
}

function delete_return_ledger($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE flag='RETURN' AND ref_no ='$return_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function add_return_items_ledger($return_no, $product_id, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$id=get_return_item_id($return_no);
	$date=date("Y-m-d");
	$flag='RETURN ITEM';
	$account=$product_id;
	$narration='RETURN';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
	VALUES ('$account', '$date', '$flag', '$id', '$narration', '$total', '', '', '$return_no')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_return_item_ledger($product_id ,$return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$item_info=get_product_info_from_return_has_items($product_id, $return_no);
	$account=$product_id;
	$date=$item_info['date'];
	$flag='RETURN ITEM';
	$total=$item_info['total'];
	$id=$item_info['id'];
	$narration='RETURN';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	account='$account',
	date='$date',	
	flag='$flag',
	narration='$narration',
	debit='$total', 	
	remarks='$return_no'
	WHERE ref_no='$id' AND flag='RETURN ITEM' AND remarks='$return_no' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_return_items_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='RETURN ITEM' AND ref_no='$id'";
	mysqli_query($conn, $query);
	include 'conf/closedb.php';

}

function delete_all_return_items_ledger($return_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='RETURN ITEM' AND remarks='$return_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';

}
//ends

//purchase_order

function add_purchase_order_ledger($purchase_order_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE purchase_order_no = '$purchase_order_no' AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$date=$row['purchase_order_date'];
		$flag='PURCHASE ORDER';
		$ref_no=$row['purchase_order_no'];
		$narration=addslashes($row['supplier_name']);
		$total=$row['total'];
		$account='PURCHASE';
		//customer

		include 'conf/opendb.php';

		mysqli_select_db($conn_for_changing_db, $dbname) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '$total', '', '', '')";
		mysqli_query($conn, $query1) or die (mysqli_error($conn));

		mysqli_select_db($conn_for_changing_db, $dbname);
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '', '$total', '', '')";
		mysqli_query($conn, $query2) or die (mysqli_error($conn));

	}

	include 'conf/closedb.php';
}

function update_purchase_order_ledger($purchase_order_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$purchase_order_info=get_purchase_order_info_by_purchase_no($purchase_order_no);
	$account='PURCHASE';
	$date=$purchase_order_info['purchase_order_date'];
	$flag='PURCHASE ORDER';
	$total=$purchase_order_info['total'];
	$narration=addslashes($purchase_order_info['supplier_name']);

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query1 = "UPDATE ledger SET
	account='$account',
	date='$date',	
	flag='$flag',
	narration='$narration',
	credit='$total', 
	remarks='$remarks'
	WHERE ref_no='$purchase_order_no' AND flag='PURCHASE ORDER' AND debit='0' AND cancel_status='0'";
	mysqli_query($conn, $query1);

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query2 = "UPDATE ledger SET
	account='$narration',
	date='$date',	
	flag='$flag',
	narration='$account',
	debit='$total',	
	remarks='$remarks'
	WHERE flag='PURCHASE ORDER' AND ref_no ='$purchase_order_no' AND credit= '0' AND cancel_status='0'";
	mysqli_query($conn, $query2);

	include 'conf/closedb.php';
}

function delete_purchase_order_ledger($purchase_order_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE ledger SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE flag='PURCHASE ORDER' AND ref_no ='$purchase_order_no'  AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';

}

function delete_purchase_order_item_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='PURCHASE ITEM' AND ref_no='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function delete_all_purchase_order_item_ledger($purchase_order_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "DELETE FROM ledger WHERE flag='PURCHASE ITEM' AND remarks='$purchase_order_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';

}
function add_purchase_order_item_ledger($purchase_order_no, $product_id, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$id=get_purchase_order_item_id($purchase_order_no);
	$date=date("Y-m-d");
	$flag='PURCHASE ITEM';
	$account=$product_id;
	$narration='PURCHASE';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, remarks)
	VALUES ('$account', '$date', '$flag', '$id', '$narration', '$total', '', '', '$purchase_order_no')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}