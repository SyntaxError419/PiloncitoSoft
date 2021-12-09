<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoCreateRequest extends FormRequest
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
        $producto= $this->route('producto');
        
        return [
            'nombre' => ['required' , 'unique:productos,nombre,'.$producto] ,
            'precio'=>'required',

            
        ];
    }
}
