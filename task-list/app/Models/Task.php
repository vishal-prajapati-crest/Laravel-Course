<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description', 'long_description']; // Assign filable to the mentioned coloumns name in the array
    // protected $guarded =[]; // this will assign fillable to all other coloumn except this mentioned in array

    public function toggleComplete(){
        $this->completed = !$this->completed;
        $this->save();
    }
}
