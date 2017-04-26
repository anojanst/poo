{include file="header.tpl"}
		<script>
		function showPass1(pass)
		{
		var xmlhttp;    
		if (pass=="")
		  {
		  document.getElementById("availability_status").innerHTML="";
		  return;
		  }
		if (window.XMLHttpRequest)
		  {
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			    var outPut = xmlhttp.responseText;
		    document.getElementById("availability_status").innerHTML=xmlhttp.responseText;
		    }
		  }
		xmlhttp.open("GET","ajax/query_check_username.php?user_name="+pass,true);
		xmlhttp.send();
		document.reg.email.focus();
		
		}
		</script>
		
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
		function showPass2(pass)
		{
		var xmlhttp;    
		if (pass=="")
		  {
		  document.getElementById("emailchecking").innerHTML="";
		  return;
		  }
		if (window.XMLHttpRequest)
		  {
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("emailchecking").innerHTML=xmlhttp.responseText;
		    }
		  }
		xmlhttp.open("GET","ajax/query_check_email.php?email="+pass,true);
		xmlhttp.send();
		document.reg.email.focus();
		
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

	<div id="header">
		<div>
			<div class="logo">
				<a href="index.php">Accountant.lk</a>
			</div>
			<ul id="navigation">
				<li class="active">
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="features.html">Features</a>
				</li>
				<li>
					<a href="about.html">About</a>
				</li>
				<li>
					<a href="contact.html">Contact</a>
				</li>
				<li>
					<a href="javascript:login('show');">login</a>
				</li>
				<li>
					<a href="register.php">Register</a>
				</li>
			</ul>
		</div>
	</div>
	<div id="contents">
		<div class="section">
			<h1>Register</h1>
			<p>
				You can replace all this text with your own text. Want an easier solution for a Free Website? Head straight to Wix and immediately start customizing your website! Wix is an online website builder with a simple drag & drop interface, meaning you do the work online and instantly publish to the web. All Wix templates are fully customizable and free to use. Just pick one you like, click Edit, and enter the online editor.
			</p>
			<form name="register_form" action="register.php?job=register" method="post" class="message">
				<input type="text" name="user_name" id="user_name" value="{$user_name}" onkeyup="showPass1(this.value)" required placeholder="Username"/>
				<span id="availability_status"></span>
				<input type="password" name="password" value="{$password}" id="password" onkeyup="passwordStrength(this.value,document.getElementById('strendth'),document.getElementById('passError'))" required placeholder="Password"/>
				<span id="strendth"></span>
				<input type="password" name="password_rep" value="{$password_rep}" id="password_rep" onkeyup="comparePassword()" required placeholder="Repeat Password"/>
				<span id="PasswordMatch"></span>
				<input type="text" name="org_name" value="{$org_name}" required placeholder="Organization Name"/>
				<input type="text" name="email" value="{$email}"  id="email" onkeyup="showPass2(this.value)" required placeholder="E-mail"/>
				<span id="emailchecking"></span>
				<input type="submit" name="ok" value="Register Now!" />
			</form>
		</div>
		<div class="section register">
			<p>
				For Inquiries Please Call: <span>877-433-8137</span>
			</p>
			<p>
				Or you can contact us via: <span>support@accountant.lk<br />register@accountant.lk</span>
			</p>
			<p>
				Stay In Connection...
			</p>
		</div>
	</div>
{include file="footer.tpl"}