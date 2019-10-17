<?php

namespace Modules\Itrivia\Repositories\Eloquent;

use Modules\Itrivia\Repositories\TriviaRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
//Events media
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Ihelpers\Events\DeleteMedia;

class EloquentTriviaRepository extends EloquentBaseRepository implements TriviaRepository
{

    public function getItemsBy($params = false)
    {

      // INITIALIZE QUERY
      $query = $this->model->query();

       /*== RELATIONSHIPS ==*/
      if (in_array('*', $params->include)) {//If Request all relationships
        $query->with([]);
      } else {//Especific relationships
        $includeDefault = ['translations'];//Default relationships
        if (isset($params->include))//merge relations with default relationships
          $includeDefault = array_merge($includeDefault, $params->include);
        $query->with($includeDefault);//Add Relationships to query
      }

      // FILTERS
      if($params->filter) {
        $filter = $params->filter;

        //add filter by search
        if (isset($filter->search)) {
            //find search in columns
            $query->where(function ($query) use ($filter) {
              $query->whereHas('translations', function ($query) use ($filter) {
                $query->where('locale', $filter->locale)
                  ->where('title', 'like', '%' . $filter->search . '%');
              })->orWhere('id', 'like', '%' . $filter->search . '%');
            });
        }
        
        //add filter by date
        if (isset($filter->date)) {
          $date = $filter->date;//Short filter date
          $date->field = $date->field ?? 'created_at';
          if (isset($date->from))//From a date
              $query->whereDate($date->field, '>=', $date->from);
          if (isset($date->to))//to a date
              $query->whereDate($date->field, '<=', $date->to);
        }
          
        //add filter by status id
        if (isset($filter->status)){
            $query->where('status', $filter->status);
        }

         //Order by
        if (isset($filter->order)) {
          $orderByField = $filter->order->field ?? 'created_at';//Default field
          $orderWay = $filter->order->way ?? 'desc';//Default way
          $query->orderBy($orderByField, $orderWay);//Add order to query
        }

        //add filter by trivia_id
        if (isset($filter->triviaId)){
          $query->where('id', $filter->triviaId);
        }

        //Random
        if (isset($filter->random)) {
          $query->inRandomOrder();
        }

        //Get All Trivias where userId has voted
        if (isset($filter->userId)) {
          $userId = $filter->userId;
          $query->whereHas('userTrivias',function ($q) use($userId){
              $q->where('user_id',$userId);
          });
        }

        //Get Trivias by id
        if (isset($filter->include)) {
          $query->whereIn('id', $filter->include);
        }

        //Get Trivias exclude
        if (isset($filter->exclude)) {
          $query->whereNotIn('id', $filter->exclude);
        }

      }

      /*== FIELDS ==*/
      if (isset($params->fields) && count($params->fields))
        $query->select($params->fields);

      /*== REQUEST ==*/
      if (isset($params->page) && $params->page) {
        return $query->paginate($params->take);
      } else {
        $params->take ? $query->take($params->take) : false;//Take
        return $query->get();
      }
    
    }

    public function getItem($criteria, $params = false)
    {
      // INITIALIZE QUERY
      $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if (in_array('*', $params->include)) {//If Request all relationships
        $query->with([]);
      } else {//Especific relationships
        $includeDefault = ['translations'];//Default relationships
        if (isset($params->include))//merge relations with default relationships
          $includeDefault = array_merge($includeDefault, $params->include);
        $query->with($includeDefault);//Add Relationships to query
      }

      /*== FILTER ==*/
      if (isset($params->filter)) {

        $filter = $params->filter;

        // find translatable attributes
        $translatedAttributes = $this->model->translatedAttributes;

        if(isset($filter->field))
          $field = $filter->field;

        // filter by translatable attributes
        if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
          $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
            $query->where('locale', $filter->locale)
              ->where($field, $criteria);
          });
        else
          // find by specific attribute or by id
          $query->where($field ?? 'id', $criteria);

      }


      return $query->first();

    }

    public function create($data)
    {

      $trivia = $this->model->create($data);
      
      //Event to ADD media
      event(new CreateMedia($trivia, $data));

      return $trivia;

    }

    public function update($model,$data){

      $model->update($data);

       //Event to Update media
      event(new UpdateMedia($model, $data));

      return $model ?? false;

    }

    public function destroy($model){

      $model->delete();

      //Event to Delete media
      event(new DeleteMedia($model->id, get_class($model)));

    }


}
