{include file="login_header.tpl"}
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Poobalasingam</b>Book Depot</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">LOGIN</p>

    <form action="login.php?job=login" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" value="{$user_name}" placeholder="Username" name="user_name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" value="{$password}" placeholder="Password" name="password">
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