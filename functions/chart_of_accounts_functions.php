<?php 
function list_account(){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<thead valign="top">
					<th>Edit</th>
					<th>Account name</th>
					<th>Address</th>
					<th>Telephone</th>
					<th>Fax</th>
					<th>Email</th>
					<th>Contact Person</th>
					<th>Delete</th>
				</thead>
			<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM chart_of_accounts WHERE cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
			<tr>
				<td><a href="chart_of_accounts.php?job=edit&id='.$row[id].'"  ><i class="fa fa-edit fa-2x"></i></a></td>
	
				<td>'.$row[account_name].'</td>
						
				<td>'.$row[address].'</td>
						
				<td>'.$row[telephone].'</td>
				
				<td>'.$row[fax].'</td>
				
				<td>'.$row[email].'</td>
			
				<td>'.$row[contact_person].'</td>
			
				<td><a href="chart_of_accounts.php?job=delete&id='.$row[id].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
						
			</tr>';
	}
	echo '</tbody></table></div>';
	
	include 'conf/closedb.php';
}

function list_account_search($search){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table class="inventory_table" style="width: 900px;">
	<thead valign="top">
	<th width="20">Edit</th>
	<th width="120">Account Name</th>
	<th width="120">Address</th>
	<th width="100">Telephone No</th>
	<th width="80">Fax No</th>
	<th width="80">Email</th>
	<th width="120">Contact person</th>
	<th width="20">Delete</th>
	</thead>
	<tbody valign="top">';

	$result=mysqli_query($conn, "SELECT * FROM chart_of_accounts WHERE account_name LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
			<td><a href="chart_of_accounts.php?job=edit&id='.$row[id].'"  ><img src="images/edit.png" alt="Edit" /></a></td>

			<td>'.$row[account_name].'</td>
					
			<td>'.$row[address].'</td>
					
			<td>'.$row[telephone].'</td>
			
			<td>'.$row[fax].'</td>
			
			<td>'.$row[email].'</td>
		
			<td>'.$row[contact_person].'</td>
		
			<td><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'customer.php?job=delete&id='.$row[id].'\',\'No\',\'chart_of_accounts.php\')"><img src="images/close.png" alt="Delete" /></a></td>
		</tr>';
	}
	echo '</tbody></table>';
	
	include 'conf/closedb.php';
}

function save_account($account_name, $account_code, $parent_account, $catagory, $address, $contact_person, $telephone, $fax, $email, $account_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$opening_balance_date = date("Y-m-d", strtotime($opening_balance_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO chart_of_accounts (`account_name`, `address`, `account_code`, `parent_account`, `account_catagory`, `contact_person`, `telephone`, `fax`, `email`, `account_status`, `opening_balance`, `opening_balance_date`, `credit_limit`, `credit_period`, `created_by`)
	VALUES ('$account_name', '$address', '$account_code', '$parent_account', '$catagory', '$contact_person', '$telephone', '$fax', '$email', '$account_status', '$opening_balance', '$opening_balance_date', '$credit_limit', '$credit_period', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';

}

function update_account($id, $account_name, $account_code, $parent_account, $catagory, $address, $contact_person, $telephone, $fax, $email, $account_status, $opening_balance, $opening_balance_date, $credit_limit, $credit_period) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$opening_balance_date = date("Y-m-d", strtotime($opening_balance_date));
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE chart_of_accounts SET
	account_name='$account_name',
	account_code='$account_code',
	parent_account='$parent_account',
	account_catagory='$catagory',
	contact_person='$contact_person',
	address='$address',
	telephone='$telephone',
	fax='$fax',
	email='$email',
	account_status='$account_status',
	opening_balance='$opening_balance',
	opening_balance_date='$opening_balance_date',
	credit_limit='$credit_limit',
	credit_period='$credit_period',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}

function get_account_info_by_id($id){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM chart_of_accounts WHERE id='$id'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

	include 'conf/closedb.php';
}

function get_account_info($account_name) {
		include 'conf/config.php';
		include 'conf/opendb.php';

		$result=mysqli_query($conn, "SELECT * FROM chart_of_accounts WHERE account_name='$account_name'");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			return $row;
		}
}

function cancel_account($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE chart_of_accounts SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query) or die (mysqli_error($conn));

	include 'conf/closedb.php';
}