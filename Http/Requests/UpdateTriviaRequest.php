<?php

namespace Modules\Itrivia\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateTriviaRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
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
        ];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('itrivia::common.messages.title is required'),
            'title.min:2'=> trans('itrivia::common.messages.title min 2 '),
        ];
    }
}
