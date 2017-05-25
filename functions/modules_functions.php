<?php
function save_module($module_name, $module_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $conn, $dbname );
	$query = "INSERT INTO modules (id, module_name, module_no)
	VALUES ('', '$module_name', '$module_no')";
	
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function list_modules() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
			<table  id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Module Name</th>
                           <th>Module No</th>
                           <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody valign="top">';
	$i = 1;
	$result = mysqli_query ( $conn, "SELECT * FROM modules" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<td><a href="modules.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [module_name] . '</td>
					
		<td>' . $row [module_no] . '</td>
					
		<td><a href="modules.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}
function get_modules_info_by_id($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM modules WHERE id='$id'" );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		return $row;
	}
	
	
}
function update_module($id, $module_name, $module_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE modules SET
	module_name='$module_name',
	module_no='$module_no'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
}

function delete_module($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM modules WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
function cancel_module($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE modules SET
	cancel_status='1'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
