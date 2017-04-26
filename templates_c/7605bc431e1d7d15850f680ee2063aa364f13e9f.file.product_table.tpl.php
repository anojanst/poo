<?php /* Smarty version Smarty-3.0.8, created on 2017-04-21 09:30:33
         compiled from "product_table.tpl" */ ?>
<?php /*%%SmartyHeaderCode:102358084858f9b519994314-88043257%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7605bc431e1d7d15850f680ee2063aa364f13e9f' => 
    array (
      0 => 'product_table.tpl',
      1 => 1492759499,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102358084858f9b519994314-88043257',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_block_php')) include '/opt/lampp/htdocs/xampp/poo/libs/plugins/block.php.php';
?><!DOCTYPE html>
<html> 
<head>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.css">
  <link rel="stylesheet" href="css/responsive.bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
       <div class="row">
            <div class="col-md-12"> 
                  <div class="box-header">
                    <h3 class="box-title">Data Table With Full Features</h3>
                  </div>
                  <div class="box-body"> 
                        <table id="example1" style="width: 100%;" class=" table-responsive table-bordered table-striped dt-responsive" cellspacing="0">
                              <thead>
                                  <tr style="height: 30px;">
                                    <th>Edit</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>S.Price</th>
                                    <th>B.Price</th>
                                    <th>P.Date</th>
                                    <th></th>
                                    <th></th>                  
                                  </tr>
                              </thead>
                                  <?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; smarty_block_php(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
list_inventory();<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_php(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                  
                                </table>           
                        </div>
                    </div>
              </div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/dataTables.responsive.min.js"></script>
<script src="js/responsive.bootstrap.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
     
  });
</script>
</body>

</html>
