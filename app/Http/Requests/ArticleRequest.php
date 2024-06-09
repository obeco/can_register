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
            // 検索フォームでは弾かれてしまう
            // Requestを使用して、
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
            // 'company_id' => 'メーカー番号',
            'company_name' => 'メーカー名',
            'stock' => '数量',
            'comment' => '備考',
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
            'required' => ':attributeは必須項目です。'
        ];
    }
}
