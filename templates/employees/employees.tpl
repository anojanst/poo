{include file="home_header.tpl"}
{include file="navigation.tpl"}
<style>
#popupbox_employee{
	margin: 0; 
	margin-left: 30%;
	margin-top: -25px; 
	padding-top: 10px; 
	padding-left: 10px;
	width: 525px; 
	height: 620px; 
	position: fixed; 
	background: #FBFBF0; 
	border-radius: 1px;
	box-shadow: 0px 0px 0px 8px rgba(0,0,0,0.3); 
	z-index: 9; 
	font-family: arial; 
	visibility: hidden; 
}
</style>
{literal}
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>	
<script language="JavaScript" type="text/javascript">
  function employee(showhide){
    if(showhide == "show"){
        document.getElementById('popupbox_employee').style.visibility="visible";
    }else if(showhide == "hide"){
        document.getElementById('popupbox_employee').style.visibility="hidden"; 
    }
  }
</script>
<script>
$(function () {
  $("#example1").DataTable(); 
});
</script>
{/literal}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">															
            <div class="row">
                <form action="employees.php?job=search" method="post" class="search">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4" style="padding-left: 170px; margin-top: -10px; ">
                        <h5 width="80">Add New Employee
                            <a href="employees.php?job=add_new">
                                <img alt="add" src="./images/add.png">
                            </a>
                        </h5>&nbsp;
                    </div>
                    <div class="col-lg-3" style="margin-left: -20px;">
                        <input type="text" class='auto form-control' name="search" value="{$search}" size="27" placeholder="Search"/> 
                    </div>	
                    <div class="col-lg-1" style="margin-left: -10px;">	
                        <input type="image" src="./images/search.png" height="28" width="28"/>
                    </div>		
                </form>					
            </div>
            <div class="row">
                {php}list_employees();{/php}
            </div>
		</div>
	</div>
</section>

{include file="js_footer.tpl"}