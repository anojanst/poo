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

function get_branch_stock($product_id){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM inventory_has_multiple_stock WHERE product_id='$product_id' AND branch='$_SESSION[branch]'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $total=$row[stock];
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

function add_sales_item($product_id, $product_name, $stock, $selling_price, $discount, $sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date("Y-m-d");
    mysqli_select_db($conn_for_changing_db, $dbname);
    $query = "INSERT INTO sales_has_items (id, product_id, product_name, stock, selling_price, date, discount, sales_no, quantity, user_name, total)
	VALUES ('', '$product_id', '$product_name', '$stock', '$selling_price', '$date', '$discount', '$sales_no', '1', '$_SESSION[user_name]', '$selling_price')";
    mysqli_query($conn, $query) or die (mysqli_error($conn));

    include 'conf/closedb.php';
}

function add_quick_sales_item($product_id, $product_name, $stock, $selling_price, $discount,$total, $sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date("Y-m-d");
    mysqli_select_db($conn_for_changing_db, $dbname);
    $query = "INSERT INTO sales_has_items (id, product_id, product_name, stock, selling_price, date, discount, sales_no, quantity, user_name, total)
	VALUES ('', '$product_id', '$product_name', '$stock', '$selling_price', '$date', '$discount', '$sales_no', '$stock', '$_SESSION[user_name]', '$total')";
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

function check_multiple_stock_has_inventory($product_id, $branch){
    include 'conf/config.php';
    include 'conf/opendb.php';


    if(mysqli_num_rows(mysqli_query($conn,"SELECT count(id) FROM inventory_has_multiple_stock WHERE product_id='$product_id' AND branch='$branch' AND  cancel_status='0'"))){
        return 1;
    }
    else{
        return 0;
    }

    include 'conf/closedb.php';
}


function update_sales_item($id, $product_id, $quantity, $item_total, $selling_price, $discount, $sales_no, $stock){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $price= $quantity*$selling_price;

    mysqli_select_db($conn_for_changing_db, $dbname);
    $query = "UPDATE sales_has_items SET
	quantity='$quantity',
	selling_price='$selling_price',
	discount='$discount',
	total='$item_total',
	price='$price',
	saved='0',
	stock='$stock'
	WHERE id='$id' AND product_id='$product_id' AND cancel_status='0' AND sales_no='$sales_no'";
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
		<form name="update_item" action="sales.php?job=update_item&id='.$row[id].'&product_id='.$row[product_id].'" method="post">
			<td align="center" ><a href="sales.php?job=delete_item&id='.$row[id].'" ><i class="fa fa-times fa-2x"></i></a></td>'."
			<td>".$row[product_name]."</td>
			<td align='right'>".$row[selling_price]."<input type='hidden' name='selling_price' value=".$row[selling_price]."/></td>
			<td align='right'><input type='text' name='quantity' value=".$row[quantity]." size='4' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
			<td align='right'><input type='text' name='discount' value=".$row[discount]." size='6' style='color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;'/></td>
			<td align='right'>".$row[total]."</td>
			<td align='right'><input type='submit' name='update' value='Update' size='9' class='btn btn-sm btn-primary' style='width: 70px; border: 0; padding: 1.5px;'/></td>
		</form></tr>";
    }
    echo'<tr>
				<form name="update_item" action="sales.php?job=add_item" method="post">
					<td></td>
					<td><input type="text" name="product_name" size="14" style="color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: left;"/></td>
					<td align="right"><input type="text" name="selling_price" size="10" style="color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;"/></td>
					<td align="right"><input type="text" name="quantity"  size="4" style="color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;"/></td>
					<td align="right"><input type="text" name="discount"  size="6" style="color: #000; font: 14px/30px Arial, Helvetica, sans-serif; height: 25px; line-height: 25px; border: 1px solid #d5d5d5; padding: 0 4px; text-align: right;"/></td>
					<td align="right">'.$row[total].'</td>
					<td align="right"><input type="submit" name="update" value="Add" size="9" class="btn btn-sm btn-primary" style="width: 70px; border: 0; padding: 1.5px;"/></td>
				</form>
			</tr>';
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


function save_sales($sales_no, $date, $customer_name, $prepared_by, $remarks,$discount,$customer_amount,$total_after_discount, $total, $balance, $payment_type, $gift_card_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date("Y-m-d", strtotime($date));

    mysqli_select_db($conn_for_changing_db, $dbname);
    $query = "INSERT INTO sales (id, sales_no, customer_name, prepared_by, remarks, date, total, due, customer_amount,total_after_discount, discount, balance, payment_type, gift_card_no)
	VALUES ('', '$sales_no', '$customer_name', '$prepared_by', '$remarks', '$date', '$total', '$total', '$customer_amount','$total_after_discount', '$discount', '$balance','$payment_type', '$gift_card_no')";
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

        $result=mysqli_query($conn, "SELECT * FROM sales WHERE $customer_check $and $sales_no_check AND cancel_status='0' ORDER BY id DESC LIMIT 500");
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            echo '
		<tr>
			<td><a href="sales.php?job=edit&id='.$row[id].'"  ><<i class="fa fa-pencil-square-o fa-2x"></i></a></td>

			<td><a href="sales.php?job=print_preview&id='.$row[id].'"  ><img src="images/print.png" alt="Print" width="24" height="24" /></a></td>
			
			<td>'.$row[sales_no].'</td>
					
			<td>'.$row[date].'</td>
					
			<td>'.$row[customer_name].'</td>
			
			<td align="right">'.$row[total].'</td>
		
			<td align="center">'.$row[remarks].'</td>
			
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			<td><a href="sales.php?job=delete&id='.$row[id].'" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'sales.php?job=delete&id='.$row[id].'\',\'No\',\'sales.php?job=search\')"><i class="fa fa-times fa-2x"></i></a></td>
		</tr>';
        }
        echo '</tbody></table>';
    }

    include 'conf/closedb.php';
}


function list_sales_search_report($customer_search, $sales_no_search, $to_date, $from_date, $payment_type){
    include 'conf/config.php';
    include 'conf/opendb.php';

    if($sales_no_search){
        $sales_no_check="AND sales_no='$sales_no_search'";
    }


    if($customer_search){
        $customer_check="AND customer_name='$customer_search'";
    }
    if($payment_type){
        $payment_check="AND payment_type='$payment_type'";
    }

    if ($to_date && $from_date) {
        $date_check = "AND date BETWEEN '$from_date' AND '$to_date'";
    } elseif ($from_date) {
        $date_check = "AND date>='$from_date'";
        $limit = "";
    } elseif ($to_date) {
        $date_check = "AND date<='$to_date'";
        $limit = "";
    } else {
        $date_check = "";
        $limit = "LIMIT 50";
    }


    echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Payment</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
    $i=1;
    $result=mysqli_query($conn, "SELECT * FROM sales WHERE cancel_status='0' $payment_check $customer_check $sales_no_check $date_check  ORDER BY id DESC LIMIT 500");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        echo '
		<tr>
		<td>'.$i.'</td>
		    <td><div class="col-lg-1" style="color:white;"><a href="sales.php?job=print_sales&sales_no=' . $row ['sales_no'] . '&date='.$row['date'].'" class="btn btn-xs btn-primary" target="_blank">' . $row ['sales_no'] . '</a></div></td>

					
			<td>'.$row[date].'</td>
			<td>'.$row[customer_name].'</td>
			<td align="right">'.$row[total].'</td>
		    <td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="right">'.$row[payment_type].'</td>
			<td align="center">'.$row[remarks].'</td>
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
        $i++;


        $total=$total+$row[total];
        $due_total=$due_total+$row[due];
        $paid_total=$paid_total+$row[paid];
    }

    echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table></div>';


    include 'conf/closedb.php';
}

function list_sales(){
    include 'conf/config.php';
    include 'conf/opendb.php';

    echo '<div class="table-responsive">
              <table class="table">
				<thead valign="top">
				<th>No</th>
				<th>Sales No</th>
				<th>Sales Date</th>
				<th>Customer Name</th>
				<th>Sales Total</th>
				<th>Payment</th>
				<th>Remarks</th>
				<th>Prepared By</th>
			
				</thead>
				<tbody valign="top">';

    $i=1;
    $result=mysqli_query($conn, "SELECT * FROM sales WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        echo '
		<tr>
			<td>'.$i.'</td>
			 <td><div class="col-lg-1" style="color:white;"><a href="sales.php?job=print_sales&sales_no=' . $row ['sales_no'] . '&date='.$row['date'].'" class="btn btn-xs btn-primary" target="_blank">' . $row ['sales_no'] . '</a></div></td>
			
			<td>'.$row[date].'</td>
			<td>'.$row[customer_name].'</td>
			<td align="right">'.$row[total].'</td>
			<td align="right">'.$row[payment_type].'</td>
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

function add_pending_order($title, $newname,$url,$company_id,$place_id,$start_date,$end_date,$marketing_person){
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ( $conn, $dbname );
    $query = "INSERT INTO ad (id,title, image, url,company_id,place_id,start_date,end_date,marketing_person)
	VALUES ('','$title','$newname', '$url','$company_id','$place_id','$start_date','$end_date','$marketing_person')";

    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}

function print_past_sales_item($sales_no){
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

function print_sales_item($sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $i=0;
    $sub_total=0;
    echo'<table style="width: 100%;" class="table-responsive dt-responsive">';
    $result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0' ORDER BY id ASC");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        //$total=$row[quantity]*$row[selling_price];
        echo'<tr>
                <td colspan="2">'.$row[product_name].'</td>
            </tr>
            <tr>
                <td>('.$row[quantity].' * '.$row[selling_price].')</td>
                <td>('.$row[discount].'%)</td>
                <td align="right"><strong>'.number_format($row[total],2).'</strong></td>
            </tr>';
        $sub_total += $row[total];
        $i+=1;
    }
    echo '</table>
    <strong>--------------------------------------------------</strong>';
    echo'<table style="width: 100%;" class="table-responsive dt-responsive">
       <tr>
            <td><strong>TOTAL</strong></td>
            <td align="right"><strong>'.number_format($sub_total,2).'</strong></td>
        </tr>';

    $result1=mysqli_query($conn, "SELECT * FROM sales WHERE sales_no='$sales_no' AND cancel_status='0'");
    while($row1= mysqli_fetch_array($result1, MYSQLI_ASSOC))
    {
        echo' </table>
        <strong>--------------------------------------------------</strong>
        <table style="width: 100%;" class="table-responsive dt-responsive">
        <tr>
            <td><strong>NET TOTAL</strong></td>
			
            <td align="right"><strong>'.number_format($row1[total_after_discount],2).'</strong></td>
        </tr>
        <tr>
            <td><strong>RECEIVED ('.$row1[payment_type].')</strong></td>
			
            <td align="right"><strong>'.number_format($row1[customer_amount],2).'</strong></td>
        </tr></table>
       <strong>--------------------------------------------------</strong>
       <table style="width: 100%;" class="table-responsive dt-responsive">       
        <tr>
            <td><strong>BALANCE</strong></td>
			
            <td align="right"><strong>'.number_format($row1[balance],2).'</strong></td>
        </tr>   		
            		
       ';
    }
    echo'</table>';
    include 'conf/closedb.php';


}

function get_total_without_discount($sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $net_total=0;

    $result=mysqli_query($conn, "SELECT * FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $total=$row[quantity]*$row[selling_price];
        $net_total=$net_total+$total;
    }
    return $net_total;
    include 'conf/closedb.php';
}

function no_of_items($sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT count(id) FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        $count=$row['count(id)'];
        return $count;
    }

    include 'conf/closedb.php';
}
function no_of_pieces($sales_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT sum(quantity) AS pieces FROM sales_has_items WHERE sales_no='$sales_no' AND cancel_status='0'");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row['pieces'];
    }

    include 'conf/closedb.php';
}


function get_gift_card_amount_from_gift_voucher($gift_card_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM gift_voucher WHERE voucher_no='$gift_card_no' AND cancel_status='0' AND status='0' ");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        return $row;
    }
    include 'conf/closedb.php';
}


function update_gift_voucher_status($gift_card_no){
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db($conn_for_changing_db, $dbname);
    $query = "UPDATE gift_voucher SET
	status='1'
	WHERE voucher_no='$gift_card_no'";
    mysqli_query($conn, $query);

    include 'conf/closedb.php';
}


function check_gift_card($gift_card_no) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gift_voucher WHERE voucher_no='$gift_card_no' AND cancel_status='0' AND status='0'"))){
        return 1;
    }
    else{
        return 0;
    }

    include 'conf/closedb.php';
}

function list_today_sales_report(){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date=date('Y-m-d');
    echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Payment</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
    $i=1;
    $result=mysqli_query($conn, "SELECT * FROM sales WHERE cancel_status='0' AND date='$date'  ORDER BY id DESC LIMIT 500");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        echo '
		<tr>
		<td>'.$i.'</td>
		    <td><div class="col-lg-1" style="color:white;"><a href="sales.php?job=print_sales&sales_no=' . $row ['sales_no'] . '&date='.$row['date'].'" class="btn btn-xs btn-primary" target="_blank">' . $row ['sales_no'] . '</a></div></td>

					
			<td>'.$row[date].'</td>
			<td>'.$row[customer_name].'</td>
			<td align="right">'.$row[total].'</td>
		    <td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="right">'.$row[payment_type].'</td>
			<td align="center">'.$row[remarks].'</td>
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
        $i++;


        $total=$total+$row[total];
        $due_total=$due_total+$row[due];
        $paid_total=$paid_total+$row[paid];
    }

    echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table></div>';


    include 'conf/closedb.php';
}

function list_today_sales_search_report($payment_type){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date=date('Y-m-d');
    if($payment_type=='all' || $payment_type=='ALL'){
        $payment_check="";
    }
    elseif($payment_type=='non credit'||$payment_type=='NON CREDIT'){
        $payment_check="AND payment_type !='CREDIT'";
    }
    else{
        $payment_check="AND payment_type='$payment_type'";
    }

    echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">
	<th>No</th>
	<th>Sales No</th>
	<th>Sales Date</th>
	<th>Customer Name</th>
	<th>Sales Total</th>
	<th>Due</th>
	<th>Paid</th>
	<th>Payment</th>
	<th>Remarks</th>
	<th>Prepared By</th>
	</thead>
	<tbody valign="top">';
    $i=1;
    $result=mysqli_query($conn, "SELECT * FROM sales WHERE cancel_status='0' AND date='$date' $payment_check  ORDER BY id DESC LIMIT 500");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        echo '
		<tr>
		<td>'.$i.'</td>
		    <td><div class="col-lg-1" style="color:white;"><a href="sales.php?job=print_sales&sales_no=' . $row ['sales_no'] . '&date='.$row['date'].'" class="btn btn-xs btn-primary" target="_blank">' . $row ['sales_no'] . '</a></div></td>

					
			<td>'.$row[date].'</td>
			<td>'.$row[customer_name].'</td>
			<td align="right">'.$row[total].'</td>
		    <td align="right">'.$row[due].'</td>
			<td align="right">'.$row[paid].'</td>
			<td align="right">'.$row[payment_type].'</td>
			<td align="center">'.$row[remarks].'</td>
			<td>'.strtoupper($row[prepared_by]).'</td>
		
			</tr>';
            $i++;


        $total=$total+$row[total];
        $due_total=$due_total+$row[due];
        $paid_total=$paid_total+$row[paid];
    }

    echo '<tr><th colspan="4">Total</th><th>'.number_format($total, 2).'</th><th>'.number_format($due_total, 2).'</th><th>'.number_format($paid_total, 2).'</th></tr></tbody></table></div>';


    include 'conf/closedb.php';
}