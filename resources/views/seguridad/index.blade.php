<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset("assets/$theme/login/images/icons/favicon.ico")}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/bootstrap/css/bootstrap.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/animate/animate.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/css-hamburgers/hamburgers.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/animsition/css/animsition.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/select2/select2.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/vendor/daterangepicker/daterangepicker.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/css/util.css")}}">
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/login/css/main.css")}}">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<form action="{{ route('login_post') }}" class="login100-form validate-form" method="POST">
					<div class="login-box-body" >
							@if ($errors->any())
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true"> X</button>
									<div class="alert-text">
										@foreach ($errors->all() as $item)
											<span> {{$item}}</span>
										@endforeach
									</div>
								</div>

							@endif
						</div>
				@csrf
					<span class="login100-form-title p-b-43">
						Reportes BlueMix
					</span>


					<div class="wrap-input100 validate-input" >
						<input class="input100" type="email" placeholder="usuario" name="email">
						<span class="focus-input100"></span>
						<span class="label-input100"></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" placeholder="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">

						<div>

						</div>
					</div>


					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Ingresar
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<span class="txt3">
                            <a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
						</span>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('{{asset("assets/$theme/login/images/bg-01.jpg')")}};">	</div>
			</div>
		</div>
	</div>





<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/animsition/js/animsition.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/bootstrap/js/popper.js")}}"></script>
	<script src="{{asset("assets/$theme/login/vendor/bootstrap/js/bootstrap.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/select2/select2.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/daterangepicker/moment.min.js")}}"></script>
	<script src="{{asset("assets/$theme/login/vendor/daterangepicker/daterangepicker.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/login/vendor/countdowntime/countdowntime.js")}}"></script>
<!--===============================================================================================-->


</body>
</html>
