{include file="header.tpl"}
{include file="navigation.tpl"}
<div class="side_bar"></div>
<div class="notice" style="top: 350px;"><b>{$notice}</b></div>
<div class="notice" style="top: 350px;"><b>{$error}</b></div>
<div class="admin_regi_form" style="height: 200px">
<form name="forget_form" action="forget.php?job=forget" method="post">

<table style="position: absolute; left: 550px; top: 250px;">

<tr>
<th>E-mail</th>
<td> : <input type="text" name="email" id="email" value="{$email}" required /></td>
</tr>


<tr>
<td></td>
<td align="center">
<input type="submit" name="ok" value="Ok." />
</td>
</tr>

</table>


</form>
</div>

<div style="position: absolute; top: 540px; width: 100%; text-align: center; font-size: 13px; padding-bottom: 10px;">
{include file="footer.tpl"}