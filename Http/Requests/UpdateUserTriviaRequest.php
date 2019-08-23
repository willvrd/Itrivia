<?php

namespace Modules\Itrivia\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateUserTriviaRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'trivia_id' => 'required',
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
            'trivia_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'trivia_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }
}
