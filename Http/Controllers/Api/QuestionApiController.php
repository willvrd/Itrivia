<?php

namespace Modules\Itrivia\Http\Controllers\Api;

// Requests & Response
use Modules\Itrivia\Http\Requests\CreateQuestionRequest;
use Modules\Itrivia\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Itrivia\Transformers\QuestionTransformer;

// Entities
use Modules\Itrivia\Entities\Question;

// Repositories
use Modules\Itrivia\Repositories\QuestionRepository;

//Support
use Illuminate\Support\Facades\Auth;

class QuestionApiController extends BaseApiController
{

  private $question;
  
  public function __construct(
    QuestionRepository $question
    )
  {
    $this->question = $question;
    
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $questions = $this->question->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => QuestionTransformer::collection($questions)];
      
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($questions)] : false;

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
      $question = $this->question->getItem($criteria,$this->getParamsRequest($request));

      //Break if no found item
      if (!$question) throw new \Exception('Item not found', 204);

      $response = [
        'data' => $question ? new QuestionTransformer($question) : '',
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
      $this->validateRequestApi(new CreateQuestionRequest($data));

      //Create
      $question = $this->question->create($data);

      //Response
      $response = ["data" => new QuestionTransformer($question)];

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
      $this->validateRequestApi(new UpdateQuestionRequest($data));

      $params = $this->getParamsRequest($request);

      $question = $this->question->updateBy($criteria,$data,$params);

      $response = ['data' => new QuestionTransformer($question)];

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

      $this->question->deleteBy($criteria,$params);

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
