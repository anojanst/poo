<?php 
function list_suppliers(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px;">
	<thead valign="top">
	<th width="20">Edit</th>
	<th width="120">Supplier Name</th>
	<th width="120">Address</th>
	<th width="100">Telephone No</th>
	<th width="80">Fax No</th>
	<th width="80">Email</th>
	<th width="120">Contact person</th>
	<th width="20">Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM suppliers WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="suppliers.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[supplier_name].'</td>
					
			<td>'.$row[address].'</td>
					
			<td>'.$row[telephone].'</td>
			
			<td>'.$row[fax].'</td>
			
			<td>'.$row[email].'</td>
		
			<td>'.$row[contact_person].'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'suppliers.php?job=delete&id='.$row[id].'\',\'No\',\'suppliers.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function list_supplier_search($search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px;">
	<thead valign="top">
	<th width="20">Edit</th>
	<th width="120">Supplier Name</th>
	<th width="120">Address</th>
	<th width="100">Telephone No</th>
	<th width="80">Fax No</th>
	<th width="80">Email</th>
	<th width="120">Contact person</th>
	<th width="20">Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM suppliers WHERE supplier_name LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="suppliers.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[supplier_name].'</td>
					
			<td>'.$row[address].'</td>
					
			<td>'.$row[telephone].'</td>
			
			<td>'.$row[fax].'</td>
			
			<td>'.$row[email].'</td>
		
			<td>'.$row[contact_person].'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'suppliers.php?job=delete&id='.$row[id].'\',\'No\',\'suppliers.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function save_supplier($supplier_name, $address, $telephone, $fax, $email, $contact_person) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO suppliers (id, supplier_name, address, telephone, fax, email, contact_person, created_by)
	VALUES ('', '$supplier_name', '$address', '$telephone', '$fax', '$email', '$contact_person', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_supplier($id, $supplier_name, $address, $telephone, $fax, $email, $contact_person) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE suppliers SET
	supplier_name='$supplier_name',
	address='$address',
	telephone='$telephone',
	fax='$fax',
	email='$email',
	contact_person='$contact_person',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_supplier_info_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM suppliers WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'functions/closedb.php';
}

function get_supplier_info($supplier_name) {
		include 'conf/config.php';
		include 'conf/opendb.php';

		$result=mysqli_query($conn, "SELECT * FROM suppliers WHERE supplier_name='$supplier_name'");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			return $row;
		}
}

function cancel_supplier($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE suppliers SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}