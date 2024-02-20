<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Applicant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //check the user is authenticated and employer or not if not then move further else redirect to home page with error msg
        if($request->user() === null || $request->user()->employer === null){
            return $next($request);
        }
        return redirect()->route('jobs.index')->with('error','You are Employer');
    }
}
