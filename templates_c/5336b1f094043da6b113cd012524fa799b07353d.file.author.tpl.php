<?php /* Smarty version Smarty-3.0.8, created on 2017-04-21 09:38:35
         compiled from "./templates/author/author.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27145166358f9b6fb942e85-51405913%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5336b1f094043da6b113cd012524fa799b07353d' => 
    array (
      0 => './templates/author/author.tpl',
      1 => 1492759496,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27145166358f9b6fb942e85-51405913',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/opt/lampp/htdocs/xampp/poo/libs/plugins/block.php.php';
?><!DOCTYPE html>
<?php $_template = new Smarty_Internal_Template("home_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("navigation.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script>
$(function () {
  $("#example1").DataTable();
 
});
</script>

<section class="content">
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<div class="tab-content">						
			<h3 style="margin-top: 10px; margin-bottom: 30px;">Author Details</h3>						
				<form action="author.php?job=save" method="post" class="product">
					<div class="row">
						<div class="col-lg-9">
							<input class="form-control" type="text" value="<?php echo $_smarty_tpl->getVariable('author')->value;?>
" name="author" placeholder="Author Name" autofocus="autofocus" required>
						</div>
						<div class="col-lg-3">
							<input class="form-control" type="text" value="<?php echo $_smarty_tpl->getVariable('author_id')->value;?>
" name="author_id" placeholder="Author ID" autofocus="autofocus" required>
						</div>
					</div><br>
					<div class="row">
						<div class="col-lg-12">
							<textarea class="form-control"  name="description" rows="2" placeholder="Description" /><?php echo $_smarty_tpl->getVariable('description')->value;?>
</textarea>																	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-11"></div>
						<div class="col-lg-1">
							<?php if ($_smarty_tpl->getVariable('edit_mode')->value=='on'){?>
							<input type="submit" name="ok" value="Update" />
							<?php }else{ ?>
							<input type="submit" name="ok" value="Save" />
							<?php }?>
						</div>
					</div>
				</form>		
					<div class="row">      							
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Edit</th>
										<th>Author ID</th>
										<th>Author Name</th>
										<th>Description</th>
										<th>Delete</th>             
									</tr>
								</thead>
								<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
list_author() ;<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

								<tfoot>
									<tr>
										<th>Edit</th>
										<th>Author ID</th>
										<th>Author Name</th>
										<th>Description</th>
										<th>Delete</th>
									</tr>
								</tfoot>
							</table>           
						</div>						            											
					</div>
		</div>
	</div>
</section>
<?php $_template = new Smarty_Internal_Template("js_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>