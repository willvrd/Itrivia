<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateUserQuestionAnswerRequest;
use Modules\Itrivia\Http\Requests\UpdateUserQuestionAnswerAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\UserQuestionAnswerTransformer;

// Entities
use Modules\Itrivia\Entities\UserQuestionAnswer;

// Repositories
use Modules\Itrivia\Repositories\UserQuestionAnswerRepository;

//Support
use Illuminate\Support\Facades\Auth;

class UserQuestionAnswerApiController extends BaseApiController
{

  private $userQuestionAnswer;
  
  public function __construct(
    UserQuestionAnswerRepository $userQuestionAnswer
    )
  {
    $this->userQuestionAnswer = $userQuestionAnswer;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $userQuestionAnswers = $this->userQuestionAnswer->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => UserQuestionAnswerTransformer::collection($userQuestionAnswers)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($userQuestionAnswers)] : false;

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
      $userQuestionAnswer = $this->userQuestionAnswer->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$userQuestionAnswer) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $userQuestionAnswer ? new UserQuestionAnswerTransformer($userQuestionAnswer) : '',
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
      $this->validateRequestApi(new CreateUserQuestionAnswerRequest($data));

      //Get User ID
      //$user = \Auth::user();
      //$data["user_id"] = $user->id;

      //Create
      $userQuestionAnswer = $this->userQuestionAnswer->create($data);

      //Response
      $response = ["data" => new UserQuestionAnswerTransformer($userQuestionAnswer)];

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
      $this->validateRequestApi(new UpdateUserQuestionAnswerRequest($data));

      $params = $this->getParamsRequest($request);

      // Search entity
      $entity = $this->userQuestionAnswer->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $userQuestionAnswer = $this->userQuestionAnswer->update($entity,$data);

      $response = ['data' => new UserQuestionAnswerTransformer($userQuestionAnswer)];

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
      $entity = $this->userQuestionAnswer->getItem($criteria,$params);

      //Break if no found item
      if (!$entity) throw new \Exception('Item not found', 204);

      $this->userQuestionAnswer->destroy($entity);

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
