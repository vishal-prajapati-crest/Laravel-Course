<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{
  public function loadRelationships(
    Model|QueryBuilder|EloquentBuilder|HasMany $for,
    ?array $relations = null
  ): Model|QueryBuilder|EloquentBuilder|HasMany
  {

    $relations = $relations ?? $this->relations ?? []; //In this if reelation array is pass then that will take if not then it will check the relation where trait is use else assgin empty array


    foreach ($relations as $relation) {
      $for->when(
          $this->shouldIncludeRelation($relation),
          fn($q) => $for instanceof Model ? $for->load($relation) :$q->with($relation)
      );
    }

    return $for;

  }

  protected function shouldIncludeRelation(string $relation):bool 
    {
        $include = request()->query('include'); //it will auto fetch the cureent request query

        if(!$include){
            return false;
        }

        $relations = array_map('trim', explode(',', $include)); //convert the string into array and then remove white space from front and end
        

        return in_array($relation,$relations);

    }

}