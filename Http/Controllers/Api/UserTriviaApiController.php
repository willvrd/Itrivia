<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateUserTriviaRequest;
use Modules\Itrivia\Http\Requests\UpdateUserTriviaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\UserTriviaTransformer;

// Entities
use Modules\Itrivia\Entities\UserTrivia;

// Repositories
use Modules\Itrivia\Repositories\UserTriviaRepository;

//Support
use Illuminate\Support\Facades\Auth;

class UserTriviaApiController extends BaseApiController
{

  private $userTrivia;
  
  public function __construct(
    UserTriviaRepository $userTrivia
    )
  {
    $this->userTrivia = $userTrivia;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $userTrivias = $this->userTrivia->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => UserTriviaTransformer::collection($userTrivias)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($userTrivias)] : false;

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
      $userTrivia = $this->userTrivia->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$userTrivia) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $userTrivia ? new UserTriviaTransformer($userTrivia) : '',
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
      $this->validateRequestApi(new CreateUserTriviaRequest($data));

      //Create
      $userTrivia = $this->userTrivia->create($data);

      //Response
      $response = ["data" => new UserTriviaTransformer($userTrivia)];

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
      $this->validateRequestApi(new UpdateUserTriviaRequest($data));

      $params = $this->getParamsRequest($request);

      // Search entity
      $entity = $this->userTrivia->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $userTrivia = $this->userTrivia->update($entity,$data);

      $response = ['data' => new UserTriviaTransformer($userTrivia)];

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
      $entity = $this->userTrivia->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $this->userTrivia->destroy($entity);

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
