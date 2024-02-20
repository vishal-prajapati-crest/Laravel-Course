<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Job::class);
        $filters = request()->only('search', 'min_salary', 'max_salary', 'experience', 'category');
        return view('job.index', ['jobs' => Job::with('employer')->filter($filters)->latest()->get()]);//filter data from filter scope in job model
    }

    public function show(Job $job)
    {
        $this->authorize('view', $job);
        $otherJobs = Job::where('employer_id', '=',$job->employer->id)->whereNot('id', '=' , $job->id)->get();
        return view('job.show', [
            'job' => $job->load('employer.jobs')
        ]);
    }

}
