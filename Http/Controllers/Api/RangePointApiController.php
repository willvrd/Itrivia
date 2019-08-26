<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateRangePointRequest;
use Modules\Itrivia\Http\Requests\UpdateRangePointRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\RangePointTransformer;

// Entities
use Modules\Itrivia\Entities\RangePoint;

// Repositories
use Modules\Itrivia\Repositories\RangePointRepository;

//Support
use Illuminate\Support\Facades\Auth;

class RangePointApiController extends BaseApiController
{

  private $rangePoint;
  
  public function __construct(
    RangePointRepository $rangePoint
    )
  {
    $this->rangePoint = $rangePoint;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $rangePoints = $this->rangePoint->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => RangePointTransformer::collection($rangePoints)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($rangePoints)] : false;

    } catch (\Exception $e) {
      
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];

    }
    return response()->json($response, $status ?? 200);
  }

  /** SHOW
   * @param Request $request
   *  URL GET:
   *  &fields = type string
   *  &include = type string
   */
  public function show($criteria, Request $request)
  {
    try {
      //Request to Repository
      $rangePoint = $this->rangePoint->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$rangePoint) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $rangePoint ? new RangePointTransformer($rangePoint) : '',
      ];

    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(Request $request)
  {

    \DB::beginTransaction();

    try{

      //Get data
      $data = $request['attributes'] ?? [];

      //Validate Request
      $this->validateRequestApi(new CreateRangePointRequest($data));

      //Create
      $rangePoint = $this->rangePoint->create($data);

      //Response
      $response = ["data" => new RangePointTransformer($rangePoint)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

        \Log::error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
    }

    return response()->json($response, $status ?? 200);

  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($criteria, Request $request)
  {
    try {

      \DB::beginTransaction();

      //Get data
      $data = $request['attributes'] ?? [];

      //Validate Request
      $this->validateRequestApi(new UpdateRangePointRequest($data));

      $params = $this->getParamsRequest($request);

      // Search entity
      $entity = $this->rangePoint->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $rangePoint = $this->rangePoint->update($entity,$data);

      $response = ['data' => new RangePointTransformer($rangePoint)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      
    }

    return response()->json($response, $status ?? 200);

  }


  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    try {

      //Get params
      $params = $this->getParamsRequest($request);

      // Search entity
      $entity = $this->rangePoint->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $this->rangePoint->destroy($entity);

      $response = ['data' => 'Item deleted'];

    } catch (\Exception $e) {

      \Log::Error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    return response()->json($response, $status ?? 200);
    
  }

}
