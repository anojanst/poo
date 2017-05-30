<?php
function save_items($product_id,$product_name,$quantity,$location){
    include 'conf/config.php';
    include 'conf/opendb.php';
	
    $branch=$_SESSION['branch'];
    $reorder= $quantity*0.1;

    mysqli_select_db($conn, $dbname);
    $query = "INSERT INTO multiple_stock_has_inventory (id,product_id, product_name, branch,stock,reorder,location) 
    VALUES ('','$product_id','$product_name', '$branch','$quantity','$reorder','$location')";

    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}
function select_branch(){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT * FROM branch ");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        echo'   <option value="'.$row[branch_name].'">'.$row[branch_name].'</option>';
    }
    include 'conf/closedb.php';

}
function save_multiple_stock($product_id,$product_name,$branch,$stock,$reorder,$location){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $info=get_info_mutiple_stock_by_branch($product_name,$branch);

    if($info) {

        $user_name = $_SESSION['user_name'];
        $query = "UPDATE multiple_stock_has_inventory SET
        product_id='$product_id',
        stock='$stock', 
        reorder='$reorder', 
        created_by='$user_name', 
        location='$location' 
        WHERE product_name='$product_name' AND branch='$_SESSION[branch]'";
    }
    else{

        $query = "INSERT INTO multiple_stock_has_inventory (id,product_id,product_name,branch,stock,reorder,location)
    	VALUES ('','$product_id','$product_name','$_SESSION[branch]', '$stock','$reorder','$location')";
    }

    mysqli_query ($conn, $query)or die ( mysqli_connect_error () );
}

function get_multiple_stock_id(){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result=mysqli_query($conn, "SELECT MAX(id) FROM multiple_stock_has_inventory ");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {

        $no=$row['MAX(id)']+1;
        $no = str_pad($no, 5, "0", STR_PAD_LEFT);
        return "PBD-$no";
    }
    include 'conf/closedb.php';
}
function get_multiple_stock_by_id($id) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE id='$id'" );

    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

    {
        return $row;
    }

}
function cancel_multiple_stock($id) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE multiple_stock_has_inventory SET 
  cancel_status='1' 
  WHERE id='$id'";

    mysqli_query ($conn, $query );
}
function  update_multiple_stock($id,$product_name,$branch,$stock,$reorder,$location) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE multiple_stock_has_inventory SET 
    product_name='$product_name', 
  branch='$branch', 
  stock='$stock', 
  reorder='$reorder', 
    location='$location' 
  WHERE id='$id'";

    mysqli_query ($conn, $query );

}
function list_multiple_stock() {
    include 'conf/config.php';
    include 'conf/opendb.php';
    
    echo '<div class="box-body"> 
      <table id="example1" class="table table-bordered table-striped"> 
                  <thead> 
                       <tr> 
                           <th>Product Name</th> 
                           <th>Branch</th> 
                           <th>Reorder</th> 
                           <th>Stock</th> 
                           <th>Location</th> 
                       </tr> 
                  </thead> 
                  <tbody valign="top">';
    $i = 1;
    if($_SESSION['branch']=='HEAD OFFICE') {
        $result = mysqli_query($conn, "SELECT * FROM multiple_stock_has_inventory WHERE cancel_status='0' LIMIT 50 ");
    }
    else{
        $result = mysqli_query($conn, "SELECT * FROM multiple_stock_has_inventory WHERE cancel_status='0' AND branch='$_SESSION[branch]' LIMIT 50 ");
    }
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

        echo ' 
        <tr> 
            <td>' . $row [product_name] . '</td> 
            <td>' . $row [branch] . '</td> 
            <td>' . $row [reorder] . '</td> 
            <td>' . $row [stock] . '</td> 
            <td>' . $row [location] . '</td> 
    </tr>';
        $i ++;
    }

    echo '</tbody> 
          </table> 
          </div>';


}
function get_multiple_stock_by_name($product_name,$branch) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE product_name='$product_name' AND branch='$branch'" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )
    {
        return $row;
    }
}

function get_multiple_stock_by_product_id($product_id) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE product_id='$product_id'" );

    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

    {
        return $row;
    }


}
function get_info_mutiple_stock_by_branch($product_name,$branch) {
    include 'conf/config.php';
    include 'conf/opendb.php';
   $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE branch='$branch'AND product_name='$product_name'" );

    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

    {
        return $row;
    }
}

function get_info_mutiple_stock_by_product_id_branch($product_id,$branch) {
    include 'conf/config.php';
    include 'conf/opendb.php';
   $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE branch='$branch'AND product_id='$product_id' AND  cancel_status='0' " );

    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

    {
        return $row;
    }
}


function save_purchase_confirm_items($product_id,$product_name,$branch,$quantity,$locatio){
    include 'conf/config.php';
    include 'conf/opendb.php';
	
   // $branch=$_SESSION['branch'];
    $reorder= $quantity*0.1;

    mysqli_select_db($conn, $dbname);
    $query = "INSERT INTO multiple_stock_has_inventory (id,product_id, product_name, branch,stock,reorder,location) 
    VALUES ('','$product_id','$product_name', '$branch','$quantity','$reorder','$location')";

    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}


function update_quantity($product_id,$product_name){
	include 'conf/config.php';
    include 'conf/opendb.php';
	
	$branch = $_SESSION['branch'];
	$info=get_info_mutiple_stock_by_branch($product_name,$branch);
	$quantity = $info['stock']+1;
	
	echo "UPDATE multiple_stock_has_inventory SET
	quantity='$quantity'
	WHERE product_id='$product_id' AND branch='$branch'";
    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE multiple_stock_has_inventory SET
	stock='$quantity'
	WHERE product_id='$product_id' AND branch='$branch'";

    mysqli_query ($conn, $query );

}
	
	
	function update_purchase_quantity($product_id,$branch, $new_quantity){
	include 'conf/config.php';
    include 'conf/opendb.php';
	
	
    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE multiple_stock_has_inventory SET
	stock='$new_quantity'
	WHERE product_id='$product_id' AND branch='$branch'";

    mysqli_query ($conn, $query );

}


