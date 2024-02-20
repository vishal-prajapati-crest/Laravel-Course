<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;

class MyJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id); 
        $appliedJobs = $user->jobApplications()->with('job.employer')->latest()->get();
        return view('my_job_application.index',['appliedJobs' => $appliedJobs]);
    }

    //to use binding we need a same name as in route list like here {my_job_application} so name should be myJobApplication
    public function destroy(JobApplication $myJobApplication)
    {
        $myJobApplication->delete();
        return (redirect()->back()->with('success','Job Application Withdraw Successfully!'));

    }
}
