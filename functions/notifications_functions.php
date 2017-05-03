<?php
function list_all_notifications() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
			<table  id="example1" style="width: 100%;" class="table table-bordered table-striped">
                  <thead>
                       <tr>
                           <th>Product ID</th>
						   <th>Product Name</th>
						   <th>Branch</th>
						   <th>Stock </th>
						   <th>Re-order Level</th>
						   <th>Seen Status</th>
						   <th>View</th>
                       </tr>
                  </thead>
                  <tbody valign="top">';
	
	$result = mysqli_query ( $conn, "SELECT * FROM notification" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

				
		echo '	
		<td>'.$row[product_id].' </td>
		<td>'.$row[product_name].' </td>
		<td>'.$row[branch].' </td>
		<td>'.$row[stock].' </td>
		<td>'.$row[reorder].' </td>

		<td> ';
			if ($row[seen_status] == '0'){
					echo' 
							<a href="notification.php?job=update_unseen&product_id='.$row['product_id'].'&branch='.$row[branch].'&id='.$row[id].'"> <button type="button" class="btn btn-block btn-warning">Mark As Seen</button></a>';
					}
					else{
						echo'
							<h5>Seen</h5>';
					}
		echo'				
		</td>		
				
		<td><a href="notification.php?job=view_not&product_id='.$row[product_id].'&branch='.$row[branch].'&id='.$row[id].'"> <i class="fa fa-eye"></i></a></td>

			
				
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}

function view_notification($product_id, $branch, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ( $conn, "SELECT * FROM notification WHERE product_id='$product_id' AND branch='$branch' AND id='$id' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo'

	<!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">

              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">'.$row['product_name'].'</h3>
              
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
              		
                <li><a href="#">Product ID : &nbsp; &nbsp; &nbsp; &nbsp; <span class="badge bg-blue"> '.$row['product_id'].'</span></a></li>
                <li><a href="#">Branch :  &nbsp; &nbsp; &nbsp; &nbsp;   <span style="font-weight:bold" > '.$row['branch'].'</span></a></li>
                <li><a href="#">Stock :  &nbsp; &nbsp; &nbsp; &nbsp;   <span style="font-weight:bold" > '.$row['stock'].'</span></a></li>
                <li><a href="#">Reorder-Level :  &nbsp; &nbsp; &nbsp; &nbsp;   <span style="font-weight:bold" > '.$row['reorder'].'</span></a></li>
                <li><a href="#">Re-order Time :  &nbsp; &nbsp; &nbsp; &nbsp;   <span style="font-weight:bold" > '.$row['reorder_time'].'</span></a></li>
                		
				<li><a href="#">Seen Status : &nbsp; &nbsp; &nbsp; &nbsp;';
						if($row[seen_status] == '1')
						{ 
                			echo' <span class="badge bg-blue"> SEEN </span>';
						}else {
							echo' <span class="badge bg-red"> Un seen </span>';
						}                			
				echo'		
                </a></li>
                		
                		
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->				
						
			';


	}

}



function update_unseen_as_seen($product_id, $branch, $id) {
	
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db ($conn, $dbname );
	
	$query = "UPDATE notification SET
	seen_status='1'
	WHERE product_id='$product_id' AND branch='$branch' AND id='$id'";

	mysqli_query ($conn, $query );

}
