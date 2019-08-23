<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateAnswerRequest;
use Modules\Itrivia\Http\Requests\UpdateAnswerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\AnswerTransformer;

// Entities
use Modules\Itrivia\Entities\Answer;

// Repositories
use Modules\Itrivia\Repositories\AnswerRepository;

//Support
use Illuminate\Support\Facades\Auth;

class AnswerApiController extends BaseApiController
{

  private $answer;
  
  public function __construct(
    AnswerRepository $answer
    )
  {
    $this->answer = $answer;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $answers = $this->answer->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => AnswerTransformer::collection($answers)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($answers)] : false;

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
      $answer = $this->answer->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$answer) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $answer ? new AnswerTransformer($answer) : '',
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
      $this->validateRequestApi(new CreateAnswerRequest($data));

      //Create
      $answer = $this->answer->create($data);

      //Response
      $response = ["data" => new AnswerTransformer($answer)];

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
      $this->validateRequestApi(new UpdateAnswerRequest($data));

      $params = $this->getParamsRequest($request);

      $answer = $this->answer->updateBy($criteria,$data,$params);

      $response = ['data' => new AnswerTransformer($answer)];

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

      $this->answer->deleteBy($criteria,$params);

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
