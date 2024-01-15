<?php

namespace Wepa\Surveys\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
        if ($this->method === 'PUT') {
            return [
                'question' => 'string|required',
                'tag' => ['string', 'nullable', Rule::unique('surveys_questions')->ignore($this->request->id)],
                'status' => 'required|boolean',
            ];
        } else {
            return [
                'question' => 'string|required',
                'tag' => ['string', 'nullable', Rule::unique('surveys_questions')],
                'status' => 'required|boolean',
            ];
        }
    }
}
