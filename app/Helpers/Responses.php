<?php
namespace App\Helpers;

class Responses
{


    public static function Success($result,$text){
        
        $data = [
            "status" => "success",
            "code" => 200,
            $text =>$result,

        ];

        return $data;
    }

    public static function Errors($error,$text){

        $data = [
            "status" => "error",
            "code" => 400,
            $text =>$result,

        ];

        return $data;
    }


}