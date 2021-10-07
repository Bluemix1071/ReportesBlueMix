<?php

namespace App\Modelos\Jumpseller;

use Illuminate\Database\Eloquent\Model;
use JMathai\PhpMultiCurl\MultiCurl;

class ApiJumpsellerEmpresas extends Model
{
    protected $baseUri =  "https://api.jumpseller.com/v1/";
    protected $credentials = [
        "login" => '743d75823609c856217bba7d385f48a4',
        "authtoken" => 'eb7dee85cfe1d9e86b4a68c1f2bee668',
    ];

    public function get($urlConsulta,$parametrosAdicionales){
        $url = $this->baseUri.$urlConsulta;
        $parametros = array_merge($this->credentials,$parametrosAdicionales);
        $consulta = http_build_query($parametros);
        $ch = curl_init($url.".json?".$consulta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); //get method
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);

        return $result;


    }
    public function getMulti($urls,$param){
        $mc = MultiCurl::getInstance();
        $calls = [];
        for ($i=0; $i < count($urls) ; $i++) {
            $url = $this->baseUri.$urls[$i];
            $parametros = array_merge($this->credentials,$param[$i]);
            $consulta = http_build_query($parametros);
            $ch = curl_init($url.".json?".$consulta);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); //get method
            $call = $mc->addCurl($ch);
            array_push($calls,$call);
        }
        $result = [];
        foreach ($calls as $call) {
            array_push($result,json_decode($call->response));
        }

        return $result;

    }

    public function post($urlConsulta,$parametrosAdicionales,$body){
        $url = $this->baseUri.$urlConsulta;
        $parametros = array_merge($this->credentials,$parametrosAdicionales);
        $consulta = http_build_query($parametros);
        $ch = curl_init($url.".json?".$consulta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
       // dd($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);

        return $result;

    }
    //funcion que actualiza productos sin variantes recibe id producto y body json
    public function put($urlConsulta,$body){
        $url = $this->baseUri."products/".$urlConsulta;
        $parametros = $this->credentials;
        $consulta = http_build_query($parametros);

        /* $url = 'https://api.jumpseller.com/v1/products/10967214.json?login=743d75823609c856217bba7d385f48a4&authtoken=eb7dee85cfe1d9e86b4a68c1f2bee668';
        $body = '{ "product" : {"name": "ACCESORIO ARGOLLA  Nº11", "price": 7,  "stock": 1} }'; */

        $ch = curl_init($url.".json?".$consulta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        //dd($ch);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    //funcion que actualiza productos con variantes recibe id producto padre y id producto y body json
    public function putVariant($urlConsulta1,$urlConsulta2,$body){
        //https://api.jumpseller.com/v1/products/{id}/variants/{variant_id}.json
        $url = $this->baseUri."products/".$urlConsulta1."/variants/".$urlConsulta2;
        $parametros = $this->credentials;
        $consulta = http_build_query($parametros);

        /* $url = 'https://api.jumpseller.com/v1/products/10967214.json?login=743d75823609c856217bba7d385f48a4&authtoken=eb7dee85cfe1d9e86b4a68c1f2bee668';
        $body = '{ "product" : {"name": "ACCESORIO ARGOLLA  Nº11", "price": 7,  "stock": 1} }'; */

        $ch = curl_init($url.".json?".$consulta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

        //dd($body);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
