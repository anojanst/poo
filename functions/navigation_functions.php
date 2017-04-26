<?php
function list_notification(){
    include 'conf/config.php';
    include 'conf/opendb.php';
    $count=get_notification_count();

    echo '<li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-danger">'.$count.'</span>
            </a>
            <ul class="dropdown-menu">
            <li>
            	<ul class="menu">   		';

    $result = mysqli_query($conn, "SELECT * FROM notification WHERE cancel_status='0' AND seen_status='0' LIMIT 5");
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '
            <!-- inner menu: contains the actual data -->
                    <li>
                        <a  href="notification.php?job=view_not&product_id='.$row[product_id].'&branch='.$row[branch].'&id='.$row[id].'">
                        	<strong>' . $row[product_name] . '</strong>';
        			if($_SESSION['branch']=='HEAD OFFICE'){
                        	echo'<br>' . $row[branch] . ' <br>';
        			}
        			else{}
                          	echo'<i class="fa fa-warning text-yellow"></i> stock is '.$row[stock].' its time to reoder    		
                        </a>
                    </li>';
    }
            echo'
            	</ul>
            </li>		
                <li class="footer"><a href="notification.php?job=notifications">View all</a></li>
                </ul>
        </li>';


}

function get_notification_count(){
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query($conn, "SELECT COUNT(seen_status) AS unseen FROM notification WHERE seen_status='0'");
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        return $row[unseen];

    }
}