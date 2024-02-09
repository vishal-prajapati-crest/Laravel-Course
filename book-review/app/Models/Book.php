<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    public function reviews(){
        return $this->hasMany(Review::class);
    }


    // It will create a query builder that will fetch the the title like given string and to call this eg. \App\Models\Book::title('Facilis')->get();
    public function scopeTitle(Builder $query, string $title): Builder{
        return $query->where('title','LIKE', '%' . $title . '%');
    }

    //Get Popular Book according to the highest review book is popular
    public function scopePopular(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withCount([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ])->orderBy('reviews_count','desc');
    }

    //Get the highest rated book using avg of review rating
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder
    {
        return $query->withAvg([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ],'rating')->orderBy('reviews_avg_rating','desc');
    }

    //It will define Minimum review count
    public function scopeMinReviews(Builder $query, int $minReviews): Builder
    {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    //Get the book which is popular in last month using highest review count in last month along with highest review rating and minimum 2 review
    public function scopePopularLastMonth(Builder $query): Builder
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(2);
    }
   
    //Get the book which is popular in last 6 month using highest review count in last 6 month along with highest review rating and minimum 5 review
    public function scopePopularLast6Months(Builder $query): Builder
    {
        return $query->popular(now()->subMonths(6), now())
            ->highestRated(now()->subMonths(6), now())
            ->minReviews(5);
    }

    //It is similar with highest popular last month but in this first sort by rating then by reviews
    public function scopeHighestRatedLastMonth(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonth(), now())
        ->popular(now()->subMonth(), now())
        ->minReviews(2);
    }
    
    //It is similar with highest popular last 6 month but in this first sort by rating then by reviews
    public function scopeHighestRatedLast6Months(Builder $query): Builder
    {
        return $query->highestRated(now()->subMonths(6), now())
            ->popular(now()->subMonths(6), now())
            ->minReviews(5);
    }


    //It will filter the range in the query
    private function dateRangeFilter(Builder $query, $from = null, $to = null){
        if($from && !$to){
            $query->where('created_at','>=',$from); //If from is given only then return all the data after from date
        }elseif(!$from && $to){
            $query->where('created_at','<=',$to);   //If to is given only then return all the data before to date
        }elseif($from && $to){
            $query->whereBetween('created_at',[$from,$to]); // In between from and to

        }
    }

    protected static function booted(){
        static::updated(fn(Book $book)=> cache()->forget('book:'. $book->id));
        static::deleted(fn(Book $book)=> cache()->forget('book:'. $book->id));
        static::created(fn(Book $book)=> cache()->forget('book:'. $book->id));

    }
}
