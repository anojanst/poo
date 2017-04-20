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

function get_total_sales($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(total) as total FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}

function add_sales_item($selected_item, $product_name, $stock, $selling_price, $discount, $sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d");
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO sales_has_items (id, product_id, product_name, stock, selling_price, date, discount, sales_no, quantity, user_name, total)
	VALUES ('', '$selected_item', '$product_name', '$stock', '$selling_price', '$date', '$discount', '$sales_no', '1', '$_SESSION[user_name]', '$selling_price')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function check_non_saved_sales_order($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM sales_has_items WHERE user_name='$user_name' AND saved='0'");
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

function non_save_sales_info($user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MIN(sales_no) FROM sales_has_items WHERE user_name='$user_name' AND saved='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MIN(sales_no)'];
	}

	include 'conf/closedb.php';
}

function get_sales_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(sales_no) FROM sales_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(sales_no)']+1;
	}

	include 'conf/closedb.php';
}

function check_added_items($product_id, $sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT count(id) FROM sales_has_items WHERE product_id='$product_id' AND sales_no='$sales_no' AND cancel_status='0'");
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

function update_sales_item($product_id, $quantity, $item_total, $selling_price, $discount, $sales_no, $stock){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_has_items SET
	quantity='$quantity',
	selling_price='$selling_price',
	discount='$discount',
	total='$item_total',
	saved='0',
	stock='$stock'
	WHERE product_id='$product_id' AND cancel_status='0' AND sales_no='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_sales_item_for_repeative_adding($product_id, $quantity, $item_total){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_has_items SET
	quantity='$quantity',
	total='$item_total',
	saved='0'
	WHERE product_id='$product_id' AND cancel_status='0'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_quantity($product_id, $sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$result=mysqli_query($conn, "SELECT sum(quantity) as total FROM sales_has_items WHERE product_id='$product_id' AND sales_no='$sales_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[total];
	}

	return $total;

	include 'conf/closedb.php';
}
function list_item_by_sales($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<tr>
		<form name="update_item" action="sales.php?job=update_item&product_id='.$row[product_id].'" method="post"><td align="center" ><a href="sales.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>'."
		<td>".$row[product_name]."</td>
		<td align='right'><input type='text' name='selling_price' value=".$row[selling_price]." size='10' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'><input type='text' name='quantity' value=".$row[quantity]." size='6' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'><input type='text' name='discount' value=".$row[discount]." size='9' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
		<td align='right'>".$row[total]."</td>
		<td align='right'><input type='submit' name='update' value='Update' size='9' class='more' style='width: 70px; border: 0; padding: 1.5px;'/></td>
		</form></tr>";
	}
	include 'conf/closedb.php';

}

function print_sales_item($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	
	$result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[quantity]*$row[selling_price];
        
		echo'<div class="row">
                <div class="col-lg-12">
                    <p>'.$row[product_name].'</p>
                </div>
             </div>
             <div class="row" >
                <div class="col-lg-9" style="margin-top:-30px;">
                    <p>('.$row[quantity].' * '.$row[selling_price].')</p>
                </div>
                 <div class="col-lg-3" style="margin-top:-50px;">
                    <p style="text-align: right;">'.number_format($total,2).'</p>
                </div>
             </div>';
        $sub_total += $total;
	}
    echo '
    <strong>-----------------------------------------------</strong>';
    echo'<table style="width: 100%;" class="table-responsive dt-responsive">
       <tr>
            <td><strong>SUB TOTAL</strong></td>
            <td align="right">'.number_format($sub_total,2).'</td>
        </tr>';
       
    $result1=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no='$sales_no' AND cancel_status='0'");
	while($row1= mysqli_fetch_array($result1, MYSQLI_ASSOC))
	{
        $discount=$row1[discount];
      echo' <tr>
            <td></td>
            <td align="right">-'.$row1[discount].'</td>
        </tr></table>
        <strong>-----------------------------------------------</strong>
        <table style="width: 100%;" class="table-responsive dt-responsive">
        <tr>
            <td><strong>SUB TOTAL</strong></td>
			
            <td align="right">'.number_format($row1[total_after_discount],2).'</td>
        </tr>
        <tr>
            <td><strong>CASH</strong></td>
			
            <td align="right">'.number_format($row1[customer_amount],2).'</td>
        </tr></table>
       <strong>-----------------------------------------------</strong>
       <table style="width: 100%;" class="table-responsive dt-responsive">       
        <tr>
            <td><strong>BALANCE</strong></td>
			
            <td align="right">'.number_format($row1[balance],2).'</td>
        </tr>';
    }
    echo'</table>';
	include 'conf/closedb.php';


}

function net_total($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$net_total=0;

	$result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0' ORDER BY id ASC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$total=$row[quantity]*$row[selling_price];
		$net_total=$net_total+$total;

	}

	return $net_total;

	include 'conf/closedb.php';
}

function get_product_info_from_sales_has_items($product_id, $sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE product_id='$product_id' AND sales_no='$sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_product_info_from_sales_has_items_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE id='$id'");
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
	$query = "UPDATE sales_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='0'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_saved_sales($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_has_items SET
	saved='1'
	WHERE sales_no='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


function save_sales($sales_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount,$total_after_discount, $total, $balance){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO sales (id, sales_no, customer_name, prepared_by, remarks, date, total, due, customer_amount,total_after_discount, discount, balance)
	VALUES ('', '$sales_no', '$customer_name', '$prepared_by', '$remarks', '$date', '$total', '$total', '$customer_amount','$total_after_discount', '$discount', '$balance')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}


function list_sales_search($sales_no_search, $customer_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($sales_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($sales_no_search){
		$sales_no_check="sales_no LIKE '%$sales_no_search'";
	}
	else{
		$sales_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($sales_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>Edit</th>
	<th>Print</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE $customer_check $and $sales_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="sales.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td><a href="sales.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[sales_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'sales.php?job=delete&id='.$row[id].'\',\'No\',\'sales.php?job=search\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	}
	
	include 'conf/closedb.php';
}


function list_sales_search_report($customer_search, $sales_no_search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if($sales_no_search && $customer_search){
		$and="AND ";
	}
	else{
		$and="";
	}
	
	if($sales_no_search){
		$sales_no_check="sales_no='$sales_no_search'";
	}
	else{
		$sales_no_check="";
	}

	if($customer_search){
		$customer_check="customer_name='$customer_search'";
	}
	else{
		$customer_check="";
	}
	
	if($sales_no_search || $customer_search){
	
	echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>No</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
$i=1;
	$result=mysqli_query($conn, "SELECT * FROM sales WHERE $customer_check $and $sales_no_check AND cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>'.$i.'</td>
			<td>'.$row[sales_no].'</td>
					
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
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table>';
	}
	
	include 'conf/closedb.php';
}

function list_sales(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<table class="inventory_table" style="width: 900px; border-bottom: 2px solid silver; margin-bottom: 30px; margin-top: 0x;">
	<thead valign="top">
	<th>No</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';

	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM sales WHERE cancel_status='0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td>'.$i.'</td>
			<td>'.$row[sales_no].'</td>
					
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
	
	echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table>';
	
	
	
	include 'conf/closedb.php';
}

function get_sales_info($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function get_sales_info_by_sales_no($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no='$sales_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	include 'conf/closedb.php';
}

function update_sales($id, $sales_no, $date, $customer_name, $prepared_by, $remarks,$discount, $total, $updated_by){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date("Y-m-d", strtotime($date));

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales SET
	sales_no='$sales_no',
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

function  calncel_items_for_sales_no($sales_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales_has_items SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]',
	saved='1'
	WHERE sales_no='$sales_no'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_sales($id){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE sales SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_sales_item_id($sales_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(id) FROM sales_has_items WHERE  cancel_status='0' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(id)'];
	}

	include 'conf/closedb.php';
}