<?php

namespace Modules\Itrivia\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateUserQuestionAnswerRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'question_id' => 'required',
            'answer_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'question_id.required' => trans('itrivia::common.messages.field required'),
            'answer_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'question_id.required' => trans('itrivia::common.messages.field required'),
            'answer_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }
}
