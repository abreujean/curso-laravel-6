<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductRequest extends FormRequest
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
        /* PEGANDO O ID ATRAVÉS DO SEGMENTO DA URL */
        $id = $this->segment(2);

        return [
            /*ESSAS VALIDAÇÕES TAMBEM PODEM SER PASSADAS POR ARRAY*/
            'name' => "required|min:3|max:255|unique:products,name,{$id},id",
            'description' => 'required|min:3|max:10000',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'image' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome é obriatório',
            'name.min' => 'Ops! Precisa informar pelo menos 3 caracteres', 
            'photo.required' => 'Ops! Precisa informar uma imagem'
        ];
    }
}
