<?php
function list_purchase_order_search_for_confirm($purchase_order_no_search, $supplier_search){
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

		echo '<tbody>';

		$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE $suppier_check $and $purchase_order_no_check AND cancel_status='0' AND confirmed='0' ORDER BY id DESC LIMIT 500");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
		echo '
				<tr>
					<td align="center"><a href="confirm.php?job=view&id='.$row[id].'"  ><img src="images/view.png" alt="View" width="24" height="24"/></a></td>
		
					<td align="center">'.$row[purchase_order_no].'</td>
							
					<td>'.$row[date].'</td>
							
					<td>'.$row[supplier_name].'</td>
					
					<td align="right">'.$row[total].'</td>
				
					<td>'.$row[remarks].'</td>
					
					<td>'.strtoupper($row[prepared_by]).'</td>
					
					<td align="center"><a href="confirm.php?job=confirm&id='.$row[id].'"  ><img src="images/stamp.png" alt="Confirm" width="24" height="24" /></a></td>
					
				</tr>';
		}
		echo '</tbody>';
	}

	include 'conf/closedb.php';
}

function list_purchase_orders_for_confirm(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<tbody>';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE cancel_status='0' AND confirmed='0' ORDER BY id DESC LIMIT 10");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
			<tr>
				<td align="center"><a href="confirm.php?job=view&id='.$row[id].'"  ><img src="images/view.png" alt="View" width="24" height="24"/></a></td>
	
				<td align="center">'.$row[purchase_order_no].'</td>
						
				<td>'.$row[date].'</td>
						
				<td>'.$row[supplier_name].'</td>
				
				<td align="right">'.$row[total].'</td>
			
				<td>'.$row[remarks].'</td>
				
				<td>'.strtoupper($row[prepared_by]).'</td>
				
				<td align="center"><a href="confirm.php?job=confirm&id='.$row[id].'"  ><img src="images/stamp.png" alt="Confirm" width="24" height="24" /></a></td>
				
			</tr>';
	}
	echo '</tbody>';

	include 'conf/closedb.php';
}

function display_purchase_order($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$info=get_purchase_order_info_by_purchase_no($purchase_order_no);
	
	echo '<div style="width: 890px; min-height: 170px; background-color: #eee; margin-bottom: 10px; float: left; margin-top: 20px; padding-left: 10px; padding-top: 10px; border-radius: 10px;">
	<a href="confirm.php?job=confirm&id='.$info[id].'"  ><div class="more" style="margin-bottom: -50px; margin-left: 760px;">Confirm</div></a>';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
			<table>
			<tr>
				<th align="left">Purchase Order No </th>	
				<td>: '.$row[purchase_order_no].'</td>
			</tr>
			<tr>
				<th align="left">Purchased date </th>			
				<td>: '.$row[date].'</td>
			</tr>
			<tr>
				<th align="left">Supplier Name </th>			
				<td>: '.$row[supplier_name].'</td>
			</tr>
			<tr>
				<th align="left">Purchased Total</th>	
				<td>: '.$row[total].'</td>
			</tr>
			<tr>
				<th align="left">Remarks</th>
				<td>: '.$row[remarks].'</td>
			</tr>
			<tr>
				<th align="left">Prepared By</th>	
				<td>: '.strtoupper($row[prepared_by]).'</td>
			</tr>
		</table>';
	}
	echo "</div>";
	include 'conf/closedb.php';
}

function display_purchase_order_items($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="sales_table" style="width: 895px; margin-top: 10px;">
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Product ID</th>
			<th>Product Catagory</th>		
			<th>Description</th>
			<th colspan="2">Quantity</th>
			<th>Buying Price</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>';
	$result=mysqli_query($conn, "SELECT * FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no' AND cancel_status='0' ORDER BY id ASC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo"
		<tabel>
			<tr>
				<td>$row[product_name]</td>
				<td>$row[product_id]</td>
				<td>$row[catagory]</td>
				<td>$row[product_description]</td>
				<td>$row[quantity]</td>
				<td>$row[measure_type]</td>
				<td align='right'>$row[buying_price]</td>
				<td align='right'>$row[total]</td>".'
			</tr>
		';
	}
	$total=get_total($purchase_order_no);
	echo '	<td colspan="7"></td>
			<th align="right">'.$total.'</th></tbody></table>';
	include 'conf/closedb.php';
}

function update_confirmed($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE purchase_order SET
	confirmed='1'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function update_inventory($purchase_order_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM purchase_order_has_items WHERE purchase_order_no='$purchase_order_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		$product_id=$row['product_id'];
		$product_name=$row['product_name'];
		$quantity=$row['quantity'];
		$buying_price=$row['buying_price'];
		$purchased_date=$row['date'];
		$catagory=$row['catagory'];
		$product_description=$row['product_description'];
		$measure_type=$row['measure_type'];
		$user_name=$row['user_name'];
		$total=$row['total'];
		$supplier=$row['supplier_name'];
		$selling_price="";
		$discount="";
		$label="";


		if (check_added_items_inventory($product_id)==1){
			$info=get_inventory_info_by_product_id($product_id);
			$old_quantity=$info['quantity'];
			$new_quantity=$old_quantity+$quantity;

			update_product_by_product_id($product_id, $product_name, $new_quantity, $selling_price, $buying_price, $discount, $catagory, $product_description, $measure_type, $purchased_date, $label, $supplier);
		}
		else{
			save_product($product_id, $product_name, $quantity, $selling_price, $buying_price, $discount, $catagory, $product_description, $measure_type, $purchased_date, $label, $supplier);
		}

	}

}