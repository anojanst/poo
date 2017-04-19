<?php /* Smarty version Smarty-3.0.8, created on 2017-04-19 05:38:38
         compiled from "./templates/user_home/user_home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18318918258f6dbbeef6d61-18067275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bcad81bef12e712af583b7b24b1d62d9faf7ae6' => 
    array (
      0 => './templates/user_home/user_home.tpl',
      1 => 1479253972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18318918258f6dbbeef6d61-18067275',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("home_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("navigation.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div id="contents">
				<div class="user_home">
					<div id="navigation_user">
						<div class="row" >
							<div class="col-lg-3">
								<a href="detail.php" class="title">
									<img src="./images/settings.png"/>
									<p class="home_icon">User Settings</p>
									<p class="home_icon_detail">Customize your</p>
									<p class="home_icon_detail">details</p>
								</a>
							</div>
							<div class="col-lg-3">
								<a href="inventory.php" class="title">
									<img src="./images/cabin.png"/>
									<p class="home_icon">Inventory</p>
									<p class="home_icon_detail">Manage your stock</p>
								</a>
							</div>
							<div class="col-lg-3">
								<a href="sales.php" class="title">
									<img src="./images/sales.png" width="48" height="48"/>
									<p class="home_icon">Sales</p>
									<p class="home_icon_detail"  style="width: 150px;">Manage sales & return</p> 	
								</a>
							</div>
							<div class="col-lg-3">
								<a href="purchase_order.php" class="title">
									<img src="./images/purchase.png" width="48" height="48"/>
									<p class="home_icon">Purchase Orders</p>
									<p class="home_icon_detail" style="width: 150px;">Manage your purchases</p>
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<a href="payment.php" class="title">
									<img src="./images/pay.png" width="48" height="48"/>
									<p class="home_icon">Payments</p>
									<p class="home_icon_detail">Receive & make</p>
									<p class="home_icon_detail">payments</p>
								</a>
							</div>
							<div class="col-lg-3">
								<a href="confirm.php" class="title">
									<img src="./images/stamp.png" width="48" height="48"/>
									<p class="home_icon">Confirms</p>
									<p class="home_icon_detail">Confirm Purchases</p>									
								</a>
							</div>
							<div class="col-lg-3">
									<a href="reports.php" class="title">
											<img src="./images/chart.png" width="48" height="48"/>
											<p class="home_icon">Reports</p>
											<p class="home_icon_detail"  style="width: 150px;">Generate & view report</p>
									</a>
							</div>
							<div class="col-lg-3">				
								<a href="chart_of_accounts.php" class="title">										
									<img src="./images/man.png"/>
									<p class="home_icon">Chart of Accounts</p>
									<p class="home_icon_detail"  style="width: 150px;">Manage your accounts</p>										
                                </a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">								
								<a href="employees.php" class="title">								
									<img src="./images/supplier.png" width="48" height="48"/>
									<p class="home_icon">Employees</p>
									<p class="home_icon_detail">Employees Details</p>								
								</a>
							</div>
							<div class="col-lg-3">				
								<a href="reciept.php" class="title">								
									<img src="./images/bank.png" width="48" height="48"/>
									<p class="home_icon">Bank</p>
									<p class="home_icon_detail">Bank Reconcilation</p>
								</a>
							</div>
							<div class="col-lg-3">								
								<a href="gift.php" class="title">								
									<img src="./images/gift.png" width="48" height="48"/>
									<p class="home_icon">Gift</p>
									<p class="home_icon_detail">Gift Voucher</p>
									<p class="home_icon_detail">Management.</p>
								</a>
							</div>
							<div class="col-lg-3">								
								<a href="./login.php?job=logout" class="title">								
									<img src="./images/logout.png" width="48" height="45"/>
									<p class="home_icon">logout</p>
								</a>
							</div>							
						</div
					</div>
				</div>
			</div>
		</div>
	</div>		
</section>
<?php $_template = new Smarty_Internal_Template("js_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
