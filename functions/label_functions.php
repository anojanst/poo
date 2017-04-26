<?php
function list_label() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<tbody>';

	$result = mysqli_query($conn, "SELECT * FROM label WHERE cancel_status='0' ORDER BY id DESC LIMIT 50");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="label.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[id] . '</td>					
				<td>' . $row[label] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'label.php?job=delete&id=' . $row[id] . '\',\'No\',\'label.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody> ';

	include 'conf/closedb.php';
}

function list_label_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
	<thead valign="top">
	<th>Edit</th>
	<th>ID</th>
	<th>Label</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM label WHERE label LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="label.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[id] . '</td>					
				<td>' . $row[label] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'label.php?job=delete&id=' . $row[id] . '\',\'No\',\'label.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}

function save_label($label) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO label (id, label, created_by)
	VALUES ('', '$label', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_label($id, $label){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE label SET
	label='$label',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_label($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE label SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]' 
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_label_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM label WHERE id='$id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}