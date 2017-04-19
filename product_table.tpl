<!DOCTYPE html>
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
                                  {php}list_inventory();{/php}
                                  
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
