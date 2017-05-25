{include file="user_header.tpl"}
{include file="home_header.tpl"}
{include file="navigation.tpl"}
	<div id="contents">
		{if $error_report=='on'}
		<div class="error_report" style="margin-top: 10px;">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div id="contents">
				<div class="user_home" >
					<div id="navigation_user">
						<div class="row" style="padding-right: 70px;">

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="detail.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">User Settings</span>
              							<span class="info-box-text">Customize your </br> details</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="inventory.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-red"><i class="fa fa-shopping-basket"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Inventory</span>
              							<span class="info-box-text">Manage your </br> stock</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

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
            						<span class="info-box-icon bg-BlueViolet"><i class="fa fa-credit-card-alt"></i></span>

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
								<a href="reciept.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-green"><i class="fa fa-university"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Bank</span>
              							<span class="info-box-text">Bank </br>Reconcilation</span>
            						</div>
           	 						<!-- /.info-box-content -->
          						</div>
          						<!-- /.info-box -->
								</a>
        					</div>

							<div class="col-md-3 col-sm-6 col-xs-12">
								<a href="gift.php" class="title">
          						<div class="info-box">
            						<span class="info-box-icon bg-yellow"><i class="fa fa-gift"></i></span>

            						<div class="info-box-content">
              							<span class="info-box-number">Gift</span>
              							<span class="info-box-text">Gift Voucher</br> Management</span>
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
	</div>
{include file="user_footer.tpl"}