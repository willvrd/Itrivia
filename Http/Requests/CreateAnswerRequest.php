<?php

namespace Modules\Itrivia\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAnswerRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'question_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required|min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => trans('itrivia::common.messages.title is required'),
            'title.min:2'=> trans('itrivia::common.messages.title min 2 '),
            'question_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('itrivia::common.messages.title is required'),
            'title.min:2'=> trans('itrivia::common.messages.title min 2 '),
            'question_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }
}
