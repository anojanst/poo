<?php

function list_branch() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ( $conn, "SELECT * FROM branch WHERE cancel_status='0' AND branch_name != '$_SESSION[branch]'" );
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$to_branch_names [$i] = $row ['branch_name'];

		$i ++;
	}		
	return $to_branch_names;
}


function get_product_id_by_product_name($product_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM inventory WHERE product_name='$product_name'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}




function save_transfer($transfer_no, $branch, $to_branch){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date("Y-m-d");
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO inventory_transfer (id, transfer_no, from_branch, to_branch, transfer_by, transfer_time)
	VALUES ('', '$transfer_no', '$branch', '$to_branch', '$_SESSION[user_name]', '$date')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));
	

	include 'conf/closedb.php';
}

function save_transfer_has_items($transfer_no, $product_id, $product_name, $quantity){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO transfer_has_items (id, transfer_no, product_id, product_name, quantity)
	VALUES ('', '$transfer_no', '$product_id', '$product_name', '$quantity')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));
	

	include 'conf/closedb.php';
}




function get_stock_by_branch_product_id($product_id, $to_branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM multiple_stock_has_inventory WHERE product_id='$product_id' AND branch='$to_branch'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				return $row;
		
		}
	include 'conf/closedb.php';
}

function list_item_by_transfer($transfer_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM transfer_has_items WHERE transfer_no='$transfer_no' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo'<tr>
            <td align="center" ><a href="transfer.php?job=delete_item&id='.$row[id].'" ><img src="images/close.png" alt="Delete" /></a></td>		
		    <td>'.$row[product_name].'</td>
            <td>'.$row[quantity].'</td>	
		</tr>';
	}
	include 'conf/closedb.php';

}

function get_transfer_no(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT MAX(transfer_no) FROM transfer_has_items");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(transfer_no)']+1;
	}

	include 'conf/closedb.php';
}

function remove_transfer_has_items($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	 
	$query = "DELETE FROM transfer_has_items WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}


function update_stock($to_branch, $transfer_no ){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysqli_query($conn, "SELECT * FROM transfer_has_items Where transfer_no='$transfer_no' ");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
			$product_id=$row['product_id'];
			
			$result2=mysqli_query($conn, "SELECT * FROM transfer_has_items Where transfer_no='$transfer_no' AND  product_id='$product_id'");
			while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC))
		{
				$quantity=$row2['quantity'];
				
				$info =get_stock_by_branch_product_id($product_id, $_SESSION['branch']);
				$stock=$info['stock'];
				$new_stock= $stock-$quantity;
				
				mysqli_select_db($conn_for_changing_db, $dbname);
				$query = "UPDATE multiple_stock_has_inventory SET
				stock='$new_stock'
				WHERE product_id='$product_id' AND branch='$_SESSION[branch]'";
				mysqli_query($conn, $query);
				
				$info2 =get_stock_by_branch_product_id($product_id, $to_branch);
				$stock2=$info2['stock'];
				$new_stock2= $stock2+$quantity;
				
				mysqli_select_db($conn_for_changing_db, $dbname);
				$query = "UPDATE multiple_stock_has_inventory SET
				stock='$new_stock2'
				WHERE product_id='$product_id' AND branch='$to_branch'";
				mysqli_query($conn, $query);
				
		}
	}

	include 'conf/closedb.php';
}


function list_to_store(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">

	<th>transfer No</th>
	<th>Branch</th>
	<th>Transfer Time</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Quantity</th>

	</thead>
	<tbody valign="top">';

	$i=1;

	$result=mysqli_query($conn, "SELECT * FROM inventory_transfer WHERE from_branch='$_SESSION[branch]' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$result1=mysqli_query($conn, "SELECT * FROM transfer_has_items WHERE transfer_no='$row[transfer_no]' ORDER BY id DESC LIMIT 500");
		while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
		{
			echo '
			<tr>
	
				<td>'.$row[transfer_no].'</td>					
				<td>'.$row[to_branch].'</td>
				<td>'.$row[transfer_time].'</td>		
				<td>'.$row1[product_id].'</td>			
				<td>'.$row1[product_name].'</td>
				<td>'.$row1[quantity].'</td>
	
			
			</tr>';
		}
	}
	echo '</tbody>
          </table>
          </div>';
	include 'conf/closedb.php';
}


function search_to_store($to_branch, $from_date, $to_date){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">

	<th>transfer No</th>
	<th>Branch</th>
	<th>Transfer Time</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Quantity</th>

	</thead>
	<tbody valign="top">';

	
	if($to_branch){
		$to_branch_check="AND to_branch LIKE '%$to_branch%'";
	}

	
	if ($to_date && $from_date) {
		$date_check = "AND transfer_time BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND transfer_time>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND transfer_time<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	
	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM inventory_transfer WHERE from_branch='$_SESSION[branch]' $to_branch_check $date_check ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$result1=mysqli_query($conn, "SELECT * FROM transfer_has_items WHERE transfer_no='$row[transfer_no]' ORDER BY id DESC LIMIT 500");
		while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
		{
			echo '
			<tr>
	
				<td>'.$row[transfer_no].'</td>					
				<td>'.$row[to_branch].'</td>
				<td>'.$row[transfer_time].'</td>		
				<td>'.$row1[product_id].'</td>			
				<td>'.$row1[product_name].'</td>
				<td>'.$row1[quantity].'</td>
	
			
			</tr>';
		}
	}
	echo '</tbody>
          </table>
          </div>';
	include 'conf/closedb.php';
}



function list_from_store(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">

	<th>transfer No</th>
	<th>Branch</th>
	<th>Transfer Time</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Quantity</th>

	</thead>
	<tbody valign="top">';

	$i=1;

	$result=mysqli_query($conn, "SELECT * FROM inventory_transfer WHERE to_branch='$_SESSION[branch]' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$result1=mysqli_query($conn, "SELECT * FROM transfer_has_items WHERE transfer_no='$row[transfer_no]' ORDER BY id DESC LIMIT 500");
		while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
		{
			echo '
			<tr>
	
				<td>'.$row[transfer_no].'</td>					
				<td>'.$row[from_branch].'</td>
				<td>'.$row[transfer_time].'</td>		
				<td>'.$row1[product_id].'</td>			
				<td>'.$row1[product_name].'</td>
				<td>'.$row1[quantity].'</td>
	
			
			</tr>';
		}
	}
	echo '</tbody>
          </table>
          </div>';
	include 'conf/closedb.php';
}


function search_from_store($from_branch, $from_date, $to_date){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
		echo '<div class="table-responsive">
              <table class="table">
	<thead valign="top">

	<th>transfer No</th>
	<th>Branch</th>
	<th>Transfer Time</th>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Quantity</th>

	</thead>
	<tbody valign="top">';

	
	if($from_branch){
		$from_branch_check="AND from_branch LIKE '%$from_branch%'";
	}

	
	if ($to_date && $from_date) {
		$date_check = "AND transfer_time BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND transfer_time>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND transfer_time<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM inventory_transfer WHERE to_branch='$_SESSION[branch]' $from_branch_check $date_check ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$result1=mysqli_query($conn, "SELECT * FROM transfer_has_items WHERE transfer_no='$row[transfer_no]' ORDER BY id DESC LIMIT 500");
		while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
		{
			echo '
			<tr>
	
				<td>'.$row[transfer_no].'</td>					
				<td>'.$row[from_branch].'</td>
				<td>'.$row[transfer_time].'</td>		
				<td>'.$row1[product_id].'</td>			
				<td>'.$row1[product_name].'</td>
				<td>'.$row1[quantity].'</td>
	
			
			</tr>';
		}
	}
	echo '</tbody>
          </table>
          </div>';
	include 'conf/closedb.php';
}