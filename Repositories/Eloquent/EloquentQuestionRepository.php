<?php

namespace Modules\Itrivia\Repositories\Eloquent;

use Modules\Itrivia\Repositories\QuestionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentQuestionRepository extends EloquentBaseRepository implements QuestionRepository
{

    public function getItemsBy($params)
    {

      // INITIALIZE QUERY
      $query = $this->model->query();

      // RELATIONSHIPS
      $defaultInclude = ['translations'];
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($defaultInclude, $params->include);
      $query->with(array_merge($defaultInclude, $params->include));

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
              })->orWhere('id', 'like', '%' . $filter->search . '%')
              ->orWhere('multiple', 'like', '%' . $filter->search . '%');
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
          
        //Order by
        if (isset($filter->order)) {
            $orderByField = $filter->order->field ?? 'created_at';//Default field
            $orderWay = $filter->order->way ?? 'desc';//Default way
            $query->orderBy($orderByField, $orderWay);//Add order to query
        }

         //add filter by trivia_id
        if (isset($filter->triviaId)){
          $query->where('trivia_id', $filter->triviaId);
        }

        //add filter by question_id
        if (isset($filter->questionId)){
          $query->where('question_id', $filter->questionId);
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

    public function updateBy($criteria, $data, $params = false){

        // INITIALIZE QUERY
        $query = $this->model->query();
    
        /*== FILTER ==*/
        if (isset($params->filter)) {
          $filter = $params->filter;

          //Update by field
          if (isset($filter->field))
            $field = $filter->field;
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
    
    
        if($model){
    
          $model->update($data);
          
        
        }
    
        return $model ?? false;
    }

    public function deleteBy($criteria, $params = false)
    {
      // INITIALIZE QUERY
      $query = $this->model->query();
  
      /*== FILTER ==*/
      if (isset($params->filter)) {
        $filter = $params->filter;

        if (isset($filter->field))//Where field
          $field = $filter->field;
      }
  
       /*== REQUEST ==*/
      $model = $query->where($field ?? 'id', $criteria)->first();
     
      if($model) {

        $model->delete();

      }

    }
    

}
