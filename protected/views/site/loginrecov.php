    <!DOCTYPE html>
    <html>
    <head>
    <title>Class Book 2013</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style type="text/css">
			.error{
				color:red;
				border:1px solid red;
				background-color:red;
			}
		</style>
    </head>
    <body>
    <script src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl;?>/js/form_validate.js"></script>
    <link  href="<?php echo Yii::app()->request->baseUrl;?>/css/login.css" rel="stylesheet" >
	<link  href="<?php echo Yii::app()->request->baseUrl;?>/css/css/font-awesome.min.css" rel="stylesheet" >
    <div id="main-container">
		<center>
		<div class="container">
			<div class="head">
				<h3 class="header">Classbook</h3>
				<form action="login" method="POST" name="login">
				<table id="login-table">
					<th>
					<tr>
						<td>
							<label>FbId/Phone Num</label>
						</td>
						<td>
							<label>Password</label>
						</td>
					</tr>
					</th>
					<tbody>
						<tr><td><input  id="email" name="LoginForm[username]" ></td>
						<td><input  id="password" name="LoginForm[password]" type="password" ></td>
						<td><button class="login_button" onclick="document.login.submit();">Log In</button></td>
							</tr>
							<tr>
								<td>
									<h4 id="login_error"></h4>
								</td>
								<td>
									<a href="#" class="forgot_pass">Forgot password?</a>
								</td>
							</tr>
					</tbody>
				</table>
				</form>
			</div>
			<div class="body_container">
				<div class="welcome_container">
					<div>
						<h1> Connect with friends and the </h1> 
						<h1>world around you on Classbook.</h1>
					</div>
					<table id="features">
						<tr>
							<td>
								<i class="fa fa-picture-o"></i><b> See photos and updates</b>&nbsp;&nbsp;&nbsp; <span>from friends in News Feed</span>.
								</td>
							</tr>
							<td>
								<i class="fa fa-laptop"></i><b> Share what's new</b>&nbsp;&nbsp;&nbsp; <span>in your life on your Timeline</span>.
								</td>
							</tr>
							<td>
								<i class="fa fa-chain"></i><b> Find more </b> &nbsp;&nbsp;&nbsp;<span>of what you're looking for with Graph Search.</span>
								</td>
							</tr>
						</table>
				</div>
				<div class="signup_container">
				<h1 id="header_sign">Sign Up</h1>
				<h2 id="header_caption">It's free and always will be.</h2>
				<form name="register" action="register" onsubmit="signup_validate()" method="POST">
				<table class="signup_form">
					<tbody>
						<tr>
							<td>
								<div class="signup_error">
									<h3></h3>
									</div>
								</td>
						</tr>
						<tr>
							<td>
								<input class="input_text" id="fname" type="text" name="Register[firstName]" value="First Name">
							<input class="input_text"  id="lname" type="text" name="Register[lastName]" value="Last Name">
									</td>
							</tr>
							<tr>
								<td>
									<input class="input_text2" type="text" onblur="is_Id(this)" id="fb_id" name="Register[idno]" placeholder="" value="Facebook Id">
									</td>
								</tr>
								<tr>
								<td>
									<input class="input_text2" onblur="is_Equal(this)" type="text" id="rfb_id" name="Register[reidno]" value="Re Enter Facebook Id" placeholder="">
									</td>
								</tr>
								<tr>
								<td>
									<input class="input_text2" onblur="vPasswd(this);" type="password" id="fb_pass" name="Register[password]" value="New Password">
									</td>
								</tr>
							<tr>
								<td>
									<h3>Birthday</h3>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo CHtml::dropDownList("month","month", array_merge(array("month"=>"month","id"=>"mnth"),  range(1, 12)));?>
									<?php echo CHtml::dropDownList("day","day", array_merge(array("day"=>"day","id"=>"day"),  range(1, 31)));?>
									<?php echo CHtml::dropDownList("year","year", array_merge(array("year"=>"year","id"=>"year"),  range(1980, 2000)));?>
									<input type="hidden" id="rdob" name="dob"/>
								</td>
							</tr>
							<tr>
								<td>
									<label>Female <input type="radio" name="gender" value="male"></label> 
									<label>Male <input type="radio" name="gender" checked="checked" value="female"></label>
								</td>
							</tr>
							<tr>
								<td>
									<button class="signup_button" onclick="document.register.submit();">Sign Up</button>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				</div>
				<div class="div_footer">
					</div>
					<div class="page_footer">
						<label><p><label style="float:left"><b>Version 1.0</b></label><b>Classbook</b> &copy; <b>2014</b><label style="float:right">Developed by <b> Kishore</b> & <b> Ashok</b></label></p></label>
						
						</div>
			</div>
			</div>
		</center>
	</div>
    </body>
    
    </html>
