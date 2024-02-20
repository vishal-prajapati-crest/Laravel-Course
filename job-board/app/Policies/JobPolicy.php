<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }
    public function viewAnyEmployer(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Job $job): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->employer !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Job $job): bool|Response
    {

        if($job->employer->user_id !== $user->id){
            return false;
        }

        if($job->jobApplications()->count() >0){
            return response::deny('Cannot change the job with applications');
        }
        return  true;
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        if($job->employer->user_id !== $user->id){
            return false;
        }
        return  true;
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        if($job->employer->user_id !== $user->id){
            return false;
        }
        return  true;
        
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        if($job->employer->user_id !== $user->id){
            return false;
        }
        return  true;
        
    }

    //who can apply the job? user does not apply alerady
    public function apply(User $user, Job $job): bool
    {
        //Inside job model check wheather the user applied for the job or not
        return !$job->hasUserApplied($user) && !auth()->user()->employer;
        
    }

    public function getcv(User $user, Job $job, string $filename): bool|Response
    {

        // Check if the user is the employer of the job
        if ($job->employer->user_id !== $user->id) {
            return false;
        }
        

        // Check if the job has an application with the given CV path
        $application = $job->jobApplications->firstWhere(['cv_path' => $filename,
    'job_id' => $job->id]);
        if (!$application || $application->job_id !== $job->id) {
            return true;
        }

        return false;

        
    }
}
