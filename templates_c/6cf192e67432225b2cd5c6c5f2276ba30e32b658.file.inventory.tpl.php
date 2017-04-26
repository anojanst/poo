<?php /* Smarty version Smarty-3.0.8, created on 2017-04-21 09:30:33
         compiled from "./templates/inventory/inventory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:57488216458f9b51982fb65-61545435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6cf192e67432225b2cd5c6c5f2276ba30e32b658' => 
    array (
      0 => './templates/inventory/inventory.tpl',
      1 => 1492759497,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57488216458f9b51982fb65-61545435',
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
		<!-- Tabs within a box -->
		<div class="tab-content">
			<?php if ($_smarty_tpl->getVariable('error_report')->value=='on'){?>
				<div class="error_report">
					<strong><?php echo $_smarty_tpl->getVariable('error_message')->value;?>
</strong>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->getVariable('warning_report')->value=='on'){?>
				<div class="warning_report" style="margin-bottom: 50px;">
					<strong><?php echo $_smarty_tpl->getVariable('warning_message')->value;?>
</strong>
				</div>
			<?php }?>
				<div style="min-height: 300px;">			
					<h3 style="margin-top: 30px; margin-bottom: 30px;">Product Details</h3>						
					<?php $_template = new Smarty_Internal_Template("product_table.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>			
				</div>
			</div>
		</div>
</section>

<?php $_template = new Smarty_Internal_Template("js_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>