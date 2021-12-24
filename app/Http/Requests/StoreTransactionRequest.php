<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'category_id' =>
             [
                'required',
                Rule::exists('categories', 'id')->where('user_id', auth()->id()),
            ],
            'product_name' => 'required',
            'price' => 'required',
            'picture' => 'required',
            'size' => 'required',
            'stock' => 'required',
            'comment' => 'required',
        ];
    }
}
