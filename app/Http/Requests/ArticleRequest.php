<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'product_name' => 'required|max:255',
            'company' => 'required|max:200',
            'price' => 'required|max:500',
            'stock' => 'required|max:500',
            'comment' => 'max:1000',
            'image' => 'max:1000'
        ];
    }
        /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'company' => 'メーカー番号',
            'price' => '価格',
            'stock' => '数量',
            'comment' => 'コメント',
            'image' => '商品画像'
        ];
    }
    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages() {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'company.required' => ':attributeは必須項目です。',
            'price.required' => ':attributeは必須項目です。',
            'price.max' => ':attributeは:max円以内で入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.max' => ':attributeは:max個以内で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'image.max' => ':attributeは:max字以内で入力してください。'
        ];
    }
}
