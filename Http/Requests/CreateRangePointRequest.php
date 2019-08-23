<?php

namespace Modules\Itrivia\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRangePointRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'value' => 'required',
            'points' => 'required',
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
            'value.required' => trans('itrivia::common.messages.field required'),
            'points.required' => trans('itrivia::common.messages.field required'),
            'trivia_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'value.required' => trans('itrivia::common.messages.field required'),
            'points.required' => trans('itrivia::common.messages.field required'),
            'trivia_id.required' => trans('itrivia::common.messages.field required'),
        ];
    }
}
