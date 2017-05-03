<body class="sidebar-mini skin-purple sidebar-collapse">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b>BD</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Poobalasingam</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                </ul>
            </div>
            <div class="navbar-custom-menu" style="margin-right: 100px;">
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less -->
                    {php}list_notification();{/php}
                    <!-- Tasks: style can be found in dropdown.less -->
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
                                <li><a href="multiple_stock.php"><i class="fa fa-database"></i> Multiple Stock </a></li>
                                 <li><a href="transfer.php"><i class="fa fa-database"></i> Add Transfer </a></li>
                            </ul>
                        </li>
                        <li><a href='author.php'><i class="fa fa-male"></i>Author</a></li>
                        <li><a href='publication.php'><i class="fa fa-newspaper-o"></i>Publication</a></li>
                        <li><a href='label.php'><i class="fa fa-tag"></i>Label</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder-open"></i> <span>Operations</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-shopping-bag fa-rotate-90"></i> <span>Sales</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="active"><a href='sales.php'><i class="fa fa-shopping-bag fa-rotate-90"></i> Sales</a></li>
                                <li><a href='return.php'><i class="fa fa-shopping-bag fa-rotate-270"></i>Return Sales </a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="treeview-menu">
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
                    </ul>
                    <ul class="treeview-menu">
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
                    </ul>
                </li>

                <li><a href="notification.php?job=notifications"><i class="fa fa-bell-o"></i><span>Notifications</span></a></li>
				<li><a href="quotation.php?job=quotation_page"><i class="fa fa-clone"></i><span>Quoatation</span></a></li>

                <li><a href="#"><i class="fa fa-file-text"></i><span>Reports</span></a></li>
                <li><a href="#"> <i class="fa fa-book"></i> <span>Accounts</span></a></li>
                <li>
                    <a href="login.php?job=logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">