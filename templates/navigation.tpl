<body class="sidebar-mini skin-purple sidebar-collapse">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b>BD</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Poobalasingham</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                
            </div>
            <div class="navbar-custom-menu" style="margin-right: 100px;">
                <ul class="nav navbar-nav">
                   <li class="user-footer">  
                    <!-- Notifications: style can be found in dropdown.less -->
                    {php}list_notification();{/php}
                    <!-- Tasks: style can be found in dropdown.less -->
                   </li>
                
                </ul>
              <ul class="nav navbar-nav">
                     <li class="user-footer">               
                    
                      <a href="login.php?job=logout" ><i class="fa fa-sign-out"></i></a>
                  
                </li>
                </ul>
            </div>
        </nav>
    </header>
               
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->

            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat" style="width: 40px"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-database"></i> <span>Database</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-tasks"></i> <span>Inventory</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href="inventory.php"><i class="fa fa-eye"></i> View Inventory</a></li>
                                <li><a href="inventory.php?job=add_new"><i class="fa fa-plus-square-o"></i> Add To Inventory </a></li>
                                <li><a href="multiple_stock.php"><i class="fa fa-database"></i> Stock </a></li>
                           </ul>
                        </li>
                        <li><a href='author.php'><i class="fa fa-male"></i>Author</a></li>
                        <li><a href='publication.php'><i class="fa fa-newspaper-o"></i>Publication</a></li>
                        <li><a href='label.php'><i class="fa fa-tag"></i>Label</a></li>
                    </ul>
                </li>
                <li><a href="transfer.php?job=must_new"><i class="fa fa-file"></i><span>Transfer</span></a></li>


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-bag fa-rotate-90"></i> <span>Sales</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href='sales.php?job=must_new'><i class="fa fa-shopping-bag fa-rotate-90"></i> Sales</a></li>
                                <li><a href='return.php'><i class="fa fa-shopping-bag fa-rotate-270"></i>Return Sales </a></li>
                            </ul>
                        </li>
                 
                   
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i> <span>Purcharse</span>
                                <span class="pull-right-container"> 
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview">
                                    <a href="#">
                                        <i class="fa fa-shopping-cart"></i> <span>Purcharse</span>
                                        <span class="pull-right-container"> 
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="active"><a href='purchase_order.php'><i class="fa fa-eye"></i> View</a></li>
                                        <li><a href='purchase_order.php'><i class="fa fa-plus-square-o"></i>Add </a></li>
                                        <li><a href='confirm.php'><i class="fa fa-circle-o"></i>Confirm</a></li>
                                    </ul>
                                </li>
                                <li><a href='return_purchase_order.php'><i class="fa fa-shopping-cart fa-flip-horizontal"></i>Return Purchase</a></li>
                            </ul>
                        </li>
                 
                    
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-credit-card"></i> <span>Payment</span>
                                <span class="pull-right-container"> 
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href='purchase_order_payment.php'> <i class="fa fa-shopping-cart"></i>Purchase</a></li>
                                <li><a href='return_purchase_order_payment.php'><i class="fa fa-shopping-cart fa-flip-horizontal"></i> Return Purchase</a></li>
                                <li><a href='sales_payment.php'><i class="fa fa-shopping-bag fa-rotate-90"></i>Sales</a></li>
                                <li><a href='return_sales_payment.php'><i class="fa fa-shopping-bag fa-rotate-270"></i>Return Sales</a></li>
                                <li><a href='other_expenses.php'><i class="fa fa-money"></i>Other Expenses</a></li>
                                <li><a href='other_incomes.php'><i class="fa fa-usd"></i>Other Incomes</a></li>
                            </ul>
                        </li>
               

                <li><a href="notification.php?job=notifications"><i class="fa fa-bell-o"></i><span>Notifications</span></a></li>
				<li><a href="quotation.php?job=quotation_page"><i class="fa fa-clone"></i><span>Quoatation</span></a></li>

			
            
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i> <span>Reports</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-area-chart"></i> <span>Reports About Inventory</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href="inv_basic_report.php"><i class="fa fa-files-o"></i> Report Summary</a></li>
                                <li><a href="inv_full_report.php"><i class="fa fa-file-code-o"></i> Detailed Report</a></li>
                          </ul>
                        </li>
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-area-chart"></i> <span>Reports About Sales</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href="sales_basic_report.php"><i class="fa fa-files-o"></i> Report Summary</a></li>
                                <li><a href="sales_basic_report.php?job=today_sales_report"><i class="fa fa-file-code-o"></i> Today Sales Report</a></li>
                          </ul>
                        </li>
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-area-chart"></i> <span>Reports About Transfer</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href="transfer.php?job=to_store"><i class="fa fa-files-o"></i> Transfer Out Store</a></li>
                                <li><a href="transfer.php?job=from_store"><i class="fa fa-file-code-o"></i> Transfer In Store</a></li>
                          </ul>
                        </li>
                        
                    </ul>
                </li>
               
               <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Settings</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    
                        <ul class="treeview-menu">
                                <li class="active"><a href="modules.php"><i class="fa fa-files-o"></i> Modules</a></li>
                                 <li class="active"><a href="detail.php"><i class="fa fa-files-o"></i> User Settings</a></li>
                                     <li class="active"><a href="employees.php"><i class="fa fa-files-o"></i> Employees</a></li>
                      
                         </ul>
                       
                </li>
               <li><a href="gift_voucher.php?job=gift_voucher"> <i class="fa fa-gift"></i> <span>Gift Voucher</span></a></li>
                <li><a href="#"> <i class="fa fa-book"></i> <span>Accounts</span></a></li>
                

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">