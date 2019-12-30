<!DOCTYPE html>
<html lang="en">
<head>
	<title>Venta GiftCard</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{asset("assets/$theme/VentaGiftCard/images/icons/favicon.ico")}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/bootstrap/css/bootstrap.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/fonts/font-awesome-4.7.0/css/font-awesome.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/animate/animate.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/css-hamburgers/hamburgers.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/animsition/css/animsition.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/select2/select2.min.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/vendor/daterangepicker/daterangepicker.css")}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/css/util.css")}}">
	<link rel="stylesheet" type="text/css" href="{{asset("assets/$theme/VentaGiftCard/css/main.css")}}">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
        <form class="contact100-form validate-form" method="POST" action="{{route('GiftCardVoucher')}}">
            @csrf
				<span class="contact100-form-title">
					Gift Card
				</span>




                <div class="wrap-input100">
					<div class="label-input100">Selecciona El Monto</div>
					<div>
						<select class="js-select2" name="monto" required>
							<option value="">........</option>
							<option value="10000">$10.000</option>
							<option value="20000">$20.000</option>
							<option value="40000">$40.000</option>
							<option value="60000">$60.000</option>
							<option value="100000">$100.000</option>
						</select>
						<div class="dropDownSelect2"></div>
					</div>
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Ingrese el codigo de barra">
					<label class="label-input100" for="name">Codigo De La Tarjeta ( Barra)</label>
					<input id="name" class="input100" type="text" name="codigo" maxlength="12" placeholder="">
					<span class="focus-input100"></span>
				</div>


			


				

				

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						Generar
					</button>
				</div>

				
			</form>

			<div class="contact100-more flex-col-c-m" style="background-image: url('{{asset("assets//$theme/login/images/bg-01.jpg')")}};">
			</div>
		</div>
	</div>





<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/jquery/jquery-3.2.1.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/animsition/js/animsition.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/bootstrap/js/popper.js")}}"></script>
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/bootstrap/js/bootstrap.min.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/select2/select2.min.js")}}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
		$(".js-select2").each(function(){
			$(this).on('select2:open', function (e){
				$(this).parent().next().addClass('eff-focus-selection');
			});
		});
		$(".js-select2").each(function(){
			$(this).on('select2:close', function (e){
				$(this).parent().next().removeClass('eff-focus-selection');
			});
		});

	</script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/daterangepicker/moment.min.js")}}"></script>
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/daterangepicker/daterangepicker.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/vendor/countdowntime/countdowntime.js")}}"></script>
<!--===============================================================================================-->
	<script src="{{asset("assets/$theme/VentaGiftCard/js/main.js")}}"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
</body>
</html>
