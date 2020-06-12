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
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Patient</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Doctor</a>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						  <form>
						  <div class="form-group">
						    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Full name">
						  </div>
						  <div class="form-group">
						    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Enter your email">
						  </div>
						  <div class="form-group">
						    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Mobile number">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your Password">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm password">
						  </div>
						  <small>
						  	You are registering as <span style="font-weight: bold;">Patient</span>
						  </small>
						  <button type="submit" class="btn btn-primary loginBtn">Sign up</button>
						</form>
						  </div>
						  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						  	<form>
						  <div class="form-group">
						    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Full name">
						  </div>
						  <div class="form-group">
						    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Enter your email">
						  </div>
						  <div class="form-group">
						    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Mobile number">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your Password">
						  </div>
						  <div class="form-group">
						    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm password">
						  </div>
						  <small>
						  	You are registering as <span style="font-weight: bold;">Doctor</span>
						  </small>
						  <button type="submit" class="btn btn-primary loginBtn">Sign up</button>
						</form>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>


<?php include 'footer.php' ?>