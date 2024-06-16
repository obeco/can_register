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
            'product_name' => 'max:255',
            'company_name' => 'max:255',
            'price' => 'max:10000',
            'stock' => 'max:500',
            'comment' => 'max:10000',
            'img_path' => 'width:200'
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
            'company_id' => 'メーカー番号',
            'company_name' => 'メーカー名',
            'price' => '価格',
            'stock' => '数量',
            'comment' => 'コメント',
            'img_path' => '商品画像'
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
            'company_name.required' => ':attributeは必須項目です。',
            'company_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.max' => ':attributeは:max字以内で入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.max' => ':attributeは:max字以内で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
            'img_path.max' => ':attributeは:max字以内で入力してください。'
        ];
    }
}
