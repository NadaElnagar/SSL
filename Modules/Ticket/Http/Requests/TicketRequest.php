<?php


namespace Modules\Ticket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            "description"=>"required_without:images|string",
            "images"=>"required_without:description",
            "ticket_id"=>"numeric"
        ];
    }
}
