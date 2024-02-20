<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    
    public function create(Job $job)
    {
        //verify the user already applied for job or not to show apply button
        $this->authorize('apply', $job);
        return view('job_application.create', ['job' => $job]);
    }
    public function store(Request $request,Job $job)
    {
        $this->authorize('apply', $job);

        //validate the request
        $request->validate([
            'expected_salary' => 'required|integer|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:2048' //validate the file upload 2048kb = 2MB
        ]);

        //store the file in the file system i.e. for now storage/app/private/cvs also we can use same code for S3,etc.
        $file = $request->file('cv'); //get the file
        $path = $file->store('cvs','private'); //get the path

        $jobApplication = JobApplication::create([
            'user_id' => auth()->user()->id, //alternative $request->user()->id in this no need to auth as already use auth middleware
            'job_id' => $job->id,
            'expected_salary' => $request->expected_salary,
            'cv_path' => $path
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success','Applied successfully!');
    }
    public function destroy(string $id)
    {
        //
    }
}
