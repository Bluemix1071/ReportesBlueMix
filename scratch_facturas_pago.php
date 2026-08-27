<?php
// ... en AdminController.php

    $factura_efectivo_count = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'E')
      ->count('CANMRO');

    $factura_efectivo_neto = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'E')
      ->sum('CANETO');

    $factura_efectivo_iva = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'E')
      ->sum('CAIVA');

    $factura_efectivo_total = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'E')
      ->sum('CAVALO');

    // TRANSBANK (T)
    $factura_transbank_count = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'T')
      ->count('CANMRO');

    $factura_transbank_neto = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'T')
      ->sum('CANETO');

    $factura_transbank_iva = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'T')
      ->sum('CAIVA');

    $factura_transbank_total = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'T')
      ->sum('CAVALO');

    // WEBPAY (WP)
    $factura_webpay_count = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'WP')
      ->count('CANMRO');

    $factura_webpay_neto = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'WP')
      ->sum('CANETO');

    $factura_webpay_iva = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'WP')
      ->sum('CAIVA');

    $factura_webpay_total = DB::table('cargos')
      ->where('CATIPO', 8)
      ->whereBetween('CAFECO', [$request->fecha1, $request->fecha2])
      ->where('forma_pago', 'WP')
      ->sum('CAVALO');

