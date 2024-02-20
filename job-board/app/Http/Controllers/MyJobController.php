<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', Job::class);
        $user = auth()->user()->employer->id;
        $jobs = Employer::findOrFail($user)->jobs()->with(['employer','jobApplications','jobApplications.user'])->latest()->get();
        // $jobs = $user->jobs()->with(['employer','jobApplications','jobApplications.user'])->get();
        return view('my_job.index', ['jobs' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create' , Job::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create' , Job::class);
        
        $validateData = $request->validate([
            'title'=> 'required|min:3|max:255',
            'description' => 'required',
            'location' => 'required',
            'salary' => 'required|numeric|min:1',
            'category' => 'required',
            'experience' => 'required'
        ]);

        Job::with('user.employer')->create([...$validateData,
        'employer_id' => auth()->user()->employer->id
]);

        return redirect()->route('my-jobs.index')->with('success','Job Posted Successfully!');
    }
    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update' , $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $myJob)
    {
        $this->authorize('update' , $myJob);
        $validateData = $request->validate([
            'title'=> 'required|min:3|max:255',
            'description' => 'required',
            'location' => 'required',
            'salary' => 'required|numeric|min:1',
            'category' => 'required',
            'experience' => 'required'
        ]);

        $myJob->update([...$validateData]);
        
        return redirect()->route('my-jobs.index')->with('success', 'Job Updated Successfully!');
    }
    
    public function getcv(Job $myJob,string $filename){
        // dd( $myJob);
        $this->authorize('getcv' , [$myJob, 'cvs/'.$filename]);

        $path = storage_path('app/private/cvs/' . $filename);
        // dd($path);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job  $myJob)
    {
        $this->authorize('delete' , $myJob);
        return $myJob;
    }
}
