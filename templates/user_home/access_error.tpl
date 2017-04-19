{include file="user_header.tpl"}
{include file="home_header.tpl"}
{include file="navigation.tpl"}
	<div id="contents">
		{if $error_report=='on'}
		<div class="error_report" style="margin-top: 10px;">
			<strong>{$error_message}</strong>
		</div>
		{/if}
		<div class="user_home">
			<div>
			<ul id="navigation_user">
				<li>
					<a href="detail.php" class="title">
						<div>
							<img src="./images/settings.png" width="48" height="48"/>
							<p class="home_icon">User Settings</p>
							<p class="home_icon_detail">Customize your details</p>
						</div>
					</a>
				</li>
				<li>
					<a href="inventory.php" class="title">
						<div>
							<img src="./images/cabin.png"/>
							<p class="home_icon">Inventory</p>
							<p class="home_icon_detail">Manage your stock</p>
						</div>
					</a>
				</li>
				<li>
					<a href="sales.php" class="title">
						<div>
							<img src="./images/sales.png" width="48" height="48"/>
							<p class="home_icon">Sales</p>
							<p class="home_icon_detail">Manage sales & return</p>
						</div>
					</a>
				</li>
				<li>
					<a href="purchase_order.php" class="title">
						<div>
							<img src="./images/purchase.png" width="48" height="48"/>
							<p class="home_icon">Purchase Orders</p>
							<p class="home_icon_detail">Manage your puechases</p>
						</div>
					</a>
				</li>
				<li>
					<a href="payment.php" class="title">
						<div>
							<img src="./images/pay.png" width="48" height="48"/>
							<p class="home_icon">Payments</p>
							<p class="home_icon_detail">Receive & make payments</p>
						</div>
					</a>
				</li>
				<li>
					<a href="confirm.php" class="title">
						<div>
							<img src="./images/stamp.png" width="48" height="48"/>
							<p class="home_icon">Confirms</p>
							<p class="home_icon_detail">Confirm Purchases</p>
						</div>
					</a>
				</li>
				<li>
					<a href="reports.php" class="title">
						<div>
							<img src="./images/chart.png" width="48" height="48"/>
							<p class="home_icon">Reports</p>
							<p class="home_icon_detail">Generate & view report</p>
						</div>
					</a>
				</li>
				<li>
					<a href="chart_of_accounts.php" class="title">
						<div>
							<img src="./images/man.png"/>
							<p class="home_icon">Chart of Accounts</p>
							<p class="home_icon_detail">Manage your accounts</p>
						</div>
					</a>
				</li>				
				<li>
					<a href="employees.php" class="title">
						<div>
							<img src="./images/supplier.png" width="48" height="48"/>
							<p class="home_icon">Employees</p>
							<p class="home_icon_detail">Employees Details</p>
						</div>
					</a>
				</li>
				<li>
					<a href="reciept.php" class="title">
						<div>
							<img src="./images/bank.png" width="48" height="48"/>
							<p class="home_icon">Bank</p>
							<p class="home_icon_detail">Bank Reconcilation</p>
						</div>
					</a>
				</li>
				
				<li>
					<a href="./login.php?job=logout" class="title">
						<div>
							<img src="./images/logout.png" width="48" height="45"/>
							<p class="home_icon">logout</p>
						</div>
					</a>
				</li>
			</ul>
			</div>
		</div>
	</div>
{include file="user_footer.tpl"}