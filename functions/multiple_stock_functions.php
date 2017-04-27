<?php
function save_items($product_id,$product_name,$quantity){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $branch="store";
    $reorder= $quantity*0.1;
    mysqli_select_db ( $conn, $dbname );
    $query = "INSERT INTO multiple_stock_has_inventory (id,product_id, product_name, branch,stock,reorder) 
  VALUES ('','$product_id','$product_name', '$branch','$quantity','$reorder')";

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
function save_multiple_stock($product_name,$branch,$stock,$reorder,$location){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $user_name=$_SESSION['user_name'];
    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE multiple_stock_has_inventory SET 
  branch='$branch', 
  stock='$stock', 
  reorder='$reorder', 
  created_by='$user_name', 
    location='$location' 
  WHERE product_name='$product_name'";

    mysqli_query ($conn, $query );

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
      <table id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive"> 
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
    $result = mysqli_query ( $conn, "SELECT * FROM multiple_stock_has_inventory WHERE cancel_status='0' LIMIT 50 " );
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
function get_multiple_stock_by_name($product_name) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT * FROM multiple_stock_has_inventory WHERE product_name='$product_name'" );

    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) )

    {
        return $row;
    }


}