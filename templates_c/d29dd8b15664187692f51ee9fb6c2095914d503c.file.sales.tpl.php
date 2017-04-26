<?php /* Smarty version Smarty-3.0.8, created on 2017-04-25 08:16:58
         compiled from "./templates/sales/sales.tpl" */ ?>
<?php /*%%SmartyHeaderCode:77181619958fee9da3c5576-72732265%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd29dd8b15664187692f51ee9fb6c2095914d503c' => 
    array (
      0 => './templates/sales/sales.tpl',
      1 => 1492759498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77181619958fee9da3c5576-72732265',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/opt/lampp/htdocs/xampp/poo/libs/plugins/block.php.php';
?><?php $_template = new Smarty_Internal_Template("home_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("navigation.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>


<script>
	$(document).ready(function() {
		$('input.product').typeahead({
			name: 'product',
			remote: 'ajax/query_inventory.php?query=%QUERY'
		});
	})
</script>

<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-12">
					<h3><strong>Sales</strong></h3>
				</div>
			</div>
            <div class="row">
				<?php if ($_smarty_tpl->getVariable('error_report')->value=='on'){?>
					<div class="error_report" style="margin-bottom: 50px;">
						<strong><?php echo $_smarty_tpl->getVariable('error_message')->value;?>
</strong>
					</div>
				<?php }?>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-4">
							<form action="sales.php?job=barcode" name="select_item_form" method="post" >
								<input type="text" class="form-control" name="barcode" placeholder="For Barcode" tabindex="1" autofocus onkeyup="this.form.submit()"/> 
							</form>
						</div>
						<div class="col-lg-4">
							<form action="sales.php?job=select" name="select_item_form" method="post">
								<input type="text" class="form-control product" name="selected_item" placeholder="Select Items"/>														
						</div>
						<div class="col-lg-4">
								<input type="submit" class="btn btn-primary" name="add" value="Add"/> &nbsp; &nbsp; &nbsp; &nbsp;
							</form>
								<a href="sales.php?job=must_new" class="btn btn-danger">New Sales</a>
						</div>							
					</div><br>
				<div class="row">
					<div class="col-lg-12">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Delete</th>
									<th>Product Name</th>
									<th>Price</th>
									<th>Quantity</th>
									<th>Discount (%)</th>		
									<th>Total</th>
									<th>Update</th>
								</tr>
							</thead>
							<tbody>
							<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
list_item_by_sales($_SESSION['sales_no']);<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 
		
							</tbody>
						</table>
					</div>
				</div>
			</div>
				<div class="col-lg-3">
					<form name="sales_form" action="sales.php?job=sales" method="post" class="product">
						<input type="text" class="form-control" name="sales_no" value="<?php echo $_smarty_tpl->getVariable('sales_no')->value;?>
" size="25" required readonly="readonly" placeholder="Sales No" tabindex="3"/>
						<input type="text" class="form-control" name="customer_name"size="25" placeholder="Customer" tabindex="4"/></td>
						<input type="text" class="form-control" name="customer_amount" value="<?php echo $_smarty_tpl->getVariable('customer_amount')->value;?>
" id="customer_amount" size="25" required placeholder="Customer Paying Amount" tabindex="5" onkeyup="calculateBalance()"/>
                        <input type="text" class="form-control" name="discount" value="<?php echo $_smarty_tpl->getVariable('discount')->value;?>
"  size="25" placeholder="Discount" tabindex="5"/>
						<input type="text" class="form-control" name="prepared_by" value="<?php echo $_smarty_tpl->getVariable('prepared_by')->value;?>
" size="25" required readonly="readonly"/>
						<?php if ($_smarty_tpl->getVariable('edit_mode')->value=='on'){?>
						<input type="text" class="form-control" name="updated_by" value="<?php echo $_smarty_tpl->getVariable('updated_by')->value;?>
" size="25" required readonly="readonly"/>
						<?php }?>
						<input type="text" class="form-control" name="total" id="total" value="<?php echo $_smarty_tpl->getVariable('total')->value;?>
" size="25"  placeholder="Total" tabindex="5" readonly="readonly"/>
						<div id="cus_amount"></div>
						<input class="btn btn-success" type="submit" name="ok" value="Finish the Bill & Print" tabindex="6" />					
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $_template = new Smarty_Internal_Template("js_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>