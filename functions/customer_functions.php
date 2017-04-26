<?php 
function list_customer(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px;">
	<thead valign="top">
	<th width="20">Edit</th>
	<th width="120">Customer Name</th>
	<th width="120">Address</th>
	<th width="100">Telephone No</th>
	<th width="80">Fax No</th>
	<th width="80">Email</th>
	<th width="120">Contact person</th>
	<th width="20">Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM customer WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="customer.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[customer_name].'</td>
					
			<td>'.$row[address].'</td>
					
			<td>'.$row[telephone].'</td>
			
			<td>'.$row[fax].'</td>
			
			<td>'.$row[email].'</td>
		
			<td>'.$row[contact_person].'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'customer.php?job=delete&id='.$row[id].'\',\'No\',\'customer.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function list_customer_search($search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px;">
	<thead valign="top">
	<th width="20">Edit</th>
	<th width="120">Customer Name</th>
	<th width="120">Address</th>
	<th width="100">Telephone No</th>
	<th width="80">Fax No</th>
	<th width="80">Email</th>
	<th width="120">Contact person</th>
	<th width="20">Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM customer WHERE customer_name LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="customer.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[customer_name].'</td>
					
			<td>'.$row[address].'</td>
					
			<td>'.$row[telephone].'</td>
			
			<td>'.$row[fax].'</td>
			
			<td>'.$row[email].'</td>
		
			<td>'.$row[contact_person].'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'customer.php?job=delete&id='.$row[id].'\',\'No\',\'customer.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function save_customer($customer_name, $address, $contact_person, $telephone, $fax, $email, $customer_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$opening_balance_date = date("Y-m-d", strtotime($opening_balance_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO customer (`customer_name`, `address`, `contact_person`, `telephone`, `fax`, `email`, `customer_status`, `opening_balance`, `opening_balance_date`, `credit_limit`, `credit_period`, `created_by`)
	VALUES ('$customer_name', '$address', '$contact_person', '$telephone', '$fax', '$email', '$customer_status', '$opening_balance', '$opening_balance_date', '$credit_limit', '$credit_period', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';

}

function update_customer($id, $customer_name, $address, $contact_person, $telephone, $fax, $email, $customer_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$opening_balance_date = date("Y-m-d", strtotime($opening_balance_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE customer SET
	customer_name='$customer_name',
	contact_person='$contact_person',
	address='$address',
	telephone='$telephone',
	fax='$fax',
	email='$email',
	customer_status='$customer_status',
	opening_balance='$opening_balance',
	opening_balance_date='$opening_balance_date',
	credit_limit='$credit_limit',
	credit_period='$credit_period',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function get_customer_info_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM customer WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'conf/closedb.php';
}

function get_customer_info($customer_name) {
		include 'conf/config.php';
		include 'conf/opendb.php';

		$result=mysqli_query($conn, "SELECT * FROM customer WHERE customer_name='$customer_name'");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			return $row;
		}
}

function cancel_customer($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE customer SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}