<?php

namespace Modules\Itrivia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Itrivia\Entities\UserTrivia;
use Modules\Itrivia\Http\Requests\CreateUserTriviaRequest;
use Modules\Itrivia\Http\Requests\UpdateUserTriviaRequest;
use Modules\Itrivia\Repositories\UserTriviaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class UserTriviaController extends AdminBaseController
{
    /**
     * @var UserTriviaRepository
     */
    private $usertrivia;

    public function __construct(UserTriviaRepository $usertrivia)
    {
        parent::__construct();

        $this->usertrivia = $usertrivia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$usertrivias = $this->usertrivia->all();

        return view('itrivia::admin.usertrivias.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('itrivia::admin.usertrivias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserTriviaRequest $request
     * @return Response
     */
    public function store(CreateUserTriviaRequest $request)
    {
        $this->usertrivia->create($request->all());

        return redirect()->route('admin.itrivia.usertrivia.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('itrivia::usertrivias.title.usertrivias')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserTrivia $usertrivia
     * @return Response
     */
    public function edit(UserTrivia $usertrivia)
    {
        return view('itrivia::admin.usertrivias.edit', compact('usertrivia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserTrivia $usertrivia
     * @param  UpdateUserTriviaRequest $request
     * @return Response
     */
    public function update(UserTrivia $usertrivia, UpdateUserTriviaRequest $request)
    {
        $this->usertrivia->update($usertrivia, $request->all());

        return redirect()->route('admin.itrivia.usertrivia.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('itrivia::usertrivias.title.usertrivias')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserTrivia $usertrivia
     * @return Response
     */
    public function destroy(UserTrivia $usertrivia)
    {
        $this->usertrivia->destroy($usertrivia);

        return redirect()->route('admin.itrivia.usertrivia.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('itrivia::usertrivias.title.usertrivias')]));
    }
}
