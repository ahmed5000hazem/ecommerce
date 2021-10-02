<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountsRequest extends FormRequest
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

    public function messages()
    {
        return [
            'items_value_disc_value.required_with' => 'this field is required when you make items / value offer',
            'items_value_disc_items_number.required_with' => 'this field is required when you make items / value offer',
            'items_items_disc_buy_items_count.required_with' => 'this field is required when you make buy / get offer',
            'items_items_disc_get_items_count.required_with' => 'this field is required when you make buy / get offer',
            'items_items_disc_present_product_id.required' => 'present id is required',
        ];
    }
    public function rules()
    {
        return [
            "product_id" => "required",
            "item_value_disc_value" => ["nullable", "numeric"],
            "item_value_disc_percent" => ["nullable", "numeric"],
            "item_value_disc_starts_at" => ["nullable", "date"],
            "item_value_disc_ends_at" => ["nullable", "date"],
            "items_value_disc_value" => ["required_with:items_value_disc_items_number"],
            "items_value_disc_items_number" => ["required_with:items_value_disc_value"],
            "items_value_disc_starts_at" => ["nullable", "date"],
            "items_value_disc_ends_at" => ["nullable", "date"],
            "items_items_disc_present_product_id" => ["required_with_all:items_items_disc_buy_items_count,items_items_disc_get_items_count"],
            "items_items_disc_buy_items_count" => ["required_with:items_items_disc_get_items_count"],
            "items_items_disc_get_items_count" => ["required_with:items_items_disc_buy_items_count"],
            "items_items_disc_starts_at" => ["nullable", "date"],
            "items_items_disc_ends_at" => ["nullable", "date"],
        ];
    }
}
