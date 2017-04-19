<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
</head>
<div class="input-group date">
  <input type="text" class="form-control pull-right" id="datepicker" placeholder="Date">
</div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<script>
  $(function () {
    
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>
</body>
</html>
