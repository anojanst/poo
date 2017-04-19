<?php
function list_publication() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<tbody>';

	$result = mysqli_query($conn, "SELECT * FROM publication WHERE cancel_status='0' ORDER BY id DESC");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="publication.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[publication_id] . '</td>
				<td>' . $row[publication] . '</td>
				<td>' . $row[description] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'publication.php?job=delete&id=' . $row[id] . '\',\'No\',\'publication.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody>';

	include 'conf/closedb.php';
}

function list_publication_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
	<thead valign="top">
	<th>Edit</th>
	<th>Publication ID</th>
	<th>Publication Name</th>
	<th>Description</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM publication WHERE publication LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="publication.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[publication_id] . '</td>
				<td>' . $row[publication] . '</td>
				<td>' . $row[description] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'publication.php?job=delete&id=' . $row[id] . '\',\'No\',\'publication.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}

function save_publication($publication, $publication_id, $description) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO publication (id, publication_id, publication, description, created_by)
	VALUES ('', '$publication_id', '$publication', '$description', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_publication($id, $publication, $publication_id, $description){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE publication SET
	publication='$publication',
	publication_id='$publication_id',
	description='$description',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_publication($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE publication SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_publication_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM publication WHERE id='$id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}