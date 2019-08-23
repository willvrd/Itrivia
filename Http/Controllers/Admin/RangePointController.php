<?php

namespace Modules\Itrivia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Itrivia\Entities\RangePoint;
use Modules\Itrivia\Http\Requests\CreateRangePointRequest;
use Modules\Itrivia\Http\Requests\UpdateRangePointRequest;
use Modules\Itrivia\Repositories\RangePointRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RangePointController extends AdminBaseController
{
    /**
     * @var RangePointRepository
     */
    private $rangepoint;

    public function __construct(RangePointRepository $rangepoint)
    {
        parent::__construct();

        $this->rangepoint = $rangepoint;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$rangepoints = $this->rangepoint->all();

        return view('itrivia::admin.rangepoints.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('itrivia::admin.rangepoints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRangePointRequest $request
     * @return Response
     */
    public function store(CreateRangePointRequest $request)
    {
        $this->rangepoint->create($request->all());

        return redirect()->route('admin.itrivia.rangepoint.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('itrivia::rangepoints.title.rangepoints')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  RangePoint $rangepoint
     * @return Response
     */
    public function edit(RangePoint $rangepoint)
    {
        return view('itrivia::admin.rangepoints.edit', compact('rangepoint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RangePoint $rangepoint
     * @param  UpdateRangePointRequest $request
     * @return Response
     */
    public function update(RangePoint $rangepoint, UpdateRangePointRequest $request)
    {
        $this->rangepoint->update($rangepoint, $request->all());

        return redirect()->route('admin.itrivia.rangepoint.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('itrivia::rangepoints.title.rangepoints')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RangePoint $rangepoint
     * @return Response
     */
    public function destroy(RangePoint $rangepoint)
    {
        $this->rangepoint->destroy($rangepoint);

        return redirect()->route('admin.itrivia.rangepoint.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('itrivia::rangepoints.title.rangepoints')]));
    }
}
