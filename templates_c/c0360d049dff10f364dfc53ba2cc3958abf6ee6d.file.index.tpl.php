<?php /* Smarty version Smarty-3.0.8, created on 2017-04-25 03:15:04
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:144131958758fea318ab5e68-41634541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1492759496,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144131958758fea318ab5e68-41634541',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("login_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Poobalasingam</b>Book Depot</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">LOGIN</p>

    <form action="login.php?job=login" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" value="<?php echo $_smarty_tpl->getVariable('user_name')->value;?>
" placeholder="Username" name="user_name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" value="<?php echo $_smarty_tpl->getVariable('password')->value;?>
" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
             <a href="forget.php">I forgot my password</a><br>
             
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>