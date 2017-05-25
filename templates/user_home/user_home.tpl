{include file="home_header.tpl"}
{include file="navigation.tpl"}

<section class="content" style="margin-bottom: -30px;">
	<div class="row">

		<!-- /.col -->

		<div class="col-md-6">
			<!-- USERS LIST -->
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Inventory</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<ul class="users-list clearfix">
						<li>
							<a class="users-list-name" href="inventory.php">
								<img src="dist/img/view.png" alt="User Image">
								<a class="users-list-name" href="inventory.php">View</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="inventory.php?job=add_new">
								<img src="dist/img/Add.png" alt="User Image">
								<a class="users-list-name" href="inventory.php?job=add_new">Add</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="multiple_stock.php">
								<img src="dist/img/abc.png" alt="User Image">
								<a class="users-list-name" href="multiple_stock.php">Stock</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="transfer.php">
								<img src="dist/img/Transfer.png" alt="User Image">
								<a class="users-list-name" href="transfer.php">Transfer</a>
							</a>
						</li>
					</ul>
					<!-- /.users-list -->
				</div>

			</div>
			<!--/.box -->
		</div>
		<!-- /.col -->

		<div class="col-md-6">
			<!-- USERS LIST -->
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Operations</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
					<ul class="users-list clearfix">
						<li>
							<a class="users-list-name" href="sales.php?job=must_new">
								<img src="dist/img/report-512.png" alt="User Image">
								<a class="users-list-name" href="sales.php?job=must_new">Sales</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="return.php">
								<img src="dist/img/r_sa.png" alt="User Image">
								<a class="users-list-name" href="return.php">Return Sales</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="purchase_order.php">
								<img src="dist/img/61452-200.png" alt="User Image">
								<a class="users-list-name" href="purchase_order.php">Purcharse</a>
							</a>
						</li>
						<li>
							<a class="users-list-name" href="quotation.php?job=quotation_page">
								<img src="dist/img/qua.png" alt="User Image">
								<a class="users-list-name" href="quotation.php?job=quotation_page">Quoatation</a>
							</a>
						</li>
					</ul>
					<!-- /.users-list -->
				</div>

			</div>
			<!--/.box -->
		</div>
	</div>
</section>

<section class="content" xmlns="http://www.w3.org/1999/html">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div id="contents">
				<div class="user_home">
					<div id="navigation_user">
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="sales.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Sales</span>
              							<span class="info-box-text">Manage sales </br>& return</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="purchase_order.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-yellow"><i class="fa fa-area-chart"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Purchase Orders</span>
              							<span class="info-box-text">Manage your</br> purchases</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

<!----- fin first line -->

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="payment.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-navy"><i class="fa fa-money"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Payments</span>
              							<span class="info-box-text">Receive & make</br> payments</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="confirm.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-lime"><i class="fa fa-check-square-o"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Confirms</span>
              							<span class="info-box-text">Confirm  </br> Purchases</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="reports.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-Gray"><i class="fa fa-file-word-o"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Reports</span>
              							<span class="info-box-text">Generate &  </br>view report</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="chart_of_accounts.php" class="title">	
          						<div class="info-box">
            						<span class="info-box-icon bg-navy"><i class="fa fa-credit-card-alt"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Chart of Accounts</span>
              							<span class="info-box-text">Manage your</br> accounts</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>
<!-- ---------- fin 2nd line --------------->
							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="employees.php" class="title">	
          						<div class="info-box">
            						<span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Employees</span>
              							<span class="info-box-text">Employees  </br> Details</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="./login.php?job=logout" class="title">	
          						<div class="info-box">
            						<span class="info-box-icon bg-red"><i class="fa fa-sign-out"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Logout</span>
              							
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>		
</section>
{include file="js_footer.tpl"}
