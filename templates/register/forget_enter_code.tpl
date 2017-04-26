{include file="header.tpl"}
{include file="navigation.tpl"}
<div class="side_bar"></div>
<div class="notice" style="top: 500px;"><b>{$notice}</b></div>
<div class="notice" style="top: 500px;"><b>{$error}</b></div>
<script>
function passwordStrength(password,passwordStrength,errorField)
{

var desc = new Array();
desc[0] = "  Blank";
desc[1] = "  Very Weak";
desc[2] = "  Week";
desc[3] = "  Better";
desc[4] = "  Medium";
desc[5] = "  Strong";
desc[6] = "  Strongest";

var score   = 0;

//if password bigger than 0 give 1 point
if (password.length > 0) score++;

//if password bigger than 6 give 1 point
if (password.length > 6) score++;

//if password has both lower and uppercase characters give 1 point
if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

//if password has at least one number give 1 point
if (password.match(/\d+/)) score++;

//if password has at least one special caracther give 1 point
if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

//if password bigger than 12 give another 1 point
if (password.length > 12) score++;

passwordStrength.innerHTML = desc[score];
passwordStrength.className = "strength" + score;
}
</script>

<script>
function comparePassword(){
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password_rep").value;
	
    if (password != confirmPassword)
    	 document.getElementById("PasswordMatch").innerHTML="Both Password must be Same";
    else
    	 document.getElementById("PasswordMatch").innerHTML="Ok! Carry on.";
}
</script>

<div class="admin_regi_form" style="height: 200px">
<form name="forget_form" action="forget.php?job=check" method="post">

<table style="position: absolute; left: 550px; top: 250px; text-align: left;">

<tr>
<th>E-mail</th>
<td> : <input type="text" name="email" id="email" value="{$email}" required /></td>
</tr>

<tr>
<th>Code</th>
<td> : <input type="text" name="code" id="code" value="{$code}" required /></td>
</tr>

<tr>
<th>Password</th>
<td> : <input type="password" name="password" value="{$password}" id="password" onkeyup="passwordStrength(this.value,document.getElementById('strendth'),document.getElementById('passError'))" required /><span id="strendth"></span></td>
</tr>

<tr>
<th>Repeat Password</th>
<td> : <input type="password" name="password_rep" value="{$password_rep}" id="password_rep" onkeyup="comparePassword()" required /><span id="PasswordMatch"></span></td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="ok" value="Submit." />
</td>
</tr>

</table>


</form>
</div>

<div style="position: absolute; top: 540px; width: 100%; text-align: center; font-size: 13px; padding-bottom: 10px;">
{include file="footer.tpl"}