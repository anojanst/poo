{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<div class="tab-content">
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
				<div style="min-height: 300px;">

				<div>
	<div class="row">
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Seen<sup style="font-size: 20px"></sup></h3>

            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="notification.php?job=view_seen" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Unseen</h3>

            </div>
            <div class="icon">
              <i class="ion ion-eye"></i>
            </div>
            <a href="notification.php?job=view_unseen" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

				</div>

			
					<h3 style="margin-top: 30px; margin-bottom: 30px;"> All Notifications</h3>						

					{php}list_all_notifications();{/php}


				</div>
			</div>
		</div>
</section>

	{literal}
		<script>
			 $(function () {
				 $("#example1").DataTable();
			 });
		</script>
	{/literal}

{include file="js_footer.tpl"}

