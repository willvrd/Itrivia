<?php

namespace Modules\Itrivia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Itrivia\Entities\Trivia;
use Modules\Itrivia\Http\Requests\CreateTriviaRequest;
use Modules\Itrivia\Http\Requests\UpdateTriviaRequest;
use Modules\Itrivia\Repositories\TriviaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TriviaController extends AdminBaseController
{
    /**
     * @var TriviaRepository
     */
    private $trivia;

    public function __construct(TriviaRepository $trivia)
    {
        parent::__construct();

        $this->trivia = $trivia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$trivias = $this->trivia->all();

        return view('itrivia::admin.trivias.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('itrivia::admin.trivias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTriviaRequest $request
     * @return Response
     */
    public function store(CreateTriviaRequest $request)
    {
        $this->trivia->create($request->all());

        return redirect()->route('admin.itrivia.trivia.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('itrivia::trivias.title.trivias')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trivia $trivia
     * @return Response
     */
    public function edit(Trivia $trivia)
    {
        return view('itrivia::admin.trivias.edit', compact('trivia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Trivia $trivia
     * @param  UpdateTriviaRequest $request
     * @return Response
     */
    public function update(Trivia $trivia, UpdateTriviaRequest $request)
    {
        $this->trivia->update($trivia, $request->all());

        return redirect()->route('admin.itrivia.trivia.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('itrivia::trivias.title.trivias')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Trivia $trivia
     * @return Response
     */
    public function destroy(Trivia $trivia)
    {
        $this->trivia->destroy($trivia);

        return redirect()->route('admin.itrivia.trivia.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('itrivia::trivias.title.trivias')]));
    }
}
