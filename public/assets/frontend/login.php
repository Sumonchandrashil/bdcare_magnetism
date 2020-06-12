<?php include 'header.php' ?>

<!-- ###########################
    LOGIN SECTION
########################### -->


<section class="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
				<div class="loginBar">
					<ul>
						<li>
							<a href="login.php">
								<i class="fas fa-sign-in-alt"></i><span>Login</span>
							</a>
						</li>
						<li>
							<a href="register.php">
								<i class="fas fa-user-plus"></i><span>Register</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="loginPanelLeft">
					<div class="loginImage">
						<img src="images/login.jpg">
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="loginPanelRight">
					<div class="loginForm">
						<form method="post" action="profile.php">
						  <div class="form-group">
						    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
						  </div>
						  <div class="form-check">
						    <input type="checkbox" class="form-check-input" id="exampleCheck1">
						    <label class="form-check-label remember" for="exampleCheck1">Remember me for 30 days</label>
						  </div>
						  <a href="#">Forgot Password</a>
						  <button type="submit" class="btn btn-primary loginBtn">Login</button>
						</form>
						<hr style="margin-top: 30px;">
						<a href="#">
							<button class="btn btn-primary gmailLogin">
							<i class="fab fa-google"></i>
							Login with Gmail
							</button>
						</a>
						<a href="#">
							<button class="btn btn-primary fbLogin">
							<i class="fab fa-facebook-f"></i>
							Login with Facebook
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>


<?php include 'footer.php' ?>