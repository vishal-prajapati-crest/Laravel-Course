<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'location', 'salary', 'category','experience', 'employer_id'];

    //make experience & category array static so can be use anywhere
    public static array $experience = ['entry', 'intermediate', 'senior'];
    public static array $category = ['IT', 'Finance', 'Sales', 'Marketing'];

    public function hasUserApplied(Authenticatable | User | int $user): bool
    {
        
        return $this->where('id',$this->id) //check the job id is same or not
            ->whereHas(
                'jobApplications', //map the jobapplications relationship of Job model
                fn($query) => $query->where('user_id', '=', $user->id ?? $user) //check the user id same or not
            )->exists(); //return boolean value
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(\App\Models\JobApplication::class);
    }

    public function scopeFilter(Builder | QueryBuilder $query, array $filters): Builder | QueryBuilder
    { 
        return $query->when($filters['search'] ?? null, function ($query) use($filters){
            $query->where(function($query)use($filters){
                $query->where('title', 'LIKE' , '%'. $filters['search'] . '%')
                ->orWhere('description', 'LIKE' , '%'. $filters['search'] . '%')
                ->orWhereHas('employer', function($query)use($filters){
                    $query->where('company_name', 'LIKE' , '%'. $filters['search'] . '%');
                });
            });
            
        } )->when($filters['min_salary'] ?? null, function ($query) use($filters) {
            $query->where('salary', '>=' , $filters['min_salary']);
        })->when($filters['max_salary'] ?? null, function ($query) use($filters){
            $query->where('salary', '<=' , $filters['max_salary']);
        })->when($filters['experience'] ?? null, function($query)use($filters){
            $query->where('experience', '=' , $filters['experience']);
        })->when($filters['category'] ?? null, function($query)use($filters){
            $query->where('category', '=' , $filters['category']);
        });
    }
}
