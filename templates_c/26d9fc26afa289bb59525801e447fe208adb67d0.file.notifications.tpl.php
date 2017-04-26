<?php /* Smarty version Smarty-3.0.8, created on 2017-04-25 05:21:11
         compiled from "./templates/notifications/notifications.tpl" */ ?>
<?php /*%%SmartyHeaderCode:196112353058fec0a7858271-58267639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26d9fc26afa289bb59525801e447fe208adb67d0' => 
    array (
      0 => './templates/notifications/notifications.tpl',
      1 => 1493090467,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '196112353058fec0a7858271-58267639',
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
					<h3 style="margin-top: 30px; margin-bottom: 30px;"> All Notifications</h3>						

					<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
list_all_notifications();<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>



				</div>
			</div>
		</div>
</section>

	
		<script>
			 $(function () {
				 $("#example1").DataTable();
			 });
		</script>
	

<?php $_template = new Smarty_Internal_Template("js_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

