<?php

namespace Modules\Itrivia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Itrivia\Entities\Question;
use Modules\Itrivia\Http\Requests\CreateQuestionRequest;
use Modules\Itrivia\Http\Requests\UpdateQuestionRequest;
use Modules\Itrivia\Repositories\QuestionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class QuestionController extends AdminBaseController
{
    /**
     * @var QuestionRepository
     */
    private $question;

    public function __construct(QuestionRepository $question)
    {
        parent::__construct();

        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$questions = $this->question->all();

        return view('itrivia::admin.questions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('itrivia::admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateQuestionRequest $request
     * @return Response
     */
    public function store(CreateQuestionRequest $request)
    {
        $this->question->create($request->all());

        return redirect()->route('admin.itrivia.question.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('itrivia::questions.title.questions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question
     * @return Response
     */
    public function edit(Question $question)
    {
        return view('itrivia::admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Question $question
     * @param  UpdateQuestionRequest $request
     * @return Response
     */
    public function update(Question $question, UpdateQuestionRequest $request)
    {
        $this->question->update($question, $request->all());

        return redirect()->route('admin.itrivia.question.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('itrivia::questions.title.questions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Question $question
     * @return Response
     */
    public function destroy(Question $question)
    {
        $this->question->destroy($question);

        return redirect()->route('admin.itrivia.question.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('itrivia::questions.title.questions')]));
    }
}
