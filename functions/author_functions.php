<?php
function list_author() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	echo '<tbody>';
	$result = mysqli_query($conn, "SELECT * FROM author WHERE cancel_status='0' ORDER BY id DESC LIMIT 50");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="author.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[author_id] . '</td>					
				<td>' . $row[author] . '</td>
				<td>' . $row[description] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'author.php?job=delete&id=' . $row[id] . '\',\'No\',\'author.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody>';

	include 'conf/closedb.php';
}

function list_author_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<table class="inventory_table">
	<thead valign="top">
	<th>Edit</th>
	<th>Author ID</th>
	<th>Author Name</th>
	<th>Description</th>
	<th>Delete</th>
	</thead>
	<tbody valign="top">';

	$result = mysqli_query($conn, "SELECT * FROM author WHERE author LIKE '%$search%' AND cancel_status='0' ORDER BY id DESC LIMIT 500");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		echo '<tr>
				<td align="center"><a href="author.php?job=edit&id=' . $row[id] . '"  ><img src="images/edit.png" alt="Edit" width="24" height="24"/></a></td>
				<td>' . $row[author_id] . '</td>					
				<td>' . $row[author] . '</td>
				<td>' . $row[description] . '</td>
				<td align="center"><a href="#" onclick="javascript:showConfirm(\'Are you sure you want to delete this entry?\',\'\',\'Yes\',\'author.php?job=delete&id=' . $row[id] . '\',\'No\',\'author.php\')"><img src="images/close.png" alt="Delete" height="24" width="24"/></a></td>
				</tr>';
	}
	echo '</tbody></table>';

	include 'conf/closedb.php';
}

function save_author($author, $author_id, $description) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "INSERT INTO author (id, author_id, author, description, created_by)
	VALUES ('', '$author_id', '$author', '$description', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die(mysqli_error($conn));

	include 'conf/closedb.php';
}

function update_author($id, $author, $author_id, $description){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE author SET
	author='$author',
	author_id='$author_id',
	description='$description',
	updated_by='$_SESSION[user_name]'
	WHERE id='$id'";

	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function cancel_author($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE author SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]' 
	WHERE id='$id'";
	mysqli_query($conn, $query);

	include 'conf/closedb.php';
}

function get_author_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query($conn, "SELECT * FROM author WHERE id='$id'");
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		return $row;
	}
	include 'conf/closedb.php';
}