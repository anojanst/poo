{include file="home_header.tpl"}
{include file="navigation.tpl"}

<section class="content">	
    {if $error_report=='on'}
    <div class="error_report">
        <strong>{$error_message}</strong>
    </div>
    {/if}
    {if $warning_report=='on'}
    <div class="warning_report" style="margin-bottom: 50px;">
        <strong>{$warning_message}</strong>
    </div>
    {/if}
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="row">
                <div class="col-lg-12" align="center">
                    <h2><strong>Employee Details </strong></h2>

                </div>
                <form role="form" action="employees.php?job=add" method="post" class="product" enctype="multipart/form-data">		
                    <div class="row" style="margin-bottom: 10px; margin-left: 20px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">
                                Employee Name:
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="employee_name"  value="{$employee_name}" placeholder="Employee Name">
                            </div>                                
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">
                              Full Name:
                            </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="full_name" value="{$full_name}"  placeholder="Full name">
                            </div>                                
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Department : </div>
  
                            <div class="col-lg-6">
                                <select class="form-control" name="department" value="{$department}" required>
                                    <option value="" disable selected>Department</option>
                                    <option value="management">Management</option>
                                    <option value="reception">Reception</option>
                                    <option value="sales">Sales</option>
                                </select>
                            </div>                                
                        </div>
                        
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Branch : </div>
  
                            <div class="col-lg-6">
                                <select class="form-control" name="branch" value="{$branch}" required>
                                    <option value="" disable selected>Branch</option>
                                    <option value="HEAD OFFICE">HEAD OFFICE</option>
                                    <option value="STORE">STORE</option>
                                    <option value="WELLAWATTA">WELLAWATTA</option>
                                </select>
                            </div>                                
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Email : </div>
    
                            <div class="col-lg-6">
                                <input class="form-control" name="email" value="{$email}"  placeholder="Email">
                            </div>                                
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Telephone : </div>
    
                            <div class="col-lg-6">
                                <input class="form-control" name="telephone" value="{$telephone}"  placeholder="Telephone">
                            </div>                                
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Mobile : </div>
                            <div class="col-lg-6">
                                <input class="form-control" name="mobile" value="{$mobile}"  placeholder="mobile">
                            </div>                                
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Address : </div>
                            <div class="col-lg-6">								
                                <textarea class="form-control" name="address" value=""  placeholder="address"> {$address}</textarea>
                            </div>                                
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">System User</div>
  
                            <div class="col-lg-6">								
                                <input type="checkbox" name="user" value="1" {$user}>Yes
                            </div>                                
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Username : </div>
  
                            <div class="col-lg-6">								
                                <input class="form-control" name="user_name" value="{$user_name}"  placeholder="User Name">
                            </div>                                
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-3">Password : </div>

                            <div class="col-lg-6">									
                              <input type="password" class="form-control" name="password" required="required" placeholder="Password">
                            </div>                                
                        </div>

                        <div class="row" style="margin-left: 20px;">
                            <div class="col-lg-2">
                            {if $edit_mode=='on'}
                               <button type="submit" name="ok" value="Update" class="btn btn-block btn-success btn-lg">Update</button>
                           {else}
                               <button type="submit" name="ok" value="Save" class="btn btn-block btn-success btn-lg">Save</button>
                           </div>
                           <div class="col-lg-2">
                           {/if}
                               <button type="reset" class="btn btn-block btn-danger btn-lg">Reset</button>
                           </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
	
{include file="js_footer.tpl"}
{literal}
<script>
       $(document).on('ready', function() {
           $("#gallery").fileinput({
               showUpload: false,
                   maxFileCount: 10,
                   mainClass: "input-group-lg"
               });
           });
</script>
			 
<script>
       $(document).on('ready', function() {
           $("#input-1").fileinput({
               showUpload: false,
                   maxFileCount: 1,
                   mainClass: "input-group-lg"
               });
           });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
	
  });
</script>
<script>
  $(function () {
    
    $('#datepicker1').datepicker({
	 format: 'yyyy-mm-dd',
      autoclose: true
    });
 });
</script>
{/literal}