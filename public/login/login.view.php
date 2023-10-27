<!DOCTYPE html>
<html lang="en">
<head>
	<title>Framework :: Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="media/img/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="media/plugins/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="media/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="media/plugins/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="media/plugins/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="media/plugins/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="media/css/util.css">
	<link rel="stylesheet" type="text/css" href="media/css/style.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="page-login limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<?php if(isset($attempt_in)){?>
			<div class="alert-danger">
				<?php
				if($attempt_in < 3){
					$msg= '<p class="alertmsg">Invalid user name or password.</p>';
				}else if($attempt_in =='11'){
					$msg= '<p class="alertmsg">Invalid Code entered.</p>';
				}else if($attempt_in =='120'){
					$msg= '<p class="alertmsg">Suspended account.</p>';
				}else if($attempt_in =='140'){
					$msg= '<p class="alertmsg">Locked. Wait for 5min and try again.</p>';
				}else if($attempt_in =='110'){
					$msg= '<p class="alertmsg">User account locked.</p>';
				}
			?>
			</div>
			<?php } ?>
				<div class="login100-pic js-tilt" data-tilt>
					<img src="media/img/logo.svg" alt="IMG">
				</div>

				<form action="index.php?action=index&pg=1" method="post" enctype="application/x-www-form-urlencoded" name="loginForm" id="loginForm"
                    autocomplete="off">
					<span class="login100-form-title">
						Member Login
					</span>

					<div <?php echo (($msg))? '':'hidden';?>  class="errormsg"><?php echo $msg;?></div>

					<div class="wrap-input100 validate-input" data-validate = "Valid user name is required: user@abc">
						<input class="input100" type="text" name="uname" placeholder="User Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pwd" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button  type="submit" class="login100-form-btn">
							Login
						</button>
						<input type="hidden" name="doLogin" id="doLogin" value="systemPingPass" />
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="media/plugins/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="media/plugins/bootstrap/js/popper.js"></script>
	<script src="media/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="media/plugins/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="media/plugins/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<?php include 'login.js.php'; ?>

</body>
</html>