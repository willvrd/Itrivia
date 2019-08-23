<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateTriviaRequest;
use Modules\Itrivia\Http\Requests\UpdateTriviaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\TriviaTransformer;

// Entities
use Modules\Itrivia\Entities\Trivia;

// Repositories
use Modules\Itrivia\Repositories\TriviaRepository;

//Support
use Illuminate\Support\Facades\Auth;

class TriviaApiController extends BaseApiController
{

  private $trivia;
  
  public function __construct(
    TriviaRepository $trivia
    )
  {
    $this->trivia = $trivia;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $trivias = $this->trivia->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => TriviaTransformer::collection($trivias)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($trivias)] : false;

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
      $trivia = $this->trivia->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$trivia) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $trivia ? new TriviaTransformer($trivia) : '',
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
      $this->validateRequestApi(new CreateTriviaRequest($data));

      //Create
      $trivia = $this->trivia->create($data);

      //Response
      $response = ["data" => new TriviaTransformer($trivia)];

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
      $this->validateRequestApi(new UpdateTriviaRequest($data));

      $params = $this->getParamsRequest($request);

      $trivia = $this->trivia->updateBy($criteria,$data,$params);

      $response = ['data' => new TriviaTransformer($trivia)];

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

      $this->trivia->deleteBy($criteria,$params);

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
