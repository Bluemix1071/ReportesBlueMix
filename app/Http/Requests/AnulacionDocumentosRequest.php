<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AnulacionDocumentosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

                'folio'=>['required','max:50','min:2'],
                'valor_documento'=>['required','min:2','numeric'],
                'tipo_documento'=>['required',  Rule::in(['7', '8','3']),],
                'fecha'=>['required','date'],
                //'pago'=>['required',Rule::in(['efectivo', 'tarjeta','cobrar'])],


        ];
    }
}
