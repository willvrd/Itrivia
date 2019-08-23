<?php

namespace Modules\Itrivia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Itrivia\Entities\UserQuestionAnswer;
use Modules\Itrivia\Http\Requests\CreateUserQuestionAnswerRequest;
use Modules\Itrivia\Http\Requests\UpdateUserQuestionAnswerRequest;
use Modules\Itrivia\Repositories\UserQuestionAnswerRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserQuestionAnswerController extends AdminBaseController
{
    /**
     * @var UserQuestionAnswerRepository
     */
    private $userquestionanswer;

    public function __construct(UserQuestionAnswerRepository $userquestionanswer)
    {
        parent::__construct();

        $this->userquestionanswer = $userquestionanswer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$userquestionanswers = $this->userquestionanswer->all();

        return view('itrivia::admin.userquestionanswers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('itrivia::admin.userquestionanswers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserQuestionAnswerRequest $request
     * @return Response
     */
    public function store(CreateUserQuestionAnswerRequest $request)
    {
        $this->userquestionanswer->create($request->all());

        return redirect()->route('admin.itrivia.userquestionanswer.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('itrivia::userquestionanswers.title.userquestionanswers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserQuestionAnswer $userquestionanswer
     * @return Response
     */
    public function edit(UserQuestionAnswer $userquestionanswer)
    {
        return view('itrivia::admin.userquestionanswers.edit', compact('userquestionanswer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserQuestionAnswer $userquestionanswer
     * @param  UpdateUserQuestionAnswerRequest $request
     * @return Response
     */
    public function update(UserQuestionAnswer $userquestionanswer, UpdateUserQuestionAnswerRequest $request)
    {
        $this->userquestionanswer->update($userquestionanswer, $request->all());

        return redirect()->route('admin.itrivia.userquestionanswer.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('itrivia::userquestionanswers.title.userquestionanswers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserQuestionAnswer $userquestionanswer
     * @return Response
     */
    public function destroy(UserQuestionAnswer $userquestionanswer)
    {
        $this->userquestionanswer->destroy($userquestionanswer);

        return redirect()->route('admin.itrivia.userquestionanswer.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('itrivia::userquestionanswers.title.userquestionanswers')]));
    }
}
