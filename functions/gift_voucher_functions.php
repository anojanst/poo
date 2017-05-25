<?php
function save_voucher($voucher_no, $voucher_amount, $customer_name, $address, $phone_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO gift_voucher (id, voucher_no, voucher_amount, customer_name, address, phone_no)
	VALUES ('', '$voucher_no', '$voucher_amount', '$customer_name', '$address', '$phone_no')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}



function list_voucher(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>

                           <th>Edit</th>
						     <th>Voucher No</th>
                           <th>Voucher Amount</th>
							<th>Customer Name</th>
                            <th>Phone No</th>
							<th>Address</th>
							
						

                       </tr>
                  </thead>
                  <tbody>';



	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM gift_voucher WHERE cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo '
		<td><a href="gift_voucher.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-pencil-square-o fa-2x"></i></a></td>

		<td>'.$row[voucher_no].'</td>
		<td>'.$row[voucher_amount].'</td>
		<td>'.$row[customer_name].'</td>
        <td>'.$row[phone_no].'</td>
		<td>'.$row[address].'</td>

		<td><a href="gift_voucher.php?job=delete&id='.$row[id].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>

		</tr>';

		$i++;

	}

	echo '</tbody>
          </table>
          </div>';


}



function cancel_vocher($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE gift_voucher SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query($conn, $query);



}

function update_voucher($id, $voucher_no, $voucher_amount, $customer_name, $address, $phone_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn_for_changing_db, $dbname);
	$query = "UPDATE gift_voucher SET

	voucher_no='$voucher_no',
	voucher_amount='$voucher_amount',
    customer_name='$customer_name',
    address='$address',
	phone_no='$phone_no'

	WHERE id='$id'";

	mysqli_query ($conn, $query );


}


function get_voucher_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ( $conn, "SELECT * FROM gift_voucher WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}

