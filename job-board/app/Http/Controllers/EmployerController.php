<?php

namespace App\Http\Controllers;


use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function __construct(){
        //this will match all the policy of the Employer model
        $this->authorizeResource(Employer::class);
    }
    
    public function create()
    {
        return view('employer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|min:1|unique:employers,company_name',
        ]);

        
        auth()->user()->employer()->create([
            'company_name' => $request->company_name
        ]);

        

        return redirect()->route('jobs.index')->with('success','You are now Employer!!');
    }

}
