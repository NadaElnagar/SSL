<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            "topic_name" => "required|string|unique:setting_topic",
            "details" => "required|array",
            "active" => "required|integer|min:0|max:1|digits_between: 0,1'"
        ];
    }
}
