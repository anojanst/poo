{include file="header.tpl"}
{include file="navigation.tpl"}
<div class="side_bar"></div>
<div class="notice" style="position: absolute; top: 450px;"><b>{$notice}</b></div>
<div class="admin_regi_form" style="height: 200px">
<form name="activate_form" action="register.php?job=activate" method="post">

<table style="position: absolute; left: 375px; top: 300px;">

<tr>
<th>E-mail</th>
<td> : <input type="text" name="email" id="email" value="{$email}" required /></td>
</tr>

<tr>
<th>Activation Code</th>
<td> : <input type="text" name="activation_code" id="activation_code" value="{$activation_code}" required /></td>
</tr>


<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>
<input type="submit" name="ok" value="Activate My Account." />
</td>
</tr>

</table>


</form>
</div>

<div style="position: absolute; top: 640px; width: 100%; text-align: center; font-size: 13px; padding-bottom: 10px;">
{include file="footer.tpl"}