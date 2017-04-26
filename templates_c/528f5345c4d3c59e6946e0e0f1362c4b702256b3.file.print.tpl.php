<?php /* Smarty version Smarty-3.0.8, created on 2017-04-25 08:46:57
         compiled from "./templates/sales/print.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26016060358fef0e1cb1483-34960529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '528f5345c4d3c59e6946e0e0f1362c4b702256b3' => 
    array (
      0 => './templates/sales/print.tpl',
      1 => 1492759498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26016060358fef0e1cb1483-34960529',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/opt/lampp/htdocs/xampp/poo/libs/plugins/block.php.php';
?><?php $_template = new Smarty_Internal_Template("print_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("home_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div class="row" style="width: 6.4cm;  margin-top: -10px;">
    <div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <img  style="margin-left: 60px;" src="images/logo.png" width="100" height="100"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h3 style="font-size: 20px; margin-left: 20px; margin-top: -10px;"><strong>POOBALASINGAM</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="margin-top: -10px;">
            <strong style="margin-left: 60px; ">Book Depot</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <strong>---------------------------------------------------</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
print_sales_item($_SESSION[print_no]);<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <strong >Sales No : </strong><?php echo $_smarty_tpl->getVariable('sales')->value;?>

        </div>
        <div class="col-xs-6">
            <strong style="text-align: right; margin-left: -27px;">Date : </strong><?php echo $_smarty_tpl->getVariable('date')->value;?>

        </div>
    </div>
    
    <h4 style="text-align: center;">Thank You.Come Again!</h4>
    </div>    
</div>
<div>
<a href="sales.php" class="no-print btn btn-success">New Sales</a>
</div>