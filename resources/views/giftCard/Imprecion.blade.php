<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0056)https://www.trevor-davis.com/play/javascript-print-link/ -->
 <html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>Nota Pago</title>

<script type="text/javascript" src="./JavaScript Print Link_files/jquery.js.descarga"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('ul#tools').prepend('<li class="print"><a href="#print">Click me to print</a></li>');
	$('ul#tools li.print a').click(function() {
		window.print();
		return false;
	});
});
</script>
<style type="text/css">
html, body, h1, p, ul { margin: 0; padding: 0; }
body { font: 62.5% Georgia, Times, serif; }
div#container { background: #efefef; border: 1px solid #ccc; border-top: none; font-size: 1.4em; line-height: 1.429em; margin: 0 auto; padding: 20px; width: 460px; }
h1 { font-size: 2em; margin-bottom: 10px; }
p { margin-bottom: 30px; }
ul { list-style: square; margin: 0 0 20px 20px; }
pre{font-size: 1.7em;  }
</style>

<SCRIPT language="javascript">
        function imprimir2()
        { if ((navigator.appName == "Netscape")) { window.print() ;
        }
        else
        { var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
        document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
        }
        }
        </SCRIPT>





</head>

<body cz-shortcut-listen="true" onload="Imprimir()" >
<div id="container">
<h1>SOCIEDAD COMERCIAL <a style="text-decoration:none" href="{{route('VentaEmpresa')}}">BLUE</a>  MIX LTDA.</h1>
<pre>C.M.: 5 DE ABRIL 1071 – CHILLAN
GIRO:LIBRERÍA,JUGuETERIA POR MAYOR Y DETALLE
RUT Nro: 77.283.950-2
LOC.: 5 DE ABRIL 1071 – CHILLAN
Nro. Caja: 001    Nota de cobro Nro. {{$idBD_vou}}
Fecha: {{$dateVou}}
</pre>
<div style="display: none">{{ $total = 0 }} </div>
@foreach ($TarjetasSeleccionadas as $item)
<div style="display: none">{{$total += $item->TARJ_MONTO_INICIAL}}</div>
@endforeach 
<pre>
<strong> Codigo</strong>           <strong>Monto</strong>    
      
@foreach ($TarjetasSeleccionadas as $item)
{{$item->TARJ_CODIGO}}  |    ${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}

@endforeach 
-------------------------------------------
Total :            ${{number_format($total,0,',','.')}}
</pre>

<pre>
El uso de la Giftcard está sujeto a las
condiciones impresas en la misma tarjeta

              Copia Cliente

</pre>

<!-- <ul id="tools"><li class="print"></li> -->

</div>
<pre>

  
</pre>

<div id="container">
<h1>SOCIEDAD COMERCIAL <a style="text-decoration:none" href="{{route('VentaEmpresa')}}">BLUE</a>  MIX LTDA.</h1>
<pre>C.M.: 5 DE ABRIL 1071 – CHILLAN
GIRO:LIBRERÍA,JUGuETERIA POR MAYOR Y DETALLE
RUT Nro: 77.283.950-2
LOC.: 5 DE ABRIL 1071 – CHILLAN
Nro. Caja: 001    Nota de cobro Nro. {{$idBD_vou}}
Fecha: {{$dateVou}}
</pre>
<div style="display: none">{{ $total = 0 }} </div>
@foreach ($TarjetasSeleccionadas as $item)
<div style="display: none">{{$total += $item->TARJ_MONTO_INICIAL}}</div>
@endforeach 
<pre>
<strong> Codigo</strong>           <strong>Monto</strong>    

@foreach ($TarjetasSeleccionadas as $item)
{{$item->TARJ_CODIGO}}  |    ${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}

@endforeach 
-------------------------------------------
Total :            ${{number_format($total,0,',','.')}}
</pre>

<pre>
El uso de la Giftcard está sujeto a las
condiciones impresas en la misma tarjeta

              Copia Cajero

</pre>

<!-- <ul id="tools"><li class="print"></li> -->

</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script><script src="./JavaScript Print Link_files/ga.js.descarga" type="text/javascript"></script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-751954-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<script>

function Imprimir(){
    window.print();
  return false;
		
}
		

</script>



</body>
</html>