{include file="home_header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">
			<div style="min-height: 300px;">
				<p style="margin-top: 10px; font-size: 20px; font-weight: bold; margin-bottom: 1px; padding-left: 390px; ">Reports</p><br>
				<table width="900" style="border: 0px;">
					<tr>
						<td colspan="4" class="report_th">Reports About Inventory.</td>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="inv_basic_report.php" class="report_select">Report Summary</a></td>
						<td width="225"><a href="inv_full_report.php" class="report_select">Detailed Report</a></td>
						<td width="225"></td>
					</tr>
					<tr>
						<th colspan="4" class="report_th">Reports About Suppliers.</th>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="index.php" class="report_select">Report Summary</a></td>
						<td width="225"><a href="index.php" class="report_select">Detailed Report</a></td>
						<td width="225"></td>
					</tr>
					<tr>
						<th colspan="4" class="report_th">Reports About Customers.</th>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="index.php" class="report_select">Report Summary</a></td>
						<td width="225"><a href="index.php" class="report_select">Detailed Report</a></td>
						<td width="225"></td>
					</tr>
					<tr>
						<th colspan="4" class="report_th"><br />Reports About Purchase Order.</th>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="index.php" class="report_select">Report Summary</a></td>
						<td width="225"><a href="index.php" class="report_select">Detailed Report</a></td>
						<td width="225"></td>
					</tr>
					<tr>
						<th colspan="4" class="report_th">Reports About Sales.</th>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="sales_basic_report.php" class="report_select">Report Summary</a></td>
						<td width="225"><a href="sales_full_report.php" class="report_select">Detailed Report</a></td>
						<td width="225"></td>
					</tr>
					
					<tr>
						<th colspan="4" class="report_th">Reports About Transfer.</th>
					</tr>
					<tr>
						<td width="225"></td>
						<td width="225"><a href="transfer.php?job=to_store" class="report_select">Transfer To Store</a></td>
						<td width="225"><a href="transfer.php?job=from_store" class="report_select">Transfer From Store</a></td>
						<td width="225"></td>
					</tr>
				</table>					
			</div>
		</div>
	</div>
</section>
{include file="js_footer.tpl"}